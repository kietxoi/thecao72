<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'KẾT NỐI API | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<?php 
if ( isset($_POST['btnChangeApiKey']) && isset($_SESSION['username']) )
{
  $random_key = random('QWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnm', 32);
  $CMSNT->update("users", [
      'token'   => $random_key
  ], " `username` = '".$getUser['username']."' ");
  msg_success("Thay api key thành công !", "", 0);
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
                <a itemprop="item" href="<?=BASE_URL('Api');?>"><span itemprop="name">Kết nối API</span></a>
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
                <div class="col-sm-12">
                    <div class="boxbody_tbl" id="doithe">
                        <div class="boxbody_top">
                            <h2><span>CHUỖI KHÓA API CỦA BẠN</span></h2>
                        </div>
                        <div class="boxbody_body">
                            <h3>API KEY của bạn là: <span class="label label-info copy" id="copyApiToken"
                                    data-clipboard-target="#copyApiToken"><?=$getUser['token'];?></span></h3><br>
                            <i>Vui lòng không cung cấp khóa API cho người khác để tránh trường hợp kẻ gian chiếm đoạt
                                tài
                                sản!</i>
                            <br><br>
                            <div class="form-group">
                                <button type="button" data-toggle="modal" data-target="#modalChangeApiKey"
                                    class="btn btn-primary">Thay Đổi API KEY</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">THÔNG TIN KẾT NỐI API</h3>
                        </div>
                        <div class="card-body">
                            <div id="thongbao"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phương thức GET:</label>
                                        <input type="text" class="form-control copy"
                                            value="<?=BASE_URL('');?>api/card-auto.php?type=VIETTEL&menhgia=10000&seri=10006139342354&pin=114384960423544&APIKey=<?=$getUser['token'];?>&callback=http://localhost/callback.php&content=1233"
                                            id="copyPostCard" data-clipboard-target="#copyPostCard" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Trong đó:</label>
                                        <h6><b style="color: blue;">type</b>:
                                        VIETTEL,VINAPHONE,MOBIFONE,ZING,GATE,VNMOBI.</h6>
                                        <h6><b style="color: blue;">menhgia</b>:
                                            10000,20000,30000,50000,100000,200000,300000,500000,1000000.</h6>
                                        <h6><b style="color: blue;">seri</b>: Seri thẻ.</h6>
                                        <h6><b style="color: blue;">pin</b>: Mã thẻ.</h6>
                                        <h6><b style="color: red;">APIKey</b>: APIKey của bạn.</h6>
                                        <h6><b style="color: red;">callback</b>: URL callback của bạn, ví dụ
                                            domain.com/callback.php.</h6>
                                        <h6><b style="color: green;">content</b>: Nội dung được gửi lên, ví dụ request
                                            id thẻ để
                                            nhận dạng thẻ khi gửi về.</h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Response</label>
                                    <textarea class="form-control" style="background:#222222;color:#8fdc33;" rows="10"
                                        readonly>
"data":
    "status": "Trạng thái thẻ, error hoặc success",
    "msg": "Thông báo trạng thái thẻ"
</textarea>
                                </div>
                                <div class="col-sm-12">
                                    <div class="boxbody_tbl" id="doithe">
                                        <div class="boxbody_top">
                                            <h3 class="card-title"><span>CALLBACK TRẢ VỀ</span></h3>
                                        </div>
                                        <div class="boxbody_body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Phương thức GET:</label>
                                                        <input type="text" class="form-control copy"
                                                            value="domaincuaban.com/callbakcuaban.php?content=noidungthe&status=trangthaithe&thucnhan=thucnhanthe"
                                                            id="copyCallback" data-clipboard-target="#copyCallback"
                                                            readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Trong đó:</label>
                                                        <h6><b style="color: blue;">content</b>: Request ID của bạn đưa
                                                            lên.
                                                        </h6>
                                                        <h6><b style="color: red;">status</b>: Trạng thái thẻ chúng tôi
                                                            gửi về callback của bạn.
                                                        </h6>
                                                        <h6><b style="color: pink;">thucnhan</b>: Thực nhận thẻ cào.
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Response</label>
                                                    <textarea class="form-control"
                                                        style="background:#222222;color:#8fdc33;" rows="10" readonly>
"data":
    "status": "Trạng thái thẻ được gửi về, error hoặc success",
    "content": "Nội dung mà bạn đã gửi lên lúc đầu (request id)"
    "thucnhan": "Thực nhận thẻ"
    "menhgiathuc": "Mệnh giá thực của thẻ"
</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalChangeApiKey" data-backdrop="static" data-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">XÁC NHẬN TẠO MỚI API KEY</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Chúng tôi cần bạn hiểu rằng chuỗi khóa API được sử dụng để tích hợp giữa hệ thống của
                                bạn và của
                                chúng
                                tôi. Vui lòng không tạo chuỗi khóa mới nếu bạn không hiểu điều gì đang xảy ra hoặc không
                                có sự
                                xác nhận
                                từ nhà phát triển của bạn.
                            </div>
                            <div class="modal-footer">
                                <form action="" method="POST">
                                    <button type="submit" name="btnChangeApiKey" class="btn btn-primary">XÁC
                                        NHẬN</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
    require_once("../../public/client/Footer.php");
?>