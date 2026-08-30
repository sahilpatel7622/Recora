<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Maintenance | {{ $projectSettings->project_name ?? 'Folder Management' }}</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .maintenance-box {
            width: 100%;
            max-width: 520px;
            padding: 45px 30px;
            background: #ffffff;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.12);
        }

        .maintenance-icon {
            width: 85px;
            height: 85px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .maintenance-box h1 {
            color: #111827;
            font-size: 28px;
            margin-bottom: 14px;
        }

        .maintenance-box p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.7;
        }

        .maintenance-status {
            margin-top: 25px;
            padding: 11px 16px;
            border-radius: 10px;
            background: #fff7ed;
            color: #ea580c;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .maintenance-status i {
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 640px) {
            .maintenance-box {
                padding: 35px 20px;
            }

            .maintenance-icon {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }

            .maintenance-box h1 {
                font-size: 23px;
            }

            .maintenance-box p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="maintenance-box">

    <div class="maintenance-icon">
        <i class="fa-solid fa-screwdriver-wrench"></i>
    </div>

    <h1>Website Under Maintenance</h1>

    <p>
        We are currently performing maintenance on the website.
        Please wait for a few moments and try again shortly.
    </p>

    <div class="maintenance-status">
        <i class="fa-solid fa-rotate"></i>
        Maintenance in progress
    </div>

</div>

<script>
async function checkMaintenanceStatus() {
    try {
        const response = await fetch('{{ route("maintenance.check") }}', {
            headers: {
                'Accept': 'application/json'
            },
            cache: 'no-store'
        });

        const data = await response.json();

        if (Number(data.status) === 0) {
            window.location.href = '{{ route("dashboard") }}';
        }
    } catch (error) {
        console.error('Maintenance check error:', error);
    }
}

setInterval(checkMaintenanceStatus, 2000);
</script>

</body>
</html>