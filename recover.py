import json, re

log_path = r'C:\Users\ACER\.gemini\antigravity\brain\1ac04169-86be-44ac-ab00-81c76b32e215\.system_generated\logs\overview.txt'

with open(log_path, 'r', encoding='utf-8', errors='ignore') as f:
    content = f.read()

# We will search the content for the literal file path marker, e.g. "File Path: `file:///c:/xampp/htdocs/ppdb_web/app/Views/admin/dashboard.php`"
# Then find the disclaimer, then the lines, until "The above content shows the entire"

def recover(filename):
    lines = content.split('\n')
    found_start = -1
    for i in reversed(range(len(lines))):
        if 'File Path: `file:///c:/xampp/htdocs/ppdb_web/app/Views/' + filename + '`' in lines[i] or \
           'File Path: `file:///C:/xampp/htdocs/ppdb_web/app/Views/' + filename + '`' in lines[i]:
            found_start = i
            break
            
    if found_start == -1:
        return False
        
    extracted = []
    capture = False
    for i in range(found_start, len(lines)):
        line = lines[i]
        if 'The following code has been modified' in line:
            capture = True
            continue
        if capture:
            if 'The above content shows the entire' in line:
                break
            match = re.match(r'^\d+:\s(.*)', line)
            if match:
                extracted.append(match.group(1))
            elif re.match(r'^\d+:$', line):
                extracted.append('')
                
    if extracted:
        with open(r'c:\xampp\htdocs\ppdb_web\app\Views\\' + filename, 'w', encoding='utf-8') as out:
            out.write('\n'.join(extracted))
        return True
    return False

for f in ['admin/dashboard.php', 'student/dashboard.php', 'auth/login.php', 'auth/register.php', 'student/_sidebar.php']:
    if recover(f):
        print("Recovered", f)
    else:
        print("Failed to recover", f)
