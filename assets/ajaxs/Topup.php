<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once('../../class/class.smtp.php');
    require_once('../../class/PHPMailerAutoload.php');
    require_once('../../class/class.phpmailer.php');
    require_once('../../class/BanThe247.php');


    if($_POST['type'] == 'Topup')
    {
        if(empty($_SESSION['username']))
        {
            msg_error("Vui lòng đăng nhập để tiếp tục !", BASE_URL("Auth/Login"), 2000);
        }
        if($CMSNT->site('status_napdt') != 'ON')
        {
            msg_error2("Chức năng này đang bảo trì !");
        }
        if(empty($CMSNT->site('tk_banthe247')) || empty($CMSNT->site('mk_banthe247')))
        {
            msg_error2("Vui lòng điền tài khoản mật khẩu API!");
        }
        $loai = check_string($_POST['loai']);
        $amount = check_string($_POST['amount']);
        $sdt = check_string($_POST['sdt']);
        if(empty($sdt))
        {
            msg_error2("Vui lòng nhập số điện thoại cần nạp");
        }
        if(empty($amount))
        {
            msg_error2("Vui lòng chọn mệnh giá cần nạp");
        }
        if($amount <= 0)
        {
            msg_error2("Mệnh giá không hợp lệ !");
        }
        if(empty($loai))
        {
            msg_error2("Vui lòng chọn loại thuê bao");
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
        $banthe247->card = $sdt.':'.$amount.':'.$loai;
        $result = json_decode($banthe247->TopupMobile(), True);
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
                $subject = 'PHÁT HIỆN HACK/CHEAT KHI NẠP ĐIỆN THOẠI';
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
                <td>Số điện thoại nạp:</td>
                <td><b>'.$sdt.'</b></td>
                </tr>
                <tr>
                <td>Mệnh giá nạp:</td>
                <td><b style="color:blue;">'.format_cash($amount).'</b></td>
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
                    'noidung'       => 'Nạp tiền điện thoại số ('.$sdt.' mệnh giá '.format_cash($amount).')',
                    'username'      => $getUser['username']
                ));
                $CMSNT->insert("topup", [
                    'username'  => $getUser['username'],
                    'sdt'       => $sdt,
                    'amount'    => $amount,
                    'loai'      => $loai,
                    'gettime'   => gettime(),
                    'time'      => time()
                ]);
            } 
            msg_success("Giao dịch thành công !", "", 2000);
        }
    }