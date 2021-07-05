<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ NGÂN HÀNG | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>
<?php
if(isset($_GET['delete']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $delete = check_string($_GET['delete']);
    $CMSNT->remove("bank", " `id` = '$delete' ");
    admin_msg_success("Xóa thành công", BASE_URL("Admin/Bank"), 300);
}

if(isset($_POST['btnThemNganHang']) && $getUser['level'] == 'admin') 
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $CMSNT->insert("bank", array(
        'name' => check_string($_POST['name']),
        'stk' => check_string($_POST['stk']),
        'logo' => check_string($_POST['logo']),
        'bank_name' => check_string($_POST['bank_name']),
        'ghichu' => check_string($_POST['ghichu'])
    ));
    admin_msg_success("Thêm thành công", '', 1000);
}

if(isset($_POST['btnSave']) && $getUser['level'] == 'admin') 
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $CMSNT->update("bank", array(
        'name' => check_string($_POST['name']),
        'stk' => check_string($_POST['stk']),
        'logo' => check_string($_POST['logo']),
        'bank_name' => check_string($_POST['bank_name']),
        'ghichu' => check_string($_POST['ghichu'])
    ), " `id` = '".check_string($_POST['id'])."' ");
    admin_msg_success("Lưu thành công", '', 1000);
}

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
                    <h1>Ngân hàng</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH MOMO, BANK AUTO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF Nạp tiền qua Bank</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_napbank" required>
                                        <option value="<?=$CMSNT->site('status_napbank');?>">
                                            <?=$CMSNT->site('status_napbank');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Bank Auto</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_bank" value="<?=$CMSNT->site('api_bank');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">API Momo Auto</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="api_momo" value="<?=$CMSNT->site('api_momo');?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nội dung nạp tiền</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="noidung_naptien"
                                            value="<?=$CMSNT->site('noidung_naptien');?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">DANH SÁCH THÔNG TIN THANH TOÁN</h3>
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
                                        <th>NGÂN HÀNG</th>
                                        <th>LOGO</th>
                                        <th>CHỦ TÀI KHOẢN</th>
                                        <th>STK</th>
                                        <th>LƯU Ý</th>
                                        <th width="20%">THAO TÁC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `bank` WHERE `id` IS NOT NULL ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$row['name'];?></td>
                                        <td><img src="<?=$row['logo'];?>" height="50px;" /></td>
                                        <td><?=$row['bank_name'];?></td>
                                        <td><?=$row['stk'];?></td>
                                        <td><?=$row['ghichu'];?></td>
                                        <td>
                                            <a type="button" href="#" data-toggle="modal"
                                                data-target="#Edit<?=$row['id'];?>" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i>
                                                <span>EDIT</span></a>
                                            <a type="button"
                                                href="<?=BASE_URL('public/admin/Bank.php?delete='.$row['id']);?>"
                                                class="btn btn-danger"><i class="fas fa-trash"></i>
                                                <span>DELETE</span></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="Edit<?=$row['id'];?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="defaultModalLabel">EDIT NGÂN HÀNG
                                                    </h4>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" name="name"
                                                                    placeholder="Nhập tên ngân hàng"
                                                                    class="form-control" value="<?=$row['name'];?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" name="logo"
                                                                    placeholder="Nhập link logo"
                                                                    value="<?=$row['logo'];?>" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" name="stk"
                                                                    placeholder="Nhập số tài khoản"
                                                                    value="<?=$row['stk'];?>" class="form-control"
                                                                    required>
                                                                <input type="hidden" name="id" value="<?=$row['id'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" name="bank_name"
                                                                    placeholder="Nhập tên chủ tài khoản"
                                                                    class="form-control" value="<?=$row['bank_name'];?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea class="form-control" name="ghichu"
                                                                    placeholder="Nhập ghi chú nếu có"
                                                                    rows="6"><?=$row['ghichu'];?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger waves-effect"
                                                            data-dismiss="modal"><span>ĐÓNG</span></button>
                                                        <button type="submit" name="btnSave"
                                                            class="btn btn-primary waves-effect"><span>LƯU
                                                                LẠI</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>NGÂN HÀNG</th>
                                        <th>LOGO</th>
                                        <th>CHỦ TÀI KHOẢN</th>
                                        <th>STK</th>
                                        <th>LƯU Ý</th>
                                        <th>THAO TÁC</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <a type="button" href="#" data-toggle="modal" data-target="#AddBank"
                            class="btn btn-info btn-block"><i class="fas fa-plus-circle"></i> <span>THÊM NGÂN
                                HÀNG</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">LỊCH SỬ NẠP BANK AUTO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>USERNAME</th>
                                        <th>MÃ GD</th>
                                        <th>MONEY</th>
                                        <th>NỘI DUNG</th>
                                        <th>THỜI GIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `bank_auto` WHERE `username` IS NOT NULL ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['username'];?></td>
                                        <td><?=$row['tid'];?></td>
                                        <td><?=$row['amount'];?></td>
                                        <td><?=$row['description'];?></td>
                                        <td><?=$row['time'];?></td>
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
                        <h3 class="card-title">LỊCH SỬ NẠP MOMO AUTO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>USERNAME</th>
                                        <th>MÃ GD</th>
                                        <th>SDT</th>
                                        <th>TÊN</th>
                                        <th>MONEY</th>
                                        <th>NỘI DUNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `momo` WHERE `username` IS NOT NULL ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['username'];?></td>
                                        <td><?=$row['tranId'];?></td>
                                        <td><?=$row['partnerId'];?></td>
                                        <td><?=$row['partnerName'];?></td>
                                        <td><?=$row['amount'];?></td>
                                        <td><?=$row['comment'];?></td>
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



<div class="modal fade" id="AddBank" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">THÊM NGÂN HÀNG</h4>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="name" placeholder="Nhập tên ngân hàng" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="logo" placeholder="Nhập link logo" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="stk" placeholder="Nhập số tài khoản" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="bank_name" placeholder="Nhập tên chủ tài khoản"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="ghichu" placeholder="Nhập ghi chú nếu có"
                                rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect"
                        data-dismiss="modal"><span>ĐÓNG</span></button>
                    <button type="submit" name="btnThemNganHang" class="btn btn-primary waves-effect"><span>THÊM
                            NGAY</span></button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable2").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php 
    require_once(__DIR__."/Footer.php");
?>