<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'XEM BÀI VIẾT | '.$CMSNT->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
?>
<?php
/* BẢN QUYỀN THUỘC VỀ CMSNT.CO | NTTHANH LEADER NT TEAM */
if(isset($_GET['id']))
{
    $row = $CMSNT->get_row(" SELECT * FROM `blogs` WHERE `id` = '".check_string($_GET['id'])."'  ");
    if(!$row)
    {
        admin_msg_error("Bài viết không tồn tại", BASE_URL(''), 500);
    }
    $CMSNT->cong("blogs", "view", 1, " `id` = '".$row['id']."' ");
}
else
{
    admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 0);
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
                <a itemprop="item" href="<?=BASE_URL('Blogs');?>"><span itemprop="name">Tin tức</span></a>
                <span itemprop="position" content="2"></span>
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?=BASE_URL('Blog/'.$row['id']);?>"><span
                        itemprop="name"><?=$row['title'];?></span></a>
                <span itemprop="position" content="2"></span>
            </li>
        </ol>
    </div>
</div>


<section class="main">
    <div class="section">
        <div class="container">
            <div class="col-sm-9">
                <div class="row mainpage-wrapper">
                    <div class="blockPage">
                        <div class="blockTitle">
                            <h1><?=$row['title'];?></h1>
                            <div class="info-meta">
                                <div class="info-inline"><i class="fa fa-clock-o"></i><?=$row['time'];?></div>
                                <div class="info-inline">
                                    <div class="fa fa-eye"></div> <?=$row['view'];?>
                                </div>
                            </div>
                            <hr>
                            <strong></strong>
                        </div>
                        <div class="blockContent">
                            <div class="blogItem detailContent">
                                <?=$row['content'];?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="sidebar">
                    <div class="row lineHorizontal">
                        <h4><span style="margin-left: 15px"><i class="fa fa-newspaper"></i> Tin mới</span></h4>
                    </div>
                    <div class="content-side">
                    <?php foreach($CMSNT->get_list("SELECT * FROM `blogs` WHERE `display` = 'SHOW' ORDER BY id DESC ") as $row) { ?>
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-sm-12">
                                <div><a href="<?=BASE_URL('Blog/'.$row['id']);?>"><strong><?=$row['title'];?></strong></a></div>
                                <small class="text-muted"><?=$row['time'];?></small>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php 
    require_once("../../public/client/Footer.php");
?>