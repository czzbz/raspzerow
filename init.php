<?php

/**
 * 说明，通过boot分区配置文件的形式实现方便的初始化配置
 * wifi.txt 配置wifi密码
 * frp.txt 配置
 */
$changed = false;
//检查WIFI配置
$wifistr = @file_get_contents('/boot/wifi.txt');
if ($wifistr) {
    $ar = explode("\n", $wifistr);
    if (count($ar) >= 2) {
        $sid = trim($ar[0]);
        $key = trim($ar[1]);
        $rar[] = "ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev";
        $rar[] = "update_config=1";
        $rar[] = "network={";
        $rar[] = "ssid=\"$sid\"";
        $rar[] = "psk=\"$key\"";
        $rar[] = "}";
        file_put_contents('/etc/wpa_supplicant/wpa_supplicant.conf', join(PHP_EOL, $rar));
        unlink('/boot/wifi.txt');
        $changed = true;
    }
}
//检查frp端口
$frpstr = @file_get_contents('/boot/frp.txt');
if ($frpstr) {
    $port = trim($frpstr);
    $frpfile = @file_get_contents('/opt/frp/frpc.ini');
    $frpfile = str_replace(['ssh89', 'http89', '8922', '8980'], ['ssh' . $port, 'http' . $port, $port . '22', $port . '80'], $frpfile);
    file_put_contents('/opt/frp/frpc.ini', $frpfile);
    unlink('/boot/frp.txt');
    $changed = true;
}
//重启生效
if ($changed) {
    exec('reboot');
}
