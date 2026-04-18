<?php
// 1. Calculate stats dynamically from the $users array passed by the controller
$totalUsers = count($users);
$suspendedUsers = 0;
foreach ($users as $u) {
    if ($u['is_suspended'] === 't' || $u['is_suspended'] === true) {
        $suspendedUsers++;
    }
}
$activeUsers = $totalUsers - $suspendedUsers;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ResearchHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Global Reset & Typography */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Inter', -apple-system, sans-serif; 
        }

        body { 
            background-color: #f1f5f9; 
            display: flex; 
            height: 100vh; 
            overflow: hidden; /* Locks the viewport */
        }
        
        /* --- SIDEBAR DESIGN --- */
        .sidebar { 
            width: 260px; 
            background: #0f172a; 
            color: white; 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            height: 100vh;
            flex-shrink: 0;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand { 
            font-size: 1.5rem; 
            font-weight: 800; 
            margin-bottom: 40px; 
            letter-spacing: -1px; 
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-nav-container {
            flex: 1;
            overflow-y: auto; /* Internal scroll if nav gets too long */
        }

        .nav-item { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 12px; 
            color: #94a3b8; 
            text-decoration: none; 
            border-radius: 10px; 
            margin-bottom: 5px; 
            transition: all 0.2s; 
            font-weight: 500;
            font-size: 0.9rem;
        }
        .nav-item.active { background: #1e293b; color: white; }
        .nav-item:hover { color: white; background: rgba(255,255,255,0.08); }

        .sidebar-footer {
            flex-shrink: 0;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* --- MAIN CONTENT AREA --- */
        .main-content { 
            flex: 1; 
            padding: 40px; 
            overflow-y: auto; 
            height: 100vh;
            -webkit-overflow-scrolling: touch;
        }

        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 35px; 
        }

        /* --- STAT CARDS --- */
        .stats-row { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px; 
            margin-bottom: 35px; 
        }
        .stat-card { 
            background: white; 
            padding: 24px; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0; 
            display: flex; 
            align-items: center; 
            gap: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .stat-icon { 
            width: 48px; 
            height: 48px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        /* --- TABLE DESIGN --- */
        .table-container { 
            background: white; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0; 
            overflow: hidden; 
            margin-bottom: 40px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead { background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        th { 
            padding: 18px 24px; 
            font-size: 0.75rem; 
            color: #64748b; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
            font-weight: 700; 
        }
        td { padding: 18px 24px; font-size: 0.9rem; border-bottom: 1px solid #f1f5f9; color: #1e293b; vertical-align: middle; }
        
        /* Badges */
        .badge { 
            padding: 6px 12px; 
            border-radius: 99px; 
            font-size: 0.7rem; 
            font-weight: 700; 
            text-transform: uppercase; 
            display: inline-block;
        }
        .badge-active { background: #dcfce7; color: #15803d; }
        .badge-suspended { background: #fee2e2; color: #b91c1c; }
        
        /* Action Button */
        .btn-action { 
            text-decoration: none; 
            font-size: 0.8rem; 
            font-weight: 600; 
            padding: 8px 16px; 
            border-radius: 8px; 
            transition: 0.2s; 
            border: 1px solid #e2e8f0; 
            color: #1e293b; 
            background: white;
            display: inline-flex;
            align-items: center;
        }
        .btn-action:hover { background: #f8fafc; border-color: #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

        /* Custom Scrollbar for Main Content */
        .main-content::-webkit-scrollbar { width: 8px; }
        .main-content::-webkit-scrollbar-track { background: transparent; }
        .main-content::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">ResearchHub</div>
        
        <div class="sidebar-nav-container">
            <nav>
                <a href="index.php?action=dashboard" class="nav-item active">
                    <i data-lucide="users" size="18"></i> Users
                </a>
                <a href="#" class="nav-item">
                    <i data-lucide="file-text" size="18"></i> Documents
                </a>
                <a href="#" class="nav-item">
                    <i data-lucide="settings" size="18"></i> Settings
                </a>
            </nav>
        </div>

        <div class="sidebar-footer">
            <a href="index.php?action=logout" class="nav-item" style="color: #f87171; margin-bottom: 0;">
                <i data-lucide="log-out" size="18"></i> Logout
            </a>
        </div>
    </aside>
<main style="max-width: 1100px; margin: 50px auto; padding: 0 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
        <div>
            <h1 style="margin: 0; font-size: 2rem; font-weight: 800; letter-spacing: -1px;">Master Hub</h1>
            <p style="color: #64748b; margin-top: 5px;">Manage your collection and discover global research.</p>
        </div>

        <div style="background: #f1f5f9; padding: 15px 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
            <div style="background: #3b82f6; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <i data-lucide="user" style="width: 20px;"></i>
            </div>
            <div>
                <span style="display: block; font-size: 0.7rem; text-transform: uppercase; color: #64748b; font-weight: 700;">Uploading as</span>
                <span style="font-weight: 600; font-size: 0.9rem; color: #1e293b;"><?= htmlspecialchars($_SESSION['user_email']) ?></span>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 40px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div id="drop-zone" style="border: 2px dashed #4A90E2; padding: 40px; border-radius: 12px; background: #f8fbff; text-align: center; cursor: pointer;">
                <i data-lucide="file-up" style="color: #4A90E2; width: 40px; height: 40px; margin-bottom: 10px;"></i>
                <p id="file-status" style="margin: 0; font-weight: 600;">Click to select PDF</p>
                <input type="file" id="file-input" hidden accept=".pdf">
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <input type="text" id="doc-title" placeholder="Document Title (Required)" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit;">
                <input type="text" id="doc-tags" placeholder="Tags (e.g., Finance, Tech)" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit;">
                
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" id="doc-public" style="width: 18px; height: 18px;"> 
                    <span>Make this research <strong>Public</strong> in the Global Hub</span>
                </label>

                <button id="upload-btn" style="background: #1e293b; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i data-lucide="send" style="width: 18px;"></i> Upload & Index
                </button>
            </div>
        </div>
        <div id="progress-bar" style="margin-top: 15px; font-size: 0.85rem; color: #3b82f6; display: none;">Processing...</div>
    </div>

    </main>

<script>
    lucide.createIcons();

    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const fileStatus = document.getElementById('file-status');
    const uploadBtn = document.getElementById('upload-btn');
    const progress = document.getElementById('progress-bar');

    let selectedFile = null;

    dropZone.onclick = () => fileInput.click();

    fileInput.onchange = (e) => {
        if (e.target.files.length > 0) {
            selectedFile = e.target.files[0];
            fileStatus.innerText = "Selected: " + selectedFile.name;
            dropZone.style.borderColor = "#10b981";
            dropZone.style.background = "#f0fdf4";
        }
    };

    uploadBtn.onclick = () => {
        const title = document.getElementById('doc-title').value;
        
        if (!selectedFile) {
            alert("Please select a PDF file first.");
            return;
        }
        if (!title) {
            alert("Please enter a document title.");
            return;
        }

        uploadBtn.disabled = true;
        uploadBtn.innerText = "Uploading...";
        progress.style.display = "block";

        const formData = new FormData();
        formData.append('document', selectedFile);
        formData.append('title', title);
        formData.append('tags', document.getElementById('doc-tags').value);
        formData.append('is_public', document.getElementById('doc-public').checked ? '1' : '0');

        fetch('index.php?action=upload-doc', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to see the new record in the table
            } else {
                alert("Upload failed: " + data.message);
                uploadBtn.disabled = false;
                uploadBtn.innerText = "Upload & Index";
            }
        })
        .catch(err => {
            console.error(err);
            uploadBtn.disabled = false;
            uploadBtn.innerText = "Upload & Index";
        });
    };
</script>

    <script>lucide.createIcons();</script>
</body>
</html>