<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    $(document).ready(function () {
        $('.keuangan-user-select').each(function () {
            const $select = $(this);

            $select.select2({
                placeholder: 'Cari nama atau NRP karyawan',
                allowClear: true,
                width: '100%',
                matcher: function (params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    const term = params.term.toLowerCase();
                    const text = (data.text || '').toLowerCase();
                    const name = $(data.element).data('name') || '';
                    const nrp = $(data.element).data('nrp') || '';
                    const email = $(data.element).data('email') || '';

                    if (
                        (name && name.toLowerCase().includes(term)) ||
                        (nrp && nrp.toLowerCase().includes(term)) ||
                        (email && email.toLowerCase().includes(term)) ||
                        text.includes(term)
                    ) {
                        return data;
                    }

                    return null;
                },
                language: {
                    noResults: function () {
                        return 'Karyawan tidak ditemukan';
                    }
                },
                templateResult: function (data) {
                    if (!data.id) {
                        return data.text;
                    }

                    const element = $(data.element);
                    const name = element.data('name') || '';
                    const nrp = element.data('nrp') || '-';
                    const email = element.data('email') || '';

                    return $(`
                        <div>
                            <strong>${name}</strong>
                            <div style="
                                font-size:12px;
                                color:#64748b;
                                margin-top:3px;
                            ">
                                NRP: ${nrp}
                                ${email ? ' | ' + email : ''}
                            </div>
                        </div>
                    `);
                },
                templateSelection: function (data) {
                    if (!data.id) {
                        return data.text;
                    }

                    const element = $(data.element);

                    return (
                        element.data('name') +
                        ' - ' +
                        'NRP: ' +
                        (element.data('nrp') || '-')
                    );
                }
            });
        });
    });
</script>