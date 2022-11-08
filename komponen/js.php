<!--   Core JS Files   -->
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./assets/js/material-dashboard.min.js?v=3.0.4"></script>
<!-- Data Tables -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<!-- QR CODE Generator -->
<script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- Chart JS -->
<script src="./assets/js/plugins/chartjs.min.js"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "language": {
                "paginate": {
                    "previous": "‹",
                    "next": "›"
                },
                "emptyTable": "Data Kosong",
                "info": "",
                "infoFiltered": "",
                "infoEmpty": "",
                "lengthMenu": "Tampilkan _MENU_ Baris Data",
                "zeroRecords": "Pencarian Tidak Ditemukan...",
            },
        });
    });
</script>