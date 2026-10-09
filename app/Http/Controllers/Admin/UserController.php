<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $filter = $request->input('filter', 'all');

        $allowedFilters = [
            'all',
            'active',
            'inactive',
            'deleted',
        ];

        if (!in_array($filter, $allowedFilters, true)) {
            $filter = 'all';
        }

        if ($filter === 'deleted') {
            $usersQuery = User::onlyTrashed()->where('role', '!=', 'admin');
        } else {
            $usersQuery = User::query()->where('role', '!=', 'admin');

            if ($filter === 'active') {
                $usersQuery->where('status', true);
            }

            if ($filter === 'inactive') {
                $usersQuery->where('status', false);
            }
        }

        if ($search !== '') {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%")
                    ->orWhere('device', 'like', "%{$search}%")
                    ->orWhere('browser', 'like', "%{$search}%");

                if (is_numeric($search)) {
                    $query->orWhere('id', (int) $search);
                }
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        $users = $usersQuery
            ->oldest('id')
            ->paginate($perPage)
            ->withQueryString();

        $totalUsers = User::query()
            ->where('role', '!=', 'admin')
            ->count();

        $activeUsers = User::query()
            ->where('role', '!=', 'admin')
            ->where('status', true)
            ->count();

        $inactiveUsers = User::query()
            ->where('role', '!=', 'admin')
            ->where('status', false)
            ->count();

        $deletedUsers = User::onlyTrashed()
            ->where('role', '!=', 'admin')
            ->count();

        return view('admin.users.index', compact(
            'users',
            'search',
            'filter',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'deletedUsers'
        ));
    }

    public function create(): View
    {
        return view('admin.users.add');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'number' => ['required', 'string', 'digits:10', 'unique:users,number'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:15'],
            'status' => ['required', 'in:0,1'],
        ]);

        User::create([
            'name' => $request->name,
            'number' => $request->number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function show(int $id): View
    {
        $user = User::withTrashed()
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        return view('admin.users.view', compact('user'));
    }

    public function changeStatus(int $id): RedirectResponse
    {
        $user = User::query()
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        $user->status = !$user->status;
        $user->save();

        $message = $user->status
            ? 'User activated successfully.'
            : 'User deactivated successfully.';

        return back()->with('success', $message);
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = User::query()
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        $user->delete();

        return back()->with(
            'success',
            'User moved to deleted users successfully.'
        );
    }

    public function restore(int $id): RedirectResponse
    {
        $user = User::onlyTrashed()
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        $user->restore();

        return back()->with(
            'success',
            'User restored successfully.'
        );
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $user = User::onlyTrashed()
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        $user->forceDelete();

        return back()->with(
            'success',
            'User permanently deleted successfully.'
        );
    }

    public function exportPdf(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $filter = $request->input('filter', 'all');

        if ($filter === 'deleted') {
            $query = User::onlyTrashed()->where('role', '!=', 'admin');
        } else {
            $query = User::query()->where('role', '!=', 'admin');

            if ($filter === 'active') {
                $query->where('status', true);
            } elseif ($filter === 'inactive') {
                $query->where('status', false);
            }
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhere('number', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $query->latest()->get();

        $pdf = Pdf::loadView('admin.users.pdf', compact('users', 'filter'));
        return $pdf->download('users-export.pdf');
    }
}