<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'RÚT TIỀN | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-12">
                <div class="row mainpage-wrapper">
                    <section class="main">
                        <div class="row">
                            <div class="col-md-6 offset-6">
                                <h4><span class="text-uppercase">Thêm ngân hàng</span></h4>
                                <br>
                                <div class="card-body">
                                    <div id="thongbao"></div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Ngân hàng</label>
                                        <select id="nganhang" class="form-control" style="padding: 0px">
                                            <option value="">--- Chọn ngân hàng ---</option>
                                            <?=listbank();?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="account_num">Số tài khoản</label>
                                        <input type="text" class="form-control" id="sotaikhoan"
                                            placeholder="Số tài khoản" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="account_name">Chủ tài khoản</label>
                                        <input type="text" class="form-control" id="chutaikhoan"
                                            placeholder="Chủ tài khoản">
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Chi nhánh</label>
                                        <input type="text" class="form-control" id="chinhanh" placeholder="Chi nhánh">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" id="ThemNganHang" class="btn btn-primary">Thêm ngân
                                        hàng</button>
                                </div>
                            </div>
                            <div class="col-md-12 table-responsive">
                                <h4><span class="text-uppercase">Danh sách ngân hàng của bạn</span></h4>
                                <table id="datatable" class="table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>NGÂN HÀNG</th>
                                            <th>SỐ TÀI KHOẢN</th>
                                            <th>CHỦ TÀI KHOẢN</th>
                                            <th>CHI NHÁNH</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `listbank` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['nganhang'];?></td>
                                            <td><?=$row['sotaikhoan'];?></td>
                                            <td><?=$row['chutaikhoan'];?></td>
                                            <td><?=$row['chinhanh'];?></td>
                                            <td><button class="btn btn-danger btnDelete XoaListBank"
                                                    data-id="<?=$row['id'];?>">Xóa</button></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</section>

<script type="text/javascript">
$('.XoaListBank').on('click', function(e) {
    $('.XoaListBank').html('ĐANG XỬ LÝ').prop('disabled', true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Withdraw.php");?>",
        method: "POST",
        data: {
            type: 'XoaListBank',
            id: ($(this).attr("data-id"))
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('.XoaListBank').html(
                    'Xóa')
                .prop('disabled', false);
        }
    });
    return false;
});
</script>
<script type="text/javascript">
$("#ThemNganHang").on("click", function() {

    $('#ThemNganHang').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Withdraw.php");?>",
        method: "POST",
        data: {
            type: 'ThemNganHang',
            nganhang: $("#nganhang").val(),
            sotaikhoan: $("#sotaikhoan").val(),
            chutaikhoan: $("#chutaikhoan").val(),
            chinhanh: $("#chinhanh").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#ThemNganHang').html(
                    'Thêm ngân hàng')
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
    require_once("../../public/client/Footer.php");
?>