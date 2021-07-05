<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'RÚT TIỀN | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>

<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">Trang chủ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('Withdraw');?>"><span itemprop="name">Rút tiền</span></a>
                <span itemprop="position" content="3"></span>
            </li>
        </ol>
    </div>
</div>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-12">
                <div class="row mainpage-wrapper">
                <div id="thongbao"></div>
                    <section class="row">
                        <div class="col-md-7">
                            <h4><span class="text-uppercase">Rút tiền</span></h4>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td>Chọn ví:</td>
                                        <td><select class="form-control" style="padding: 0px">
                                                <option value="">Số dư <?=$getUser['username'];?> - <?=format_cash($getUser['money']);?>đ</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền cần rút:</td>
                                        <td><input type="number" class="form-control" id="sotien"
                                                placeholder="Số tiền cần rút" value="">
                                            <small class="text-danger">Tối thiểu
                                                <?=format_cash($CMSNT->site('min_ruttien'));?>
                                                VND</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền chuyển:</td>
                                        <td>
                                            <div class="form-group">
                                                <label>Chọn ngân hàng (<a href="<?=BASE_URL('Localbank');?>">Thêm ngân
                                                        hàng</a>)</label>
                                                <select id="listbank" class="form-control" style="padding: 0px">
                                                    <option value="">Chọn ngân hàng</option>
                                                    <?php foreach($CMSNT->get_list(" SELECT * FROM `listbank` WHERE `username` = '".$getUser['username']."' ") as $bank) { ?>
                                                    <option value="<?=$bank['id'];?>"><?=$bank['nganhang'];?> |
                                                        <?=$bank['sotaikhoan'];?> | <?=$bank['chinhanh'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <button type="button" id="Withdraw" class="btn btn-info">Rút tiền
                                                ngay</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <h4><span class="text-uppercase">Phí rút tiền</span></h4>
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Loại</th>
                                        <th>VND</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Phí cố định</td>
                                        <td><?=getSite('phi_rut_tien');?> VND</td>
                                    </tr>
                                    <tr>
                                        <td>Tối đa số tiền rút trong ngày</td>
                                        <td>Không giới hạn</td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền rút tối thiểu</td>
                                        <td><?=format_cash(getSite('min_ruttien'));?> VND</td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền rút tối đa</td>
                                        <td>Không giới hạn</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="col-md-12 table-responsive">
                            <h4><span class="text-uppercase">Lịch sử rút tiền</span></h4>
                            <table id="datatable" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>MÃ GD</th>
                                        <th>SỐ TIỀN RÚT</th>
                                        <th>NGÂN HÀNG</th>
                                        <th>SỐ TÀI KHOẢN</th>
                                        <th>TÊN CHỦ TK</th>
                                        <th>THỜI GIAN TẠO</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>GHI CHÚ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `ruttien` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['magd'];?></td>
                                        <td><?=format_cash($row['sotien']);?></td>
                                        <td><?=$row['nganhang'];?></td>
                                        <td><?=$row['sotaikhoan'];?></td>
                                        <td><?=$row['chutaikhoan'];?></td>
                                        <td><span class="label label-danger"><?=$row['thoigian'];?></span></td>
                                        <td><?=display_ruttien_user($row['trangthai']);?></td>
                                        <td><?=$row['ghichu'];?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>

                        </div>
                    </section>


                </div>
            </div>

        </div>
    </div>
</section>

<script type="text/javascript">
$("#Withdraw").on("click", function() {

    $('#Withdraw').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Withdraw.php");?>",
        method: "POST",
        data: {
            type: 'Withdraw',
            sotien: $("#sotien").val(),
            listbank: $("#listbank").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#Withdraw').html(
                    'Rút tiền ngay')
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