<!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="content-language" content="vi">
    <meta name="robots" content="index, follow'">
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <title><?=$title;?></title>
    <meta name="description" content="<?=$CMSNT->site('mota');?>">
    <meta name="keywords" content="<?=$CMSNT->site('tukhoa');?>">



    <!-- Open Graph data -->
    <meta property="og:title" content="<?=$CMSNT->site('tenweb');?>">
    <meta property="og:type" content="Website">
    <meta property="og:url" content="<?=BASE_URL('');?>">
    <meta property="og:image" content="<?=$CMSNT->site('anhbia');?>">
    <meta property="og:description" content="<?=$CMSNT->site('mota');?>">
    <meta property="og:site_name" content="<?=$CMSNT->site('tenweb');?>">
    <meta property="article:section" content="<?=$CMSNT->site('mota');?>">
    <meta property="article:tag" content="<?=$CMSNT->site('tukhoa');?>">
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="<?=$CMSNT->site('anhbia');?>">
    <meta name="twitter:site" content="@wmt24h">
    <meta name="twitter:title" content="<?=$CMSNT->site('tenweb');?>">
    <meta name="twitter:description" content="<?=$CMSNT->site('mota');?>">
    <meta name="twitter:creator" content="@wmt24h">
    <meta name="twitter:image:src" content="<?=$CMSNT->site('anhbia');?>">
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <link rel="shortcut icon" href="<?=$CMSNT->site('favicon');?>">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/font-awesome/css/all.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/ionicons2/css/ionicons.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/bootstrap/bootstrap.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/font-roboto/roboto.css"
        type="text/css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/OwlCarousel2/assets/owl.carousel.min.css"
        type="text/css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/OwlCarousel2/assets/owl.theme.default.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?=BASE_URL('template/trumthe/');?>assets/default/css/theme.css" type="text/css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/trumthe/');?>assets/default/libs/material-design-icons/css/material-icons.min.css">
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default/default.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- ĐƠN VỊ THIẾT KẾ WEB WWW.CMSNT.CO | ZALO: 0947838128 | FACEBOOK: FB.COM/NTGTANETWORK -->
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=BASE_URL('template/');?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?=BASE_URL('template/');?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=BASE_URL('template/');?>plugins/daterangepicker/daterangepicker.css">