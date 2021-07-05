<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'LỊCH SỬ ĐỔI THẺ | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<?php
if(isset($_POST['btnTimKiem']))
{
    $daterangepicker = check_string($_POST['daterangepicker']);
    $daterangepicker = explode(' - ', $daterangepicker);
    //admin_msg_error($daterangepicker[0], "", 5000);
    $total_card = $CMSNT->num_rows(" SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' AND `username` = '".$getUser['username']."' ORDER BY id DESC ");
    $total_menhgia = $CMSNT->get_row(" SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' AND `username` = '".$getUser['username']."' ORDER BY id DESC ")['SUM(`menhgia`)'];
    $total_thucnhan = $CMSNT->get_row(" SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' AND `username` = '".$getUser['username']."' ORDER BY id DESC ")['SUM(`thucnhan`)'];
    $list_cardauto = $CMSNT->get_list(" SELECT * FROM `card_auto` WHERE `thoigian` >= '".$daterangepicker[0]."' AND `thoigian` <= '".$daterangepicker[1]."' AND `username` = '".$getUser['username']."' ORDER BY id DESC ");
}  
else
{
    $total_card = $CMSNT->num_rows(" SELECT * FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `username` = '".$getUser['username']."' ORDER BY id DESC ");
    $total_menhgia = $CMSNT->get_row(" SELECT SUM(`menhgia`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `username` = '".$getUser['username']."' ORDER BY id DESC ")['SUM(`menhgia`)'];
    $total_thucnhan = $CMSNT->get_row(" SELECT SUM(`thucnhan`) FROM `card_auto` WHERE `trangthai` = 'hoantat' AND `username` = '".$getUser['username']."' ORDER BY id DESC ")['SUM(`thucnhan`)'];
    $list_cardauto = $CMSNT->get_list(" SELECT * FROM `card_auto` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ");
}
?>
<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">Trang chủ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('History/Card');?>"><span itemprop="name">Lịch sử đổi
                        thẻ</span></a>
                <span itemprop="position" content="2"></span>
            </li>
        </ol>
    </div>
</div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container">

        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">LỊCH SỬ ĐỔI THẺ</h3>
                        </div>
                        <div class="card-body">
                            <p>Với các thẻ đang xử lý quý khách có thể <a href="javascript:location.reload()"><b
                                        class="text-danger"> nhấn vào đây </b></a> để cập nhật trạng thái của thẻ cào.
                            </p>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="daterangepicker" class="form-control float-right"
                                                id="reservationtime">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" name="btnTimKiem" class="btn btn-primary">
                                            <span>TÌM KIẾM</span></button>
                                    </div>
                                </div>
                            </form>
                            <ul>
                                <li>Tổng thẻ hợp lệ: <b style="green: red;"><?=format_cash($total_card);?></b></li>
                                <li>Tổng sản lượng thẻ: <b style="color: blue;"><?=format_cash($total_menhgia);?>đ</b>
                                </li>
                                <li>Tổng thực nhận: <b style="color: red;"><?=format_cash($total_thucnhan);?>đ</b></li>
                            </ul>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped table-hover">
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
                                        <?php $i = 0; foreach($list_cardauto as $row){ ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['loaithe'];?></td>
                                            <td><b style="color: green;"><?=format_cash($row['menhgia']);?></b></td>
                                            <td><b style="color: red;"><?=format_cash($row['thucnhan']);?></b></td>
                                            <td><?=$row['seri'];?></td>
                                            <td><?=$row['pin'];?></td>
                                            <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                            <td><span class="label label-primary"><?=$row['capnhat'];?></span></td>
                                            <td><?=status($row['trangthai']);?></td>
                                            <td><?=$row['ghichu'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
    $(function() {
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'YYYY/MM/DD/ hh:mm:ss'
            }
        })
        $("#datatable").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
    </script>



    <?php 
    require_once("../../public/client/Footer.php");
?>