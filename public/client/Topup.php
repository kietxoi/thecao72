<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'NẠP TIỀN ĐIỆN THOẠI | '.$CMSNT->site('tenweb');
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
                <a itemprop="item" href="<?=BASE_URL('Topup');?>"><span itemprop="name">Nạp tiền điện thoại</span></a>
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
                    <section class="row">
                        <div class="col-md-5">
                            <h4><span class="text-uppercase">Nạp tiền điện thoại tự động</span></h4>
                            <div class="form-group">
                                <label for="FormControlSelect">Số dư:</label>
                                <strong class="text-success"><?=format_cash($getUser['money']);?> VND</strong>
                                <input name="wallet" type="hidden" value="0015668184">
                            </div>
                            <div id="thongbao"></div>
                            <form>
                                <div class="form-group">
                                    <label for="sdt">Số điện thoại:</label>
                                    <input type="text" class="form-control" id="sdt"
                                        placeholder="Nhập số điện thoại cần nạp" value="">
                                </div>
                                <div class="form-group">
                                    <label for="amount">Chọn mệnh giá:</label>
                                    <select id="amount" class="charging-amount form-control">
                                        <option value="">--Mệnh giá--</option>
                                        <option value="10000">10,000đ</option>
                                        <option value="20000">20,000đ</option>
                                        <option value="30000">30,000đ</option>
                                        <option value="50000">50,000đ</option>
                                        <option value="100000">100,000đ</option>
                                        <option value="200000">200,000đ</option>
                                        <option value="300000">300,000đ</option>
                                        <option value="500000">500,000đ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Loại thuê bao:</label>
                                    <select id="loai" class="charging-amount form-control">
                                        <option value="">--Thuê bao--</option>
                                        <option value="TT">Trả trước</option>
                                        <option value="TS">Trả sau</option>
                                    </select>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" id="Topup" class="btn btn-lg btn-warning">Nạp ngay</button>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="col-md-12 table-responsive">
                            <h4><span class="text-uppercase">Lịch sử nạp điện thoại</span></h4>
                            <table id="datatable" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>SỐ ĐIỆN THOẠI</th>
                                        <th>MỆNH GIÁ</th>
                                        <th>LOẠI THUÊ BAO</th>
                                        <th>THỜI GIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `topup` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['sdt'];?></td>
                                        <td><?=format_cash($row['amount']);?></td>
                                        <td><?=$row['loai'];?></td>
                                        <td><?=$row['gettime'];?></td>
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
$("#Topup").on("click", function() {

    $('#Topup').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Topup.php");?>",
        method: "POST",
        data: {
            type: 'Topup',
            loai: $("#loai").val(),
            sdt: $("#sdt").val(),
            amount: $("#amount").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#Topup').html(
                    'Nạp ngay')
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