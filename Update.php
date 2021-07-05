<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");
    
    if(isset($_SESSION['username']) && $getUser['level'] == 'admin')
    {
        //CONFIG THÔNG SỐ
        define('filename', 'update_'.random('ABC123456789', 6).'.zip');
        define('serverfile', 'http://api.cmsnt.co/TRUMTHE.zip');
        // TIẾN HÀNH TẢI BẢN CẬP NHẬT TỪ SERVER VỀ 
        file_put_contents(filename, file_get_contents(serverfile));
        // TIẾN HÀNH GIẢI NÉN BẢN CẬP NHẬT VÀ GHI ĐÈ VÀO HỆ THỐNG
        $file = filename;
        $path = pathinfo(realpath($file), PATHINFO_DIRNAME);
        $zip = new ZipArchive;
        $res = $zip->open($file);
        if ($res === TRUE)
        {
            $zip->extractTo($path);
            $zip->close();
            // XÓA FILE ZIP CẬP NHẬT TRÁNH TỤI KHÔNG MUA ĐÒI XÀI FREE
            unlink(filename);
            // TIẾN HÀNH INSTALL DATABASE MỚI
            $query = file_get_contents(BASE_URL('install.php'));
            // XÓA FILE INSTALL DATABASE
            unlink('install.php');
            // GHI LOG
            $file = @fopen('logs/Update.txt', 'a');
            if ($file)
            {
                $data = "[UPDATE] Phiên cập nhật phiên bản gần nhất vào lúc ".gettime().PHP_EOL;
                fwrite($file, $data);
                fclose($file);
            }
            msg_success2("Tải bản cập nhật thành công");
        }
        else
        {
            msg_error2("Tải bản cập nhật thất bại");
        }
    }
	//XIn chào