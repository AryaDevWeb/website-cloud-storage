/**
 * uploadManager.js â€” Drag & drop, file/folder upload, per-file progress, cancel
 */
import { createFolder, uploadFile } from './api.js';
import { showToast } from './ui.js';
import { insertFile } from './fileManager.js';

let activeUploads = new Map();
let dragCount = 0;

const getCurrentFolderId = () => {
    const id = window.__CURRENT_FOLDER_ID__;
    return id === undefined || id === null || id === '' ? null : String(id).replace(/^f/, '');
};

const normalizeFolderId = (id) => {
    if (id === undefined || id === null || id === '' || id === 'null' || id === 'undefined') return null;
    return String(id).replace(/^f/, '');
};

const isVisibleInCurrentView = (folderId) => {
    return document.querySelector('[data-spa-explorer]')
        && (window.__FILE_SECTION__ || 'files') === 'files'
        && normalizeFolderId(folderId) === normalizeFolderId(getCurrentFolderId());
};

function getUploadUi() {
    return {
        panel: document.getElementById('upload-progress-panel'),
        list: document.getElementById('upload-progress-list'),
        title: document.getElementById('upload-progress-title'),
    };
}

function showUploadPanel(label) {
    const { panel, title } = getUploadUi();
    panel?.classList.remove('hidden');
    if (title) title.textContent = label;
}

function maybeHideUploadPanel() {
    const { panel, list } = getUploadUi();
    if (!list?.children.length) panel?.classList.add('hidden');
}

function createProgressRow(fileName) {
    const { list } = getUploadUi();
    const uid = 'u-' + Date.now() + '-' + Math.random().toString(36).slice(2, 6);
    const row = document.createElement('div');
    row.id = uid;
    row.className = 'px-4 py-3 border-b border-gray-100 flex items-center gap-3';
    row.innerHTML = `
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-800 truncate">${fileName}</p>
            <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden mt-1">
                <div class="upload-bar h-full bg-blue-600 rounded-full transition-all duration-200" style="width:0%"></div>
            </div>
        </div>
        <span class="upload-pct text-xs text-gray-400 shrink-0 w-8 text-right">0%</span>
        <button class="upload-cancel p-1 text-gray-400 hover:text-red-500 rounded transition-colors" aria-label="Cancel upload">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>`;
    list?.appendChild(row);
    return row;
}

function uploadSingleFile(file, folderId, { showItemToast = true } = {}) {
    return new Promise((resolve, reject) => {
        const row = createProgressRow(file.name);
        const bar = row.querySelector('.upload-bar');
        const pct = row.querySelector('.upload-pct');
        const cancelBtn = row.querySelector('.upload-cancel');
        const uid = row.id;

        const handle = uploadFile(file, folderId, {
            onProgress(progress) {
                bar.style.width = progress + '%';
                pct.textContent = progress + '%';
            },
            onDone(newFile) {
                bar.classList.replace('bg-blue-600', 'bg-green-500');
                bar.style.width = '100%';
                pct.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                cancelBtn.classList.add('hidden');
                activeUploads.delete(uid);
                if (showItemToast) showToast(`"${file.name}" uploaded`, 'success');
                if (isVisibleInCurrentView(folderId)) insertFile(newFile);
                setTimeout(() => {
                    row.remove();
                    maybeHideUploadPanel();
                }, 3000);
                resolve(newFile);
            },
            onError(err) {
                bar.classList.replace('bg-blue-600', 'bg-red-500');
                pct.innerHTML = '<svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>';
                cancelBtn.classList.add('hidden');
                activeUploads.delete(uid);
                showToast(`Failed: "${file.name}" - ${err}`, 'error');
                reject(new Error(err));
            },
        });

        activeUploads.set(uid, handle);

        cancelBtn.addEventListener('click', () => {
            handle.abort();
            row.remove();
            activeUploads.delete(uid);
            maybeHideUploadPanel();
            reject(new Error('Upload cancelled'));
        });
    });
}

function processFiles(files, { folderId = getCurrentFolderId(), showItemToast = true } = {}) {
    if (!files.length) return Promise.resolve([]);

    showUploadPanel(`Uploading ${files.length} file(s)...`);
    return Promise.allSettled(
        files.map(file => uploadSingleFile(file, folderId, { showItemToast }))
    );
}

async function processFolderUpload(files) {
    if (!files.length) return;

    const currentFolderId = getCurrentFolderId();
    const folderMap = new Map([['', currentFolderId]]);
    const rootFolderName = files[0].webkitRelativePath.split('/')[0] || 'Folder';
    const folderPaths = [...new Set(
        files
            .map(file => file.webkitRelativePath.split('/').slice(0, -1).join('/'))
            .filter(Boolean)
    )].sort((a, b) => a.split('/').length - b.split('/').length);

    showUploadPanel(`Preparing folder "${rootFolderName}"...`);

    for (const folderPath of folderPaths) {
        const segments = folderPath.split('/');
        const name = segments[segments.length - 1];
        const parentPath = segments.slice(0, -1).join('/');
        const parentId = folderMap.get(parentPath) ?? currentFolderId;
        const createdFolder = await createFolder(name, parentId);
        folderMap.set(folderPath, createdFolder.id);

        if (folderPath === rootFolderName && isVisibleInCurrentView(currentFolderId)) {
            insertFile(createdFolder);
        }
    }

    const uploads = files.map(file => {
        const parentPath = file.webkitRelativePath.split('/').slice(0, -1).join('/');
        return {
            file,
            folderId: folderMap.get(parentPath) ?? currentFolderId,
        };
    });

    showUploadPanel(`Uploading folder "${rootFolderName}"...`);
    const results = await Promise.allSettled(
        uploads.map(({ file, folderId }) => uploadSingleFile(file, folderId, { showItemToast: false }))
    );

    const successCount = results.filter(result => result.status === 'fulfilled').length;
    const failureCount = results.length - successCount;

    if (successCount > 0) {
        showToast(
            failureCount
                ? `"${rootFolderName}" uploaded with ${failureCount} failed file(s)`
                : `"${rootFolderName}" uploaded successfully`,
            failureCount ? 'error' : 'success'
        );
    }
}

export function initDragDrop() {
    const overlay = document.getElementById('drop-overlay');

    window.addEventListener('dragenter', e => {
        e.preventDefault();
        dragCount++;
        overlay?.classList.remove('opacity-0', 'pointer-events-none');
    });

    window.addEventListener('dragleave', e => {
        e.preventDefault();
        dragCount--;
        if (dragCount <= 0) {
            dragCount = 0;
            overlay?.classList.add('opacity-0', 'pointer-events-none');
        }
    });

    window.addEventListener('dragover', e => e.preventDefault());

    window.addEventListener('drop', e => {
        e.preventDefault();
        dragCount = 0;
        overlay?.classList.add('opacity-0', 'pointer-events-none');
        if (e.dataTransfer.files.length) processFiles(Array.from(e.dataTransfer.files));
    });
}

export function initFileInput() {
    const fileInput = document.getElementById('file-input');
    const folderInput = document.getElementById('folder-input');
    if (!fileInput) return;

    document.querySelectorAll('[data-upload-trigger]').forEach(el => {
        el.addEventListener('click', () => fileInput.click());
    });

    document.querySelectorAll('[data-upload-folder-trigger]').forEach(el => {
        el.addEventListener('click', () => folderInput?.click());
    });

    fileInput.addEventListener('change', function () {
        if (this.files.length) processFiles(Array.from(this.files));
        this.value = '';
    });

    folderInput?.addEventListener('change', async function () {
        if (this.files.length) {
            try {
                await processFolderUpload(Array.from(this.files));
            } catch (error) {
                showToast(error.message || 'Failed to upload folder', 'error');
            }
        }
        this.value = '';
    });
}
