<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");

    $data = $CMSNT->get_list("SELECT * FROM `ruttien` WHERE `trangthai` = 'xuly' ");

    foreach($data as $row)
    {
        exit("<script type='text/javascript'>VanillaToasts.create({
            title: 'Có đơn rút tiền cần xử lý #".$row['id']."',
            text: 'System by CMSNT.CO ',
            type: 'warning',
            icon: '".BASE_URL('assets/img/avt.jpg')."',
            positionClass: 'bottomRight'
            });</script>");
    };
    
    