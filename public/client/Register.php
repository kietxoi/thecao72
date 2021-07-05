<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'ĐĂNG KÝ TÀI KHOẢN | '.$CMSNT->site('tenweb');
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
                <a itemprop="item" href="<?=BASE_URL('Auth/Register');?>"><span itemprop="name">Đăng ký</span></a>
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
                                        <h4>Đăng ký tài khoản</h4>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Tên đăng
                                                    nhập</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="username"
                                                        placeholder="Tên đăng nhập">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phoneOrEmail"
                                                    class="col-md-4 col-form-label text-md-right">Địa
                                                    chỉ
                                                    email</label>
                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control"
                                                        placeholder="Địa chỉ email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-md-4 col-form-label text-md-right">Mật
                                                    khẩu</label>
                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control"
                                                        placeholder="Mật khẩu">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" id="Register" class="btn btn-primary">
                                                        Đăng ký tài khoản
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
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
$("#Register").on("click", function() {

    $('#Register').html('ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("assets/ajaxs/Auth.php");?>",
        method: "POST",
        data: {
            type: 'Register',
            email: $("#email").val(),
            username: $("#username").val(),
            password: $("#password").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#Register').html(
                    'Đăng ký tài khoản')
                .prop('disabled', false);
        }
    });
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>