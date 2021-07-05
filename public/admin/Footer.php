<div id="thongbao"></div>





<script type="text/javascript">
function load_tinnhan()
{
    $.ajax({
        url: "<?=BASE_URL('assets/ajaxs/GetWithdraw.php');?>",
        type: "GET",
        dateType: "text",
        data: {},
        success: function(result) {
            $('#thongbao').html(result);
        }
    });
}
setInterval(function() { $('#thongbao').load(load_tinnhan()); }, 15000);
</script>


<!-- jQuery -->
<script src="<?=BASE_URL('template/');?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=BASE_URL('template/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=BASE_URL('template/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=BASE_URL('template/');?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=BASE_URL('template/');?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=BASE_URL('template/');?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=BASE_URL('template/');?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=BASE_URL('template/');?>plugins/moment/moment.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=BASE_URL('template/');?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>
<!-- Summernote -->
<script src="<?=BASE_URL('template/');?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=BASE_URL('template/');?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=BASE_URL('template/');?>dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=BASE_URL('template/');?>dist/js/pages/dashboard.js"></script>
<!-- bootstrap color picker -->
<script src="<?=BASE_URL('template/');?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Ekko Lightbox -->
<script src="<?=BASE_URL('template/');?>plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- DataTables -->
<script src="<?=BASE_URL('template/');?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
new ClipboardJS('.copy');
</script>
</body>

</html>