import re

file_path = r'C:\Users\dell\Downloads\Recora\resources\views\layouts\admin.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Remove mobile button in navbar
content = re.sub(r'<button type="button"\s+class="admin-mobile-actions-btn"[\s\S]*?</button>', '', content)

# 2. Remove mobile actions panel completely (down to the overlay)
content = re.sub(r'<div class="admin-mobile-actions-panel" id="adminMobileActionsPanel">[\s\S]*?<div class="admin-mobile-actions-overlay"\s*id="adminMobileActionsOverlay"></div>', '', content)

# 3. Remove JS related to mobile
content = re.sub(r'var adminMobileActionsBtn[\s\S]*?closeAdminMobilePanel\n\);', '', content)
content = re.sub(r'var mobileMaintenanceBtn = document.getElementById\(\'mobileMaintenanceBtn\'\);', '', content)
content = re.sub(r'if \(mobileMaintenanceBtn\) \{[\s\S]*?\}', '', content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)
