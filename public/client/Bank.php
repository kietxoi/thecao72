<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'NẠP TIỀN | '.$CMSNT->site('tenweb');
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
                <a itemprop="item" href="<?=BASE_URL('Bank');?>"><span itemprop="name">Nạp tiền</span></a>
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
                        <div class="col-md-12">
                            <?php foreach($CMSNT->get_list(" SELECT * FROM `bank` WHERE `id` IS NOT NULL ") as $row) {?>
                            <div class="col-md-12 col-lg-6">
                                <div class="box" style="text-align: center;">
                                    <br>
                                    <!-- /.box-header -->
                                    <div class="box-body" style="border-style: solid;border-color: black;">
                                        <br>
                                        <img src="<?=$row['logo'];?>" height="50px;" />
                                        <br>
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right;">STK/SDT: </td>
                                                    <td style="text-align: left; color: #00cc99;">
                                                        <b><?=$row['stk'];?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">Chủ tài khoản:
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <b><?=$row['bank_name'];?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">Nội dung CK:
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <b
                                                            style="color:red;"><?=$CMSNT->site("noidung_naptien").$getUser['id'];?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b><?=$row['ghichu'];?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="col-sm-12 table-responsive">
                            <h4><span class="text-uppercase">Lịch sử nạp ví MoMo</span></h4>
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
                                    foreach($CMSNT->get_list(" SELECT * FROM `momo` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
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
                        <div class="col-sm-12 table-responsive">
                            <h4><span class="text-uppercase">Lịch sử nạp Bank</span></h4>
                            <table id="datatable1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>MÃ GD</th>
                                        <th>MONEY</th>
                                        <th>NỘI DUNG</th>
                                        <th>THỜI GIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `bank_auto` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['tid'];?></td>
                                        <td><?=$row['amount'];?></td>
                                        <td><?=$row['description'];?></td>
                                        <td><?=$row['time'];?></td>
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
    require_once("../../public/client/Footer.php");
?>