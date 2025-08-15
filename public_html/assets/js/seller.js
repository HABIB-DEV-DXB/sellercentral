// public/assets/js/seller.js
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-container');
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('shifted');
}