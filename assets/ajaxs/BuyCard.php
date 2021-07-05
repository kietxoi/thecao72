<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once('../../class/class.smtp.php');
    require_once('../../class/PHPMailerAutoload.php');
    require_once('../../class/class.phpmailer.php');
    require_once('../../class/BanThe247.php');


    if($_POST['type'] == 'BuyCard')
    {
        if(empty($_SESSION['username']))
        {
            msg_error("Vui lòng đăng nhập để tiếp tục !", BASE_URL("Auth/Login"), 2000);
        }
        if($CMSNT->site('status_muathe') != 'ON')
        {
            msg_error2("Chức năng này đang bảo trì !");
        }
        if(empty($CMSNT->site('tk_banthe247')) || empty($CMSNT->site('mk_banthe247')))
        {
            msg_error2("Vui lòng điền tài khoản mật khẩu API!");
        }
        $telco = check_string($_POST['telco']);
        $amount = check_string($_POST['amount']);
        if(empty($telco))
        {
            msg_error2("Vui lòng chọn loại thẻ cần mua");
        }
        if(empty($amount))
        {
            msg_error2("Vui lòng chọn mệnh giá thẻ");
        }
        if($amount <= 0)
        {
            msg_error2("Mệnh giá không hợp lệ !");
        }
        if($amount > $getUser['money'])
        {
            msg_error2("Số dư không đủ vui lòng nạp thêm.");
        }
        /* CLASS BANTHE247.COM */
        $banthe247 = new BanThe247();
        $banthe247->username = $CMSNT->site('tk_banthe247');
        $banthe247->password = $CMSNT->site('mk_banthe247');
        $banthe247->security = $CMSNT->site('security_banthe247');
        $banthe247->card = $telco.':'.$amount.':1';
        $result = json_decode($banthe247->buycard(), True);
        /* CLASS BANTHE247.COM */
        if($result['errorCode'] != 0)
        {
            msg_error2($result['message']);
        }
        else
        {
            if($amount > $getUser['money'])
            {
                $guitoi = $CMSNT->site('email_admin');   
                $subject = 'PHÁT HIỆN HACK/CHEAT KHI MUA THẺ';
                $bcc = $CMSNT->site('tenweb');
                $hoten ='CMSNT.CO';
                $noi_dung = '<h2>Vui lòng xử lý thẻ này ngay</h2>
                <table>
                <tbody>
                <tr>
                <td>Tên tài khoản đăng nhập:</td>
                <td><b>'.$_SESSION['username'].'</b> (đã bị khóa bởi hệ thống)</td>
                </tr>
                <tr>
                <td>Loại Thẻ:</td>
                <td><b>'.$data[0]['Telco'].'</b></td>
                </tr>
                <tr>
                <td>Mệnh Giá:</td>
                <td><b style="color:blue;">'.format_cash($data[0]['Amount']).'</b></td>
                </tr>
                <tr>
                <td>SERI:</td>
                <td><b>'.$data[0]['Serial'].'</b></td>
                </tr>
                <tr>
                <td>PIN</td>
                <td><b>'.$data[0]['PinCode'].'</b></td>
                </tr>
                <tr>
                <td>Thời Gian Xử Lý</td>
                <td><b style="color:red;">'.gettime().'</b></td>
                </tr>
                </tbody>
                </table>';
                sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);


                // KHÓA TÀI KHOẢN HACKER
                $CMSNT->update("users", array(
                    'banned' => 1
                ), "username = '".$_SESSION['username']."' ");
                session_destroy();

                msg_error2("Tài khoản của bạn đã bị khóa vì sử dụng cố tình gian lận hệ thống.");
            }
            $isTru = $CMSNT->tru("users", "money", $amount, " `username` = '".$getUser['username']."' ");
            if($isTru)
            {
                // Dòng tiền
                $CMSNT->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'],
                    'sotienthaydoi' => $amount,
                    'sotiensau'     => $getUser['money'] - $amount,
                    'thoigian'      => gettime(),
                    'noidung'       => 'Mua thẻ ('.$CMSNT->type_muathe($telco).' mệnh giá '.format_cash($amount).')',
                    'username'      => $getUser['username']
                ));
                $data = json_decode($result['Data'], true);
                $CMSNT->insert("muathe", [
                    'username'  => $getUser['username'],
                    'Telco'     => $data[0]['Telco'],
                    'PinCode'   => $data[0]['PinCode'],
                    'Serial'    => $data[0]['Serial'],
                    'Amount'    => $data[0]['Amount'],
                    'Trace'     => $data[0]['Trace'],
                    'gettime'   => gettime(),
                    'time'      => time()
                ]);
            }

            $guitoi = $getUser['email'];   
            $subject = 'Đơn hàng mua thẻ '.$telco.' ';
            $bcc = $CMSNT->site('tenweb');
            $hoten ='Client';
            $noi_dung = '<h2>Thông tin chi tiết thẻ cào #'.$data[0]['Telco'].'</h2>
            <table>
            <tbody>
            <tr>
            <td>Loại Thẻ:</td>
            <td><b>'.$data[0]['Telco'].'</b></td>
            </tr>
            <tr>
            <td>Mệnh Giá:</td>
            <td><b style="color:blue;">'.format_cash($data[0]['Amount']).'</b></td>
            </tr>
            <tr>
            <td>SERI:</td>
            <td><b>'.$data[0]['Serial'].'</b></td>
            </tr>
            <tr>
            <td>PIN</td>
            <td><b>'.$data[0]['PinCode'].'</b></td>
            </tr>
            <tr>
            <td>Thời Gian Xử Lý</td>
            <td><b style="color:red;">'.gettime().'</b></td>
            </tr>
            </tbody>
            </table>
            <i>Cảm ơn quý khách!</i>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);  
            msg_success("Giao dịch thành công! (vui lòng đợi 2s)", "", 2000);
        }
    }