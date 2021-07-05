<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");

    if(isset($_SESSION['username']))
    {
        foreach($CMSNT->get_list(" SELECT * FROM `card_auto` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC ") as $row)
        {
            $data['data'][] = [

                $row['loaithe'],
                '<b style="color: green;">'.format_cash($row['menhgia']).'</b>',
                '<b style="color: red;">'.format_cash($row['thucnhan']).'</b>',
                $row['seri'],
                $row['pin'],
                '<span class="label label-danger">'. $row['thoigian'].'</span>',
                '<span class="label label-primary">'. $row['capnhat'].'</span>',
                status($row['trangthai']),
                $row['ghichu']
            ];
        }
        echo json_encode($data);
    }
    