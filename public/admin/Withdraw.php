<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ RÚT TIỀN | '.$CMSNT->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>

<?php
if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý rút tiền</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH RÚT TIỀN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Số tiền rút tối thiểu</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="number" name="min_ruttien"
                                            value="<?=$CMSNT->site('min_ruttien');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Token ví MOMO (duyệt rút tiền về ví momo tự động)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="token_momo"
                                            value="<?=$CMSNT->site('token_momo');?>" placeholder="Để trống nếu muốn tắt chức năng này" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Password ví MOMO (duyệt rút tiền về ví momo tự động)</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="password_momo"
                                            value="<?=$CMSNT->site('password_momo');?>" placeholder="Để trống nếu muốn tắt chức năng này" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <i>Cách lấy Token ví MOMO vui lòng xem <a href="https://www.cmsnt.co/2021/04/huong-dan-ket-noi-nap-tien-tu-ong-qua.html" target="_blank">tại đây</a></i>
                            </div>
                            
                          
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU NGAY</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">YÊU CẦU RÚT TIỀN ĐỢI DUYỆT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>MÃ GD</th>
                                        <th>USERNAME</th>
                                        <th>SỐ TIỀN RÚT</th>
                                        <th>NGÂN HÀNG</th>
                                        <th>SỐ TÀI KHOẢN</th>
                                        <th>TÊN CHỦ TK</th>
                                        <th>THỜI GIAN TẠO</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>THAO TÁC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `ruttien` WHERE `trangthai` = 'xuly' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['magd'];?></td>
                                        <td><a href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><?=format_cash($row['sotien']);?></td>
                                        <td><?=$row['nganhang'];?></td>
                                        <td><?=$row['sotaikhoan'];?></td>
                                        <td><?=$row['chutaikhoan'];?></td>
                                        <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                        <td><?=display_ruttien($row['trangthai']);?></td>
                                        <td><a type="button"
                                                href="<?=BASE_URL('Admin/Withdraw/Edit/');?><?=$row['id'];?>"
                                                class="btn btn-primary"><i class="fas fa-edit"></i>
                                                <span>EDIT</span></a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">DANH SÁCH YÊU CẦU RÚT TIỀN</h3>
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
                                        <th>MÃ GD</th>
                                        <th>USERNAME</th>
                                        <th>SỐ TIỀN RÚT</th>
                                        <th>NGÂN HÀNG</th>
                                        <th>SỐ TÀI KHOẢN</th>
                                        <th>TÊN CHỦ TK</th>
                                        <th>THỜI GIAN TẠO</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>THAO TÁC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `ruttien` ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['magd'];?></td>
                                        <td><a href="<?=BASE_URL('Admin/User/Edit/'.getUser($row['username'], 'id'));?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><?=format_cash($row['sotien']);?></td>
                                        <td><?=$row['nganhang'];?></td>
                                        <td><?=$row['sotaikhoan'];?></td>
                                        <td><?=$row['chutaikhoan'];?></td>
                                        <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                        <td><?=display_ruttien($row['trangthai']);?></td>
                                        <td><a type="button"
                                                href="<?=BASE_URL('Admin/Withdraw/Edit/');?><?=$row['id'];?>"
                                                class="btn btn-primary"><i class="fas fa-edit"></i>
                                                <span>EDIT</span></a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>



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