<?php 
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");

    if(isset($_GET['request_id']) && isset($_GET['callback_sign']))
    {
        $status = check_string($_GET['status']);
        $message = check_string($_GET['message']);
        $request_id = check_string($_GET['request_id']);
        $declared_value = check_string($_GET['declared_value']); //Giá trị khai báo
        $value = check_string($_GET['value']); //Giá trị thực của thẻ
        $amount = check_string($_GET['amount']); //Số tiền nhận được
        $code = check_string($_GET['code']);
        $serial = check_string($_GET['serial']);
        $telco = check_string($_GET['telco']);
        $trans_id = check_string($_GET['trans_id']); //Mã giao dịch bên chúng tôi
        $callback_sign = check_string($_GET['callback_sign']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        if(!$row)
        {
            $file = @fopen('callback.txt', 'a');
            if ($file)
            {
                $data = "[".gettime()."] Request ID không tồn tại".PHP_EOL;
                fwrite($file, $data);
            }
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            $file = @fopen('callback.txt', 'a');
            if ($file)
            {
                $data = "[".gettime()."] Thẻ này đã được xử lý rồi".PHP_EOL;
                fwrite($file, $data);
            }
            exit('Thẻ này đã được xử lý rồi');
        }
        if($callback_sign != md5($CMSNT->site('partner_key').$code.$serial))
        {
            $file = @fopen('callback.txt', 'a');
            if ($file)
            {
                $data = "[".gettime()."] Key xác minh không đúng".PHP_EOL;
                fwrite($file, $data);
            }
            exit('Key xác minh không đúng');
        }
        $file = @fopen('/logs/callback.txt', 'a');
        if ($file)
        {
            $data = "[".gettime()."] ".$message.PHP_EOL;
            fwrite($file, $data);
        }
        if($status == 1)
        {
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            if(isset($row['callback']))
            {
                curl_get($row['callback']."?content=".$row['request_id']."&status=hoantat&thucnhan=".$row['thucnhan']."&menhgiathuc=".$value);
            }
            exit('Thẻ đúng !');
        }
        else if($status == 2)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `loaithe` WHERE `type` = '$telco' ")['ck'];
            if ($menhgia <= '30000')
            {
                $ck = $ck + $CMSNT->site('ck_con');
            }
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            if(isset($row['callback']))
            {
                curl_get($row['callback']."?content=".$row['request_id']."&status=thatbai&thucnhan=".$thucnhan."&menhgiathuc=".$value);
            }
            exit('Thẻ sai mệnh giá !');
        }
        else
        {
            $CMSNT->update("card_auto", [
                'trangthai' => 'thatbai',
                'ghichu'    => $message,
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            if(isset($row['callback']))
            {
                curl_get($row['callback']."?content=".$row['request_id']."&status=thatbai&thucnhan=0"."&menhgiathuc=".$value);
            }
            exit('Thẻ không hợp lệ !');
        }
    }