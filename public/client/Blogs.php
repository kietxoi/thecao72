<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'TIN TỨC | '.$CMSNT->site('tenweb');
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
                <a itemprop="item" href="<?=BASE_URL('Blogs');?>"><span itemprop="name">Tin tức</span></a>
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
                    <div class="blockContent">
                        <?php foreach($CMSNT->get_list("SELECT * FROM `blogs` WHERE `display` = 'SHOW' ") as $row) { ?>
                        <div class="blogItem normalCat">
                            <a class="cover" href="<?=BASE_URL('Blog/'.$row['id']);?>">
                                <img src="<?=$row['img'];?>" width="200" height="140" alt="<?=$row['title'];?>">
                            </a>
                            <div class="detail">
                                <a class="title"
                                    href="<?=BASE_URL('Blog/'.$row['id']);?>"><?=$row['title'];?></a>
                                <div class="info-meta">
                                    <span class="info-inline"><i class="fa fa-clock-o"></i><?=$row['view'];?> <i
                                            class="fas fa-eye"></i></span>
                                    <span class="info-inline"><i class="fa fa-calendar-o"></i><?=$row['time'];?></span>
                                </div>
                                <p></p>
                                <a href="<?=BASE_URL('Blog/'.$row['id']);?>"
                                    class="btn btn-viewmore">Xem chi tiết</a>
                            </div>
                        </div>
                        <?php }?>
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