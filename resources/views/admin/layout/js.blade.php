<script>
    function toggleAdminSidebar() {
        document.getElementById('adminSidebar').classList.toggle('show');
    }

    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('adminSidebar');
        const toggle = document.querySelector('.admin-mobile-toggle');

        if (!sidebar || !toggle) return;

        const clickedInsideSidebar = sidebar.contains(event.target);
        const clickedToggle = toggle.contains(event.target);

        if (!clickedInsideSidebar && !clickedToggle && window.innerWidth <= 991) {
            sidebar.classList.remove('show');
        }
    });
</script>