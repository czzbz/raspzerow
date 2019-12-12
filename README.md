# 树莓派Zero W配置
WIFI版树莓派配置
应用环境：wifi版树莓派ZeroW，没有网线，没有全尺寸HDMI，初始化后，通过一个配置文件来自动加载WIFI，以及Frp。因为用到PHP项目，所以顺便用php写了一个简单的配置脚本

1. 下载官方镜像（略）
2. 烧卡（略）
3. 加载Boot分区
    在config.txt末尾添加一行

    `dtoverlay=dwc2`

    在cmdline.txt文件中"rootwait"后添加参数

    `modules-load=dwc2,g_ether`

    在跟目录下建立名为ssh的空文件夹用以开启ssh访问

5. 把卡插入树莓派加电启动

6. 用USB连接电脑，会识别为RNDIS设备

7. 此时可以通过ssh连接树莓派了

    `ssh pi@raspberrypi.local`

    默认密码：raspberry
    

* * *

安装PHP后可以使用此脚本加载配置

将init.php复制到/home/pi/init.php

编辑 rc.local

加入一行

`/usr/bin/php /home/pi/init.php`
