<?php
/** 
 * @package TÍCH HỢP BANTHE247.COM
 * @author CMSNT.CO
 */

 class BanThe247
 {
    public $username;
    public $password;
    public $card;
    public $security;

    function login_buycard()
    {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded'
            )
        ));

        $token_card = file_get_contents('https://banthe247.com/v2/PayCard/DangNhap?userName='.$this->username.'&password='.$this->password.'&security='.$this->security, false, $context);
    
        if (!is_object(json_decode($token_card)))
        {
            return json_decode($token_card);
        }
        else
        {
            echo 'Không thể kết nối API';
            unset($token_card);
            die;
        }
    }

    function buycard()
    {
        $token_card = $this->login_buycard($this->username,$this->password);
        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Token: ".$token_card
        );
        $hd_card = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $header),
                'content' => ''
            )
        ));
        $json_card = file_get_contents('https://banthe247.com/v2/PayCards/TelcoPay/GetCards?msg='.$this->card, false, $hd_card);
        return $json_card;
    }

    function TopupMobile()
    {
        $token_card = $this->login_buycard($this->username,$this->password);
        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Token: ".$token_card
        );
        $hd_card = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $header),
                'content' => ''
            )
        ));
        $json_card = file_get_contents('https://banthe247.com/v2/PayCards/TelcoPay/TopupMobile?msg='.$this->card, false, $hd_card);
        return $json_card;
    }
 }