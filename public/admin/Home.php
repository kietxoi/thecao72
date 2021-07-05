<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'DASHBROAD | '.$CMSNT->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>





<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-primary" type="button" data-toggle="modal"
                            data-target="#modal-default">CẬP NHẬT PHIÊN BẢN</button>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div id="thongbao"></div>
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?=$CMSNT->num_rows("SELECT * FROM `users` ");?></h3>
                        <p>Tổng thành viên</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->get_row("SELECT SUM(`money`) FROM `users` WHERE `money` > 0 ")['SUM(`money`)']);?>đ
                        </h3>
                        <p>Tổng số dư thành viên</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' "));?>
                        </h3>
                        <p>Thẻ cào hợp lệ</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' ")['SUM(`menhgia`)']);?>đ
                        </h3>
                        <p>Tổng tiền thẻ</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`menhgia`)']);?>đ
                        </h3>
                        <p>DOANH THU HÔM NAY</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->num_rows("SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY "));?>
                        </h3>
                        <p>SẢN LƯỢNG HÔM NAY</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->num_rows("SELECT DISTINCT `callback` FROM `card_auto` WHERE `callback` IS NOT NULL "));?>
                        </h3>
                        <p>WEBSITE ĐANG ĐẤU API</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?=format_cash($CMSNT->get_row("SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`menhgia`)'] - $CMSNT->get_row("SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= DATE(NOW()) AND `thoigian` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`thucnhan`)']);?>đ
                        </h3>
                        <p>LÃI RÒNG HÔM NAY</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>USERNAME</th>
                                        <th>SỐ TIỀN TRƯỚC</th>
                                        <th>SỐ TIỀN THAY ĐỔI</th>
                                        <th>SỐ TIỀN HIỆN TẠI</th>
                                        <th>THỜI GIAN</th>
                                        <th>NỘI DUNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `dongtien` ORDER BY id DESC LIMIT 500 ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><?=format_cash($row['sotientruoc']);?></td>
                                        <td><?=format_cash($row['sotienthaydoi']);?></td>
                                        <td><?=format_cash($row['sotiensau']);?></td>
                                        <td><span class="badge badge-dark"><?=$row['thoigian'];?></span></td>
                                        <td><?=$row['noidung'];?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>USERNAME</th>
                                        <th>SỐ TIỀN TRƯỚC</th>
                                        <th>SỐ TIỀN THAY ĐỔI</th>
                                        <th>SỐ TIỀN HIỆN TẠI</th>
                                        <th>THỜI GIAN</th>
                                        <th>NỘI DUNG</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>



<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập nhật phiên bản CARD24H V2</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Phiên bản hiện tại của bạn là <b style="color: blue;"><?=$config['version'];?></b> phiên bản mới nhất <b
                        style="color:red;"><?=file_get_contents('http://api.cmsnt.co/version.php?version=TRUMTHE');?></b>.</p>
                <p>1.1.4: Rút tiền về ví MOMO tự động.</p>
                        
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" id="update" class="btn btn-primary">Cập nhật ngay</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
$(document).ready(function() {
    setTimeout(e => {
        showlog()
    }, 1000)
});
function showlog() {
    $('#modal-default').modal({
        keyboard: true,
        show: true
    });
}
</script>


<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<script type="text/javascript">
$("#update").on("click", function() {
    $('#update').html('Đang tải bản cập nhật <div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("Update.php");?>",
        method: "POST",
        data: {
            type: 'update'
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#update').html(
                    'Cập nhật ngay')
                .prop('disabled', false);
        }
    });
});
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
    require_once("../../public/admin/Footer.php");
?>