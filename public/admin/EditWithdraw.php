<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHỈNH SỬA ĐƠN RÚT TIỀN | '.$CMSNT->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>


<?php
/* BẢN QUYỀN THUỘC VỀ CMSNT.CO | NTTHANH LEADER NT TEAM */
if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $row = $CMSNT->get_row(" SELECT * FROM `ruttien` WHERE `id` = '".check_string($_GET['id'])."'  ");
    if(!$row)
    {
        admin_msg_error("Đơn rút tiền không tồn tại", BASE_URL(''), 500);
    }
}
else
{
    admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 0);
}

if(isset($_POST['btnSaveWithdraw']) && $getUser['level'] == 'admin' && $row)
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $trangthai = check_string($_POST['trangthai']);
    $ghichu    = check_string($_POST['ghichu']);
    
    if($row['trangthai'] == 'huy')
    {
        admin_msg_error("Đơn rút tiền này đã bị hủy không thể thay đổi trạng thái !", "", 2000);
    }
    if($trangthai == 'huy')
    {
        $isMoney = $CMSNT->cong("users", "money", $row['sotien'], " `username` = '".$row['username']."' ");
        if($isMoney)
        {
            $rowUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
            /* GHI LOG DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc' => $rowUser['money'],
                'sotienthaydoi' => $row['sotien'],
                'sotiensau' => $rowUser['money'] + $row['sotien'],
                'thoigian' => gettime(),
                'noidung' => 'Hủy đơn rút tiền (#'.$row['id'].')',
                'username' => $rowUser['username']
            ));
        }
    }
    $CMSNT->update("ruttien", [
        'trangthai' => $trangthai,
        'ghichu'    => $ghichu,
        'capnhat'   => gettime()
    ], " `id` = '".$row['id']."' ");

    admin_msg_success("Cập nhật trạng thái thành công !", "", 500);
}
?>




<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa đơn rút tiền</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CHỈNH SỬA ĐƠN RÚT TIỀN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['username'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Số tiền rút</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['sotien'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Ngân hàng</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['nganhang'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Số tài khoản</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['sotaikhoan'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Chủ tài khoản</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['chutaikhoan'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Chi nhánh</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['chinhanh'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Thời gian rút</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['thoigian'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Thời gian xử lý</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="inputEmail3"
                                            value="<?=$row['capnhat'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Trạng thái</label>
                                <div class="col-sm-10">
                                    <select class="custom-select" name="trangthai">
                                        <option value="<?=$row['trangthai'];?>"><?=display_ruttien($row['trangthai']);?>
                                        </option>
                                        <option value="xuly"><?=display_ruttien('xuly');?></option>
                                        <option value="hoantat"><?=display_ruttien('hoantat');?></option>
                                        <option value="huy"><?=display_ruttien('huy');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Ghi chú</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <textarea class="form-control" rows="5"
                                            name="ghichu"><?=$row['ghichu'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveWithdraw" class="btn btn-primary btn-block waves-effect">
                                <span>LƯU</span>
                            </button>
                            <a type="button" href="<?=BASE_URL('Admin/Withdraw');?>"
                                class="btn btn-danger btn-block waves-effect">
                                <span>TRỞ LẠI</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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