<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");
    $title = 'HOME | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/public/client/Header.php");
    require_once(__DIR__."/public/client/Nav.php");
?>

<?php if(getSite('display_carousel') == 'ON') { ?>
<div id="myCarousel" class="carousel slider slide" data-ride="carousel"
    style="background: <?=$CMSNT->site('theme_color');?>">
    <div class="container slide">
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <div class="col-sm-6 pull-right"><img src="<?=BASE_URL('assets/img/');?>support.png"
                            alt="Tích hợp API gạch thẻ tự động cho Shop" /></div>
                    <div class="col-sm-6">
                        <div class="slide-text">
                            <h3 style="color: #ffffff">Tích hợp API gạch thẻ tự động cho Shop</h3>
                            <p class="hidden-xs" style="color: #ffffff">Cam kết không nuốt thẻ, không bảo trì, có nhân
                                viện trực hỗ trợ 24/24, rút tiền sau 1 phút. Hotline: <?=$CMSNT->site('hotline');?></p>
                            <a href="<?=BASE_URL('Ket-noi-api');?>" class="btn btn-warning text-uppercase hidden-xs">
                                Xem ngay </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="row">
                    <div class="col-sm-6 pull-right"><img src="<?=BASE_URL('assets/img/');?>payment.png"
                            alt="Đổi thẻ cào thành tiền mặt nhanh chóng - tiện lợi" /></div>
                    <div class="col-sm-6">
                        <div class="slide-text">
                            <h3 style="color: #ffffff">Đổi thẻ cào thành tiền mặt nhanh chóng - tiện lợi</h3>
                            <p class="hidden-xs" style="color: #ffffff">Gạch thẻ siêu rẻ chiết khấu 15 - 20%. Rút free
                                phí về các ngân hàng Nội địa Việt Nam, Ví điện tử Momo</p>
                            <a href="" class="btn btn-warning text-uppercase hidden-xs"> Đổi Thẻ Ngay </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<?php }?>

<section class="main">
    <div class="section">
        <div class="container">
            <div class="fullColumn">
                <br>
                <div class="blockContent">
                    <div class="tabpage tab">
                        <div class="tab-content col-md-12 p-0">
                            <section class="main">
                                <div class="blockContent">
                                    <div class=" right-seperate">
                                        <div class="card-game-panel">
                                            <h2 class="text-center" style="font-size: 30px">ĐỔI THẺ TỰ ĐỘNG</h2>
                                            <br>
                                            <?=$CMSNT->site('thongbao');?>
                                            <br>
                                            <div id="thongbao"></div>
                                            <div class="form-frontpage form-sm" style="margin-top: 20px;">
                                                <form>
                                                    <div class="row-group">
                                                        <div id="list-taythecham">
                                                            <div class="irow row row-group"
                                                                style="margin-bottom: 10px;">
                                                                <div class="col-sm-3 select">
                                                                    <select id="loaithe" class="telco form-control"></select>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <select id="menhgia"
                                                                        class="charging-amount form-control"></select>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input id="pin" class="form-control" type="text"
                                                                        placeholder="Mã thẻ">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input id="seri" class="form-control" type="text"
                                                                        placeholder="Seri">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear-fix"></div>
                                                        <div align="center" class="col-md-12">
                                                            <div class="clearfix"></div>
                                                            <button type="submit" id="NapTheAuto"
                                                                class="btn btn-warning btn-lg"><i class="fa fa-upload"
                                                                    aria-hidden="true"></i> NẠP NGAY
                                                            </button>
                                                        </div>
                                                        <input type="hidden" id="token" value="<?=$getUser['token'];?>">
                                                    </div>
                                                </form>
                                                <div class="clearfix"></div>
                                            </div>
                                            <?php if(isset($_SESSION['username'])) { ?>
                                            <br>
                                            <h2 class="text-center" style="font-size: 30px">LỊCH SỬ ĐỔI THẺ</h2>
                                            <br>
                                            <p>Với các thẻ đang xử lý quý khách có thể <a
                                                    href="javascript:location.reload()"><b class="text-danger"> nhấn vào
                                                        đây </b></a> để cập nhật trạng thái của thẻ cào.
                                            </p>
                                            <div class="table-responsive">
                                                <table id="datatable2"
                                                    class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>LOẠI THẺ</th>
                                                            <th>MỆNH GIÁ</th>
                                                            <th>THỰC NHẬN</th>
                                                            <th>SERI</th>
                                                            <th>PIN</th>
                                                            <th>THỜI GIAN</th>
                                                            <th>CẬP NHẬT</th>
                                                            <th>TRẠNG THÁI</th>
                                                            <th>GHI CHÚ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=0; foreach($CMSNT->get_list(" SELECT * FROM `card_auto` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row) { ?>
                                                        <tr>
                                                            <td><?=$i++;?></td>
                                                            <td><?=$row['loaithe'];?></td>
                                                            <td><b
                                                                    style="color: green;"><?=format_cash($row['menhgia']);?></b>
                                                            </td>
                                                            <td><b
                                                                    style="color: red;"><?=format_cash($row['thucnhan']);?></b>
                                                            </td>
                                                            <td><?=$row['seri'];?></td>
                                                            <td><?=$row['pin'];?></td>
                                                            <td><span
                                                                    class="label label-danger"><?=$row['thoigian'];?></span>
                                                            </td>
                                                            <td><span
                                                                    class="label label-primary"><?=$row['capnhat'];?></span>
                                                            </td>
                                                            <td><?=status($row['trangthai']);?></td>
                                                            <td><?=$row['ghichu'];?></td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <script>
                                            $(document).ready(function() {
                                                $('#datatable2').DataTable();
                                            });
                                            </script>
                                            <?php }?>
                                            <div class="tabpage" id="bang-phi" style="margin-top: 20px;">
                                                <br>
                                                <h2 class="text-center" style="font-size: 30px">BẢNG GIÁ ĐỔI THẺ
                                                </h2>
                                                <br>
                                                <table class="table table-bordered table-striped dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>LOẠI THẺ</th>
                                                            <th>CHIẾT KHẤU</th>
                                                            <th>TRẠNG THÁI</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; foreach($CMSNT->get_list(" SELECT * FROM `loaithe`  ORDER BY id DESC ") as $row){ ?>
                                                        <tr>
                                                            <td><?=$row['type'];?></td>
                                                            <td><?=$row['ck'];?>%</td>
                                                            <td><?=display_loaithe($row['ck']);?></td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <h2 class="text-center" style="font-size: 30px">TIN TỨC</h2>
                                            <?php foreach($CMSNT->get_list("SELECT * FROM `blogs` WHERE `display` = 'SHOW' ORDER BY id DESC limit 3 ") as $row) { ?>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                                <div class="thumbnail">
                                                    <a href="<?=BASE_URL('Blog/'.$row['id']);?>"><img
                                                            src="<?=$row['img'];?>" height="100px"
                                                            alt="<?=$row['title'];?>"></a>
                                                    <div class="caption">
                                                        <h5><a
                                                                href="<?=BASE_URL('Blog/'.$row['id']);?>"><?=$row['title'];?></a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                        </div>
</section>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<script type="text/javascript">
$("#NapTheAuto").on("click", function() {

    $('#NapTheAuto').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/NapThe.php");?>",
        method: "POST",
        data: {
            type: 'NapTheAuto',
            token: $("#token").val(),
            seri: $("#seri").val(),
            pin: $("#pin").val(),
            loaithe: $("#loaithe").val(),
            menhgia: $("#menhgia").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#NapTheAuto').html(
                    '<i class="fa fa-upload" aria-hidden="true"></i> NẠP NGAY')
                .prop('disabled', false);
        }
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(e => {
        GetCard24()
    }, 0)
});

function GetCard24() {
    $.ajax({
        url: "<?=BASE_URL('api/loaithe.php');?>",
        method: "GET",
        success: function(response) {
            $("#loaithe").html(response);
        }
    });
    $.ajax({
        url: "<?=BASE_URL('api/menhgia.php');?>",
        method: "GET",
        success: function(response) {
            $("#menhgia").html(response);
        }
    });

}
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
<?php 
    require_once(__DIR__."/public/client/Footer.php");
?>