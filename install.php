<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");

   
    // INSERT DATABASE CHO BẢN CẬP NHẬT
    insert_options('check_time_cron_pay_momo', '0');
    insert_options('check_time_cron_momo', '0');
    insert_options('security_banthe247', '');

    $CMSNT->query("ALTER TABLE `ruttien` ADD `magd` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL AFTER `username` ");

    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = 'email_admin' "))
    {
        $CMSNT->insert("options", [
            'name'   => 'email_admin',
            'value' => ''
        ]);
    }
    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = 'display_carousel' "))
    {
        $CMSNT->insert("options", [
            'name'   => 'display_carousel',
            'value' => 'ON'
        ]);
    }
    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = 'phi_rut_tien' "))
    {
        $CMSNT->insert("options", [
            'name'   => 'phi_rut_tien',
            'value' => 0
        ]);
    }
    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = 'script_live_chat' "))
    {
        $CMSNT->insert("options", [
            'name'   => 'script_live_chat',
            'value' => ''
        ]);
    }
    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = 'token_momo' "))
    {
        $CMSNT->insert("options", [
            'name'   => 'token_momo',
            'value'  => ''
        ]);
    }
    if(!$CMSNT->get_row("SELECT * FROM `options` WHERE `name` = 'password_momo' "))
    {
        $CMSNT->insert("options", [
            'name'   => 'password_momo',
            'value'  => ''
        ]);
    }