<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUÊN MẬT KHẨU | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
?>


<div class="heading-page">
    <div class="container">
        <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('');?>"><span itemprop="name">Trang chủ</span></a>
                <span itemprop="position" content="1"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('Auth/ForgotPassword');?>"><span itemprop="name">Quên mật khẩu</span></a>
                <span itemprop="position" content="2"></span>
            </li>
        </ol>
    </div>
</div>
<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-12">
                <div class="row mainpage-wrapper">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div id="thongbao"></div>
                                    <div class="card-header">
                                        <h4>Quên mật khẩu</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">Địa chỉ Email</label>
                                            <div class="col-md-6">
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Nhập địa chỉ email">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="button" id="ForgotPassword" class="btn btn-primary">
                                                    Xác minh ngay
                                                </button>
                                                <a class="btn btn-link"
                                                    href="<?=BASE_URL('Auth/Login');?>">
                                                    Quay lại 
                                                </a>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
$("#ForgotPassword").on("click", function() {

    $('#ForgotPassword').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Auth.php");?>",
        method: "POST",
        data: {
            type: 'ForgotPassword',
            email: $("#email").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#ForgotPassword').html(
                    'Xác minh ngay')
                .prop('disabled', false);
        }
    });
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>