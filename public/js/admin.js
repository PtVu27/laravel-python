// Dark Mode Toggle
const themeToggle = document.getElementById('themeToggle');
const html = document.documentElement;
const themeIcon = themeToggle ? themeToggle.querySelector('i') : null;

// Initialize dark mode from localStorage if available
if (localStorage.getItem('adminTheme') === 'dark') {
    html.setAttribute('data-bs-theme', 'dark');
    if (themeIcon) themeIcon.classList.replace('fa-moon', 'fa-sun');
}

if (themeToggle && themeIcon) {
    themeToggle.addEventListener('click', () => {
        if (html.getAttribute('data-bs-theme') === 'light') {
            html.setAttribute('data-bs-theme', 'dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
            localStorage.setItem('adminTheme', 'dark');
        } else {
            html.setAttribute('data-bs-theme', 'light');
            themeIcon.classList.replace('fa-sun', 'fa-moon');
            localStorage.setItem('adminTheme', 'light');
        }
    });
}

// Sidebar Toggle for Mobile
const toggleSidebar = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');

if (toggleSidebar && sidebar) {
    toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('show');
    });
}

// Drag & Drop Image Upload Logic
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const imgPreview = document.getElementById('imgPreview');
const dropZoneText = document.getElementById('dropZoneText');

if (dropZone && fileInput) {
    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFiles(e.dataTransfer.files[0]);
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length) handleFiles(this.files[0]);
    });

    function handleFiles(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if(imgPreview) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                }
                if(dropZoneText) {
                    dropZoneText.style.display = 'none';
                }
            }
            reader.readAsDataURL(file);
        }
    }
}
