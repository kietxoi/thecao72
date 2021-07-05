<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once('../../class/class.smtp.php');
    require_once('../../class/PHPMailerAutoload.php');
    require_once('../../class/class.phpmailer.php');


    if($_POST['type'] == 'ChuyenTien')
    {
        if(empty($_SESSION['username']))
        {
            msg_error("Vui lòng đăng nhập để tiếp tục !", BASE_URL("Auth/Login"), 2000);
        }
        if($CMSNT->site('status_chuyentien') != 'ON')
        {
            msg_error2("Chức năng này đang bảo trì !");
        }
        if($getUser['banned'] == 1)
        {
            msg_error2('Tài khoản bạn đang bị khóa');
        }
        $nguoinhan = check_string($_POST['nguoinhan']);
        $nguoichuyen = $_SESSION['username'];
        $sotien = check_string($_POST['sotien']);
        $lydo = check_string($_POST['lydo']);
        if(empty($nguoinhan))
        {
            msg_error2("Vui lòng nhập tài khoản người nhận");
        }
        if(empty($sotien))
        {
            msg_error2("Vui lòng nhập số tiền cần chuyển");
        }
        $row_nguoinhan = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '$nguoinhan' ");
        if($nguoinhan == $nguoichuyen)
        {
            msg_error2("Bạn không thể tự chuyển tiền cho bản thân");
        }
        if(!$row_nguoinhan)
        {
            msg_error2("Tài khoản người nhận không tồn tại trong hệ thống");
        }
        if($sotien < 10000)
        {
            msg_error2("Số tiền chuyển tối thiểu là: 10.000đ");
        }
        if($sotien > 20000000)
        {
            msg_error2("Số tiền chuyển tối đa là: 20.000.000đ");
        }
        if($sotien + $CMSNT->site('phi_chuyentien') > $getUser['money'])
        {
            msg_error2("Bạn cần ".$getUser['money'] - $sotien + $CMSNT->site('phi_chuyentien') ."đ nữa");
        }
        if($getUser['banned'] == 1)
        {
            msg_error2("Tài khoản của bạn đã bị khóa, không thể thực hiện giao dịch");
        }
        // Trừ tiền người chuyển
        $create = $CMSNT->tru("users", "money", $sotien + $CMSNT->site('phi_chuyentien'), " `username` = '$nguoichuyen' ");
        if($create)
        {
            // Ghi log người chuyển
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $sotien + $CMSNT->site('phi_chuyentien'),
                'sotiensau'     => $getUser['money'] - $sotien - $CMSNT->site('phi_chuyentien'),
                'thoigian'      => gettime(),
                'noidung'       => 'Chuyển tiền cho tài khoản ('.$nguoinhan.')',
                'username'      => $nguoichuyen
            ));

            // Cộng tiền người nhận
            $isCongTien = $CMSNT->cong("users", "money", $sotien, " `username` = '$nguoinhan' ");

            if($isCongTien)
            {
                // Ghi log người nhận
                $CMSNT->insert("dongtien", array(
                    'sotientruoc' => $row_nguoinhan['money'],
                    'sotienthaydoi' => $sotien,
                    'sotiensau' => $row_nguoinhan['money'] + $sotien,
                    'thoigian' => gettime(),
                    'noidung' => 'Nhận tiền từ tài khoản ('.$nguoichuyen.')',
                    'username' => $nguoinhan
                ));

                // Ghi log chuyển tiền
                $CMSNT->insert("chuyentien", [
                    'nguoinhan' => $nguoinhan,
                    'nguoichuyen' => $getUser['username'],
                    'sotien'    => $sotien,
                    'thoigian'  => gettime(),
                    'lydo'  => $lydo
                ]);

                $guitoi = $getUser['email'];   
                $subject = 'Biên lai chuyển tiền '.$CMSNT->site('tenweb').' ';
                $bcc = $CMSNT->site('tenweb');
                $hoten ='Client';
                $noi_dung = '<h2>Biên lai chuyển tiền</h2>
                <table>
                <tbody>
                <tr>
                <td>Tài khoản nhận tiền:</td>
                <td><b>'.$nguoinhan.'</b></td>
                </tr>
                <tr>
                <td>Số tiền chuyển:</td>
                <td><b style="color:blue;">'.format_cash($sotien).'đ</b></td>
                </tr>
                <tr>
                <td>Phí chuyển tiền:</td>
                <td><b>'.$CMSNT->site('phi_chuyentien').'%</b></td>
                </tr>
                <tr>
                <td>Tổng thanh toán</td>
                <td><b>'.format_cash($sotien + $CMSNT->site('phi_chuyentien')).'đ</b></td>
                </tr>
                <tr>
                <td>Thời giao dịch</td>
                <td><b style="color:red;">'.gettime().'</b></td>
                </tr>
                </tbody>
                </table>
                <i>Cảm ơn quý khách sử dụng dịch vụ !</i>';
                sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc); 
                
                msg_success2("Chuyển thành công số tiền ".format_cash($sotien)."đ cho ".$nguoinhan);
            }
        }
    }