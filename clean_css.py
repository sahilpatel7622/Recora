import sys

file_path = r'C:\Users\dell\Downloads\Recora\public\css\admin.css'
with open(file_path, 'r', encoding='utf-8') as f:
    css = f.read()

new_css = ""
in_media = False
brace_count = 0

i = 0
while i < len(css):
    if css[i:i+6] == '@media':
        in_media = True
        brace_count = 0
        while css[i] != '{':
            i += 1
        brace_count = 1
        i += 1
        continue
    
    if in_media:
        if css[i] == '{':
            brace_count += 1
        elif css[i] == '}':
            brace_count -= 1
            if brace_count == 0:
                in_media = False
                i += 1
                continue
        i += 1
    else:
        new_css += css[i]
        i += 1

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_css)
