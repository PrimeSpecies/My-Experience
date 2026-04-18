<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Library | ResearchHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .bloomberg-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; margin-top: 20px; }
        .bloomberg-table th { text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        .bloomberg-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .mono { font-family: 'JetBrains Mono', monospace; color: #0f172a; }
        .tag-pill { background: #e2e8f0; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; margin-right: 4px; display: inline-block; }
        
        #action-bar { max-height: 0; overflow: hidden; opacity: 0; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        #action-bar.visible { max-height: 800px; opacity: 1; margin-bottom: 40px; }

        .input-field { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-family: 'Inter', sans-serif; box-sizing: border-box; }

        .toggle-container { display: flex; align-items: center; background: #f1f5f9; padding: 4px; border-radius: 10px; width: fit-content; }
        .toggle-btn { padding: 6px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: 0.2s; border: none; }
        .toggle-btn.active { background: white; color: #2563eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .toggle-btn.inactive { color: #64748b; background: transparent; }

        #drop-zone.dragover { background: #eff6ff !important; border-color: #3b82f6 !important; transform: translateY(-2px); }

        /* PREVIEW MODAL STYLES */
        #preview-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.9);
            z-index: 9999;
            backdrop-filter: blur(4px);
        }
        .modal-content {
            width: 90%; height: 90%;
            margin: 2% auto;
            background: white;
            border-radius: 12px;
            display: flex; flex-direction: column;
            overflow: hidden;
        }
        .modal-header {
            padding: 15px 25px;
            background: #f8f9fa;
            border-bottom: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
        }
    </style>
</head>
<body style="background-color: #f8f9fa; font-family: 'Inter', sans-serif; margin: 0; color: #1e293b;">
<?php if (isset($_GET['status']) && $_GET['status'] === 'bookmarked'): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        ✅ Research added to your private catalog!
    </div>
<?php endif; ?>
    <div id="preview-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="file-text" style="color: #3b82f6;"></i>
                    <span id="modal-title" class="mono" style="font-weight: 700;">Document Preview</span>
                </div>
                <button onclick="closePreview()" style="background: #fee2e2; color: #ef4444; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: 700;">Close Esc</button>
            </div>
            <iframe id="preview-frame" style="flex-grow: 1; border: none;" src=""></iframe>
        </div>
    </div>

    <nav style="background: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0;">
        <div style="font-weight: 800; font-size: 1.25rem; letter-spacing: -1px;">ResearchHub</div>
        <div style="display: flex; align-items: center; gap: 20px;">
            <span style="font-size: 0.85rem; color: #64748b;">Logged in as: <strong><?= htmlspecialchars($_SESSION['user_email'] ?? 'User') ?></strong></span>
            <a href="index.php?action=logout" style="color: #ef4444; text-decoration: none; font-weight: 600; font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; background: #fef2f2;">Logout</a>
        </div>
    </nav>

    <main style="max-width: 1100px; margin: 50px auto; padding: 0 20px;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;">
            <div>
                <h1 style="margin: 0; font-size: 2rem; font-weight: 800; letter-spacing: -1.5px;">Master Hub</h1>
                <p style="color: #64748b; margin: 5px 0 0; font-size: 1rem;">Manage your private library and community research.</p>
            </div>
            
            <div id="drop-zone" style="border: 2px dashed #cbd5e1; padding: 25px 50px; border-radius: 16px; background: white; cursor: pointer; transition: 0.3s; text-align: center;">
                <i data-lucide="upload-cloud" style="color: #3b82f6; width: 32px; height: 32px; margin-bottom: 8px;"></i>
                <div id="file-status" style="font-size: 0.9rem; font-weight: 700; color: #1e293b;">Drag PDF here or click to browse</div>
                <input type="file" id="file-input" hidden accept=".pdf">
            </div>
        </div>

        <div id="action-bar">
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="background: #eff6ff; padding: 8px; border-radius: 8px;"><i data-lucide="user" style="color: #3b82f6; width: 20px;"></i></div>
                        <div>
                            <span style="display: block; font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Authoring as</span>
                            <span class="mono" style="font-weight: 600; color: #1e293b;">@<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                        </div>
                    </div>
                    
                    <div style="text-align: right;">
                        <span style="display: block; font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">Privacy</span>
                        <div class="toggle-container">
                            <button type="button" id="private-btn" class="toggle-btn active" onclick="setPrivacy(false)">Private</button>
                            <button type="button" id="public-btn" class="toggle-btn inactive" onclick="setPrivacy(true)">Public</button>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px;">Paper Title</label>
                            <input type="text" id="doc-title" placeholder="Document Name" class="input-field">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px;">Short Description</label>
                            <textarea id="doc-desc" placeholder="What is this research about?" class="input-field" style="height: 100px; resize: none;"></textarea>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 8px;">Categories / Tags</label>
                            <input type="text" id="doc-tags" placeholder="e.g. Machine Learning, Q3 Analysis" class="input-field">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 15px; margin-top: 20px;">
                            <button onclick="resetUI()" style="background: none; border: none; color: #94a3b8; font-weight: 600; cursor: pointer; font-size: 0.9rem;">Discard</button>
                            <button id="upload-btn" style="background: #2563eb; color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 0.95rem;">
                                <i data-lucide="check" style="width: 18px;"></i> Publish to Library
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 40px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                <i data-lucide="globe" style="width: 20px; color: #3b82f6;"></i>
                <h2 style="font-size: 1.1rem; margin: 0; font-weight: 800;">Global Discovery</h2>
            </div>
            <table class="bloomberg-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Uploader</th>
                        <th>Tags</th>
                        <th>Uploaded</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publicFiles as $file): ?>
                    <tr>
                        <td class="mono" style="font-weight: 600;"><?= htmlspecialchars($file['title'] ?? 'Untitled') ?></td>
                        <td><span style="color: #64748b;">@</span><?= htmlspecialchars($file['username'] ?? 'Unknown') ?></td>
                        <td>
                            <?php 
                            $tags = explode(',', $file['tags'] ?? 'General');
                            foreach($tags as $tag): ?>
                                <span class="tag-pill"><?= htmlspecialchars(trim($tag)) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td class="mono"><?= date('M d, Y', strtotime($file['uploaded_at'] ?? 'now')) ?></td>
                        <td style="text-align: right; display: flex; justify-content: flex-end; gap: 12px;">
                            <button onclick="openPreview('<?= $file['id'] ?>', '<?= htmlspecialchars($file['title']) ?>')" style="background: none; border: none; cursor: pointer; padding: 0;">
                                <i data-lucide="eye" style="width: 18px; color: #3b82f6;"></i>
                            </button>
                            <a href="index.php?action=save-to-catalog&id=<?= $file['id'] ?>" title="Save to My Catalog">
                                <i data-lucide="bookmark-plus" style="width: 18px; color: #10b981;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <i data-lucide="lock" style="width: 20px; color: #10b981;"></i>
                <h2 style="font-size: 1.1rem; margin: 0; font-weight: 800;">Private Catalog</h2>
            </div>
            <?php if (empty($userFiles)): ?>
                <p style="text-align: center; color: #94a3b8; padding: 20px;">No private documents found.</p>
            <?php else: ?>
                <table class="bloomberg-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Document Name</th>
                            <th>Location</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userFiles as $item): ?>
                        <tr>
                            <td style="width: 40px;"><i data-lucide="file-text" style="width: 18px; color: #94a3b8;"></i></td>
                            <td style="font-weight: 600;"><?= htmlspecialchars($item['custom_display_name'] ?? $item['title']) ?></td>
                            <td class="mono" style="font-size: 0.75rem; color: #94a3b8;">
                                <?= ($item['folder_id']) ? 'FOLDER: ' . $item['folder_id'] : 'ROOT' ?>
                            </td>
                            <td style="text-align: right;">
                                <button onclick="openPreview('<?= $item['document_id'] ?>', '<?= htmlspecialchars($item['title']) ?>')" style="background: none; border: none; cursor: pointer;">
                                    <i data-lucide="maximize-2" style="width: 18px; color: #3b82f6;"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <script>
        lucide.createIcons();

        // [FE-05] PREVIEWER LOGIC
        function openPreview(id, title) {
            const modal = document.getElementById('preview-modal');
            const frame = document.getElementById('preview-frame');
            const titleEl = document.getElementById('modal-title');
            
            titleEl.innerText = title;
            frame.src = "index.php?action=view-doc&id=" + id;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scroll
        }

        function closePreview() {
            const modal = document.getElementById('preview-modal');
            const frame = document.getElementById('preview-frame');
            modal.style.display = 'none';
            frame.src = "";
            document.body.style.overflow = 'auto';
        }

        // Handle Escape key to close modal
        window.addEventListener('keydown', (e) => {
            if(e.key === "Escape") closePreview();
        });

        // (Previous Upload & UI Logic)
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const fileStatus = document.getElementById('file-status');
        const actionBar = document.getElementById('action-bar');
        const uploadBtn = document.getElementById('upload-btn');
        const titleInput = document.getElementById('doc-title');
        
        let isPublic = false;

        function setPrivacy(val) {
            isPublic = val;
            document.getElementById('public-btn').className = val ? 'toggle-btn active' : 'toggle-btn inactive';
            document.getElementById('private-btn').className = val ? 'toggle-btn inactive' : 'toggle-btn active';
        }

        dropZone.onclick = () => fileInput.click();
        dropZone.ondragover = (e) => { e.preventDefault(); dropZone.classList.add('dragover'); };
        dropZone.ondragleave = () => { dropZone.classList.remove('dragover'); };
        dropZone.ondrop = (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleSelection(e.dataTransfer.files[0]);
            }
        };

        fileInput.onchange = (e) => { if(e.target.files.length > 0) handleSelection(e.target.files[0]); };

        function handleSelection(file) {
            fileStatus.innerText = "Selected: " + file.name;
            titleInput.value = file.name.replace('.pdf', '');
            actionBar.classList.add('visible');
        }

        function resetUI() {
            fileInput.value = "";
            actionBar.classList.remove('visible');
            fileStatus.innerText = "Drag PDF here or click to browse";
        }

        uploadBtn.onclick = () => {
            const file = fileInput.files[0];
            if (!file || !titleInput.value) return;

            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<i data-lucide="loader" style="width:18px;"></i> Uploading...';
            lucide.createIcons();

            const formData = new FormData();
            formData.append('document', file);
            formData.append('title', titleInput.value);
            formData.append('description', document.getElementById('doc-desc').value);
            formData.append('tags', document.getElementById('doc-tags').value);
            formData.append('is_public', isPublic ? '1' : '0');

            fetch('index.php?action=upload-doc', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if(data.success) location.reload();
                else { 
                    alert(data.message); 
                    uploadBtn.disabled = false; 
                    uploadBtn.innerText = "Publish to Library"; 
                    lucide.createIcons();
                }
            });
        };
    </script>
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('msg') === 'success') {
        alert("✅ Added to your catalog!");
        
        // This line "cleans" the URL so a refresh won't show the alert again
        window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/[&?]msg=success/, ''));
    } else if (urlParams.get('msg') === 'error') {
        alert("❌ Failed to add to catalog.");
        
        // Clean error message too
        window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/[&?]msg=error/, ''));
    }
</script>
</body>
</html>