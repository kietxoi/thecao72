<footer class="footer" style="margin-top: 30px; background-color:<?=$CMSNT->site('theme_color');?>; color:#fff;">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div>
                        <h4><?=$CMSNT->site('tenweb');?></h4>
                        <p class="text-muted" style="color: #fff;"><?=$CMSNT->site('mota');?></p>
                        <p>Hotline: <strong><?=$CMSNT->site('hotline');?></strong></p>
                        <p>Email: <strong><?=$CMSNT->site('email');?></strong></p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="listFooter">
                                <div>
                                    <h3 class="title divider-bottom">Thông tin</h3>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li><a href="#" style="color: #fff;"><i class="material-icons list-style">fiber_manual_record</i>Làm
                                            việc: 8h30 - 22h
                                        </a></li>
                                    <li><a href="<?=$CMSNT->site('facebook');?>" style="color: #fff;"><i
                                                class="material-icons list-style">fiber_manual_record</i><?=$CMSNT->site('facebook');?>
                                        </a></li>
                                    <li><a href="#" style="color: #fff;"><i class="material-icons list-style">fiber_manual_record</i>Điều
                                            khoản
                                        </a></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright" style="color: #fff;">Bản quyền © <?=$CMSNT->site('tenweb');?>
            <div class="pull-right" style="color: #fff;">
                <a href="https://www.cmsnt.co/" target="_blank" style="color: #fff"> <span
                        style="margin-left: 10px; ">Developer by CMSNT.CO</span></a>
            </div>
        </div>

    </div>
</footer>
</div>

<?php if(!isset($_SESSION['thongbaonoi'])) { $_SESSION['thongbaonoi'] = True;?>
<!-- Modal -->
<div class="modal fade" id="thongbaonoi" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">THÔNG BÁO</h5>
            </div>
            <div class="modal-body">
                <?=$CMSNT->site('modal_thongbao');?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(e => {
        showlog()
    }, 1000)
});

function showlog() {
    $('#thongbaonoi').modal({
        keyboard: true,
        show: true
    });
}
</script>
<?php }?>

<?=getSite('script_live_chat');?>

<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
new ClipboardJS('.copy');
</script>
<script src="<?=BASE_URL('template/trumthe/');?>assets/default/libs/jquery/jquery.min.js"></script>
<script src="<?=BASE_URL('template/trumthe/');?>assets/default/libs/bootstrap/bootstrap.min.js"></script>
<script src="<?=BASE_URL('template/trumthe/');?>assets/default/libs/OwlCarousel2/owl.carousel.min.js"></script>
<script src="<?=BASE_URL('template/trumthe/');?>assets/default/js/main.min.js"></script>
<!-- DataTables -->
<script src="<?=BASE_URL('template/');?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- daterangepicker -->
<script src="<?=BASE_URL('template/');?>plugins/moment/moment.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/daterangepicker/daterangepicker.js"></script>
</body>
<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
</html>