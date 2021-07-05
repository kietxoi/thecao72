<?php
    require_once("../config/config.php");
    require_once("../config/function.php");

    if(getSite('token_momo') == '')
    {
        die('Vui lòng nhập token ví momo');
    }
    if(getSite('password_momo') == '')
    {
        die('Vui lòng nhập mật khẩu ví momo');
    }
    if(time() - $CMSNT->site('check_time_cron_pay_momo') < 50)
    {
        die('Không thể cron vào lúc này!');
    }
    $CMSNT->update("options", [
        'value' => time()
    ], " `name` = 'check_time_cron_pay_momo' ");


    function payment_momo($token, $sdtnguoinhan, $password, $money, $noidung)
    {
        $result = curl_get("https://api.web2m.com/TRANSFERAPIMOMO/".$token."/".$sdtnguoinhan."/".$password."/".$money."/".$noidung);
        $result = json_decode($result, true);
        $data = [];
        if($result['status'] == 200)
        {
            $data['msg'] = $result['msg'];
            $data['transId'] = $result['transId'];
            $data['status'] = $result['status'];
        }
        else
        {
            $data['msg'] = $result['msg'];
            $data['status'] = $result['status'];
            $data['transId'] = $result['transId'];
        }
        return $data;
    }


    // LẤY DANH SÁCH ĐƠN RÚT TIỀN VỀ VÍ MOMO ĐANG ĐỢI XỬ LÝ
    foreach($CMSNT->get_list("SELECT * FROM `ruttien` WHERE `trangthai` = 'xuly' AND `nganhang` = 'MOMO' ") as $ruttien)
    {
        if($ruttien['trangthai'] != 'xuly')
        {
            break;
        }
        $CMSNT->update("ruttien", [
            'trangthai'  => 'hoantat'
        ], " `id` = '".$ruttien['id']."' ");
        $noidung = $ruttien['magd'];
        $result1 = payment_momo(getSite('token_momo'), $ruttien['sotaikhoan'], getSite('password_momo'), $ruttien['sotien'], $noidung);
        if($result1['status'] == 200)
        {
            $CMSNT->update("ruttien", [
                'trangthai'  => 'hoantat'
            ], " `id` = '".$ruttien['id']."' ");
            break;
        }
        else
        {
            $CMSNT->update("ruttien", [
                'trangthai'  => 'xuly'
            ], " `id` = '".$ruttien['id']."' ");
        }
    }