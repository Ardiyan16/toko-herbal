<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>

<script src="<?php echo get_theme_uri('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js', 'adminlte'); ?>"></script>
<script src="<?php echo get_theme_uri('js/adminlte.js', 'adminlte'); ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= get_theme_uri('plugins/datatables/jquery.dataTables.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-responsive/js/dataTables.responsive.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-responsive/js/responsive.bootstrap4.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-buttons/js/dataTables.buttons.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-buttons/js/buttons.bootstrap4.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/jszip/jszip.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/pdfmake/pdfmake.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/pdfmake/vfs_fonts.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-buttons/js/buttons.html5.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-buttons/js/buttons.print.min.js', 'adminlte') ?>"></script>
<script src="<?= get_theme_uri('plugins/datatables-buttons/js/buttons.colVis.min.js', 'adminlte') ?>"></script>

<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<!-- Elapsed in {elapsed_time} times  -->
</body>

</html>