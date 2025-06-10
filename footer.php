</div>
<div id="scrollTopButton" style="display: none; position: fixed; bottom: 20px; right: 20px; cursor: pointer;">
    <button class="btn btn-primary"><i class="fas fa-chevron-up fa-2x"></i></button>
</div>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/script.js"></script>

<script>
    $(document).ready(function() {
        $('#editor').summernote({
            height: 300,
            lang: 'tr-TR',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['emoji']], // emoji butonu
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ]
        });
    });
</script>

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function() {
        $('.rakamInput').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $(".select2").select2();
        $('.dataTable').DataTable({
            "order": [],
            "language": {
                'url': '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json',
            }
        });
        $('.zeroTable').DataTable({
            "paging": false,
            "searching": false,
            "order": [],
            "language": {
                'url': '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json',
            }
        });
        $('.exportTable').DataTable({
            "dom": 'Bfrtip',
            "order": [],
            "language": {
                'url': '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json',
            },
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        $('.ozelTablo').DataTable({
            "pageLength": 20,
            "dom": 'Bfrtip',
            "order": [],
            "paging": true,
            "lengthMenu": [
                [5, 10, 20, 30, 50, 100, -1],
                [5, 10, 20, 30, 50, 100, "All"]
            ],
            "language": {
                'url': '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json',
            },
            "buttons": [
                'pageLength',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                } // Make first column not sortable
            ]
        });


        $('.customSummernote').summernote({
            placeholder: 'Metin giriniz..',
            tabsize: 2,
            height: 400
        });

    });
</script>
<script>
    $(document).ready(function() {
        var currentUrl = window.location.href;
        $(".submenu ul li a").each(function() {
            var linkHref = $(this).attr("href");
            if (currentUrl.indexOf(linkHref) !== -1) {
                $(this).addClass("active");
            }
        });
        $('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger(
            'click');
    });
</script>
<script>
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#scrollTopButton').fadeIn();
            } else {
                $('#scrollTopButton').fadeOut();
            }
        });
        $('#scrollTopButton').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 0);
            return false;
        });
    });
</script>
<?php include 'alerts.php'; ?>
</body>

</html>