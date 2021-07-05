<?php
    require_once("../config/config.php");
    require_once("../config/function.php");
    
    if($CMSNT->site('api_momo') == '')
    {
        die('Thiếu API');
    }
    if(time() - $CMSNT->site('check_time_cron_momo') < 50)
    {
        die('Không thể cron vào lúc này!');
    }
    $CMSNT->update("options", [
        'value' => time()
    ], " `name` = 'check_time_cron_momo' ");
    $token = $CMSNT->site('api_momo');
    $result = curl_get("https://api.web2m.com/historyapimomo1h/$token");
    $result = json_decode($result, true);
    foreach($result['momoMsg']['tranList'] as $data)
    {
        $partnerId      = $data['partnerId'];               // SỐ ĐIỆN THOẠI CHUYỂN
        $comment        = $data['comment'];                 // NỘI DUNG CHUYỂN TIỀN
        $tranId         = $data['tranId'];                  // MÃ GIAO DỊCH
        $partnerName    = $data['partnerName'];             // TÊN CHỦ VÍ
        $id             = parse_order_id($comment);         // TÁCH NỘI DUNG CHUYỂN TIỀN
        $amount         = $data['amount'];

        $file = @fopen('LogMOMO.txt', 'a');
        if ($file)
        {
            $data = "partnerId => $partnerId comment => $comment ($id) amount => $amount partnerName => $partnerName".PHP_EOL;
            fwrite($file, $data);
        }

        if ($id)
        {
            $row = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$id' ");
            if($row['id'])
            {
                if($CMSNT->num_rows(" SELECT * FROM `momo` WHERE `tranId` = '$tranId' ") == 0)
                {
                    $create = $CMSNT->insert("momo", array(
                        'tranId'        => $tranId,
                        'username'      => $row['username'],
                        'comment'       => $comment,
                        'time'          => gettime(),
                        'partnerId'     => $partnerId,
                        'amount'        => $amount,
                        'partnerName'   => $partnerName
                    ));
                    if ($create)
                    {
                        $isCheckMoney = $CMSNT->cong("users", "money", $amount, " `username` = '".$row['username']."' ");

                        if($isCheckMoney)
                        {
                            $CMSNT->cong("users", "total_money", $amount, " `username` = '".$row['username']."' ");
                            $CMSNT->insert("dongtien", array(
                                'sotientruoc'   => $row['money'],
                                'sotienthaydoi' => $amount,
                                'sotiensau'     => $row['money'] + $amount,
                                'thoigian'      => gettime(),
                                'noidung'       => 'Nạp tiền tự động qua ví MOMO ('.$tranId.')',
                                'username'      => $row['username']
                            ));
                        }
                    }
                }
            }
        }
    }