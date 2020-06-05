
<!-- jQuery -->
<script src="<?=URL?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=URL?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script src="<?=URL?>plugins/select2/js/select2.full.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=URL?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=URL?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=URL?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=URL?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=URL?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=URL?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=URL?>plugins/moment/moment.min.js"></script>
<script src="<?=URL?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=URL?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=URL?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=URL?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Admin App -->
<script src="<?=URL?>public/js/adminlte.js"></script>
<script src="<?=URL?>public/lib/tinymce/tinymce-4.8.1.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
<script>
    $('#myTable').DataTable({ "sPaginationType": "full_numbers" });
    $("#inputCategories").select2({
      width:'resolve',
      theme:'classic'
    });
</script>
</body>
</html>