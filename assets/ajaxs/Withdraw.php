<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once('../../class/class.smtp.php');
    require_once('../../class/PHPMailerAutoload.php');
    require_once('../../class/class.phpmailer.php');

    if($_POST['type'] == 'XoaListBank')
    {
        $id = check_string($_POST['id']);
        if(empty($_SESSION['username']))
        {
            msg_error("Vui lòng đăng nhập để tiếp tục !", BASE_URL("Auth/Login"), 2000);
        }
        if(empty($id))
        {
            msg_error2("Ngân hàng không tồn tại");
        }
        $CMSNT->remove("listbank", " `id` = '$id' ");
        msg_success("Xóa thành công !", "", 500);
    }
    if($_POST['type'] == 'ThemNganHang')
    {
        $nganhang = check_string($_POST['nganhang']);
        $sotaikhoan = check_string($_POST['sotaikhoan']);
        $chutaikhoan = check_string($_POST['chutaikhoan']);
        $chinhanh = check_string($_POST['chinhanh']);

        
        if(empty($nganhang))
        {
            msg_error2("Vui lòng chọn ngân hàng");
        }
        if(empty($sotaikhoan))
        {
            msg_error2("Vui lòng nhập số tài khoản");
        }
        if(empty($chutaikhoan))
        {
            msg_error2("Vui lòng nhập tên chủ tài khoản");
        }
        if($CMSNT->get_row(" SELECT * FROM `listbank` WHERE `username` = '".$getUser['username']."' AND `sotaikhoan` = '$sotaikhoan' "))
        {
            msg_error2("Bạn đã thêm ngân hàng này rồi");
        }
        $insert = $CMSNT->insert("listbank", [
            'nganhang'      => $nganhang,
            'sotaikhoan'    => $sotaikhoan,
            'chutaikhoan'   => $chutaikhoan,
            'chinhanh'      => $chinhanh,
            'username'      => $getUser['username']
        ]);

        if($insert)
        {
            msg_success2("Thêm ngân hàng thành công !");
        }
        else
        {
            msg_error2("Vui lòng thử lại");
        }
    }

    if($_POST['type'] == 'Withdraw' )
    {
        $sotien = check_string($_POST['sotien']);
        $listbank = check_string($_POST['listbank']);

        if(empty($_SESSION['username']))
        {
            msg_error("Vui lòng đăng nhập để tiếp tục !", BASE_URL("Auth/Login"), 2000);
        }
        if($sotien <= 0)
        {
            msg_error2("Vui lòng nhập số tiền hợp lệ !");
        }
        if($CMSNT->site('min_ruttien') > $sotien)
        {
            msg_error2("Rút tiền tối thiểu ".format_cash($CMSNT->site('min_ruttien')).'đ');
        }
        if(empty($listbank))
        {
            msg_error2("Vui lòng chọn ngân hàng cần rút về !");
        }
        if($sotien < $CMSNT->site('min_ruttien'))
        {
            msg_error2("Vui lòng rút tối thiểu ".format_cash($CMSNT->site('min_ruttien'))."đ");
        }
        if($getUser['money'] < $sotien)
        {
            msg_error2("Số dư của bạn không có nhiều như thế !");
        }
        $bank = $CMSNT->get_row(" SELECT * FROM `listbank` WHERE `id` = '$listbank' AND `username` = '".$getUser['username']."' ");
        if(!$bank)
        {
            msg_error2("Ngân hàng không hợp lệ !");
        }
        $isMoney = $CMSNT->tru("users", "money", $sotien, " `username` = '".$getUser['username']."' ");
        if($isMoney)
        {
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $sotien,
                'sotiensau'     => $getUser['money'] - $sotien,
                'thoigian'      => gettime(),
                'noidung'       => 'Rút tiền về ngân hàng ('.$bank['nganhang'].' | '.$bank['sotaikhoan'].')',
                'username'      => $getUser['username']
            ));
            $CMSNT->insert("ruttien", [
                'magd'          => random('QWERTYUIOPASDFGHJKZXCVBNM', 2).time(),
                'username'      => $getUser['username'],
                'sotien'        => $sotien,
                'nganhang'      => $bank['nganhang'],
                'sotaikhoan'    => $bank['sotaikhoan'],
                'chutaikhoan'   => $bank['chutaikhoan'],
                'chinhanh'      => $bank['chinhanh'],
                'thoigian'      => gettime(),
                'trangthai'     => 'xuly'
            ]);

            $guitoi = $CMSNT->site('email_admin');   
            $subject = 'THÔNG BÁO CÓ ĐƠN RÚT TIỀN ĐANG XỬ LÝ';
            $bcc = $CMSNT->site('tenweb');
            $hoten ='CMSNT.CO';
            $noi_dung = '<h2>Thông tin tài khoản rút tiền</h2>
            <table >
            <tbody>
            <tr>
            <td>Ngân Hàng:</td>
            <td><b>'.$bank['nganhang'].'</b></td>
            </tr>
            <tr>
            <td>Số Tài Khoản:</td>
            <td><b style="color:blue;">'.$bank['sotaikhoan'].'</b></td>
            </tr>
            <tr>
            <td>Chủ Tài Khoản:</td>
            <td><b>'.$bank['chutaikhoan'].'</b></td>
            </tr>
            <tr>
            <td>Số Tiền Rút</td>
            <td><b>'.format_cash($sotien).'</b></td>
            </tr>
            <tr>
            <td>Chi Nhánh:</td>
            <td><b>'.$bank['chinhanh'].'</b></td>
            </tr>
            <tr>
            <td>Username</td>
            <td><b style="color:red;">'.$getUser['username'].'</b></td>
            </tr>
            </tbody>
            </table>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);

            msg_success2("Rút tiền thành công, vui lòng đợi xử lý trong vài phút !");

        }
        else
        {
            msg_error2("Vui lòng thao tác lại !");
        }
    }