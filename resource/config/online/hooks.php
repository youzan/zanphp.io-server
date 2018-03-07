<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/7/16
 * Time: 2:51 PM
 */
return [
    'ZanPhpDoc' => [
        'repo'   => 'https://github.com/youzan/zanphp-doc.git',
        'secret' => '2X2u3PxaoX2dJbCb',
        'src'    => '/var/www/zanphp.io/zanphp-doc/',
        'build'  => '/var/www/zanphp.io/zanphp-doc/build/html',
        'dist'   => '/var/www/zanphp.io/zanphp-html/',
        'backup' => '/var/www/zanphp.io/zanphp_backup',
        'output' => '/var/www/zanphp.io/logs/zanphp_doc.update.log',
        'pid'    => '/var/www/zanphp.io/zanphp_pid',
    ],
    'ZanDoc' => [
        'repo'   => 'https://github.com/youzan/zan-doc.git',
        'secret' => '2X2u3PxaoX2dJbCb',
        'src'    => '/var/www/zanphp.io/zan-doc/',
        'build'  => '/var/www/zanphp.io/zan-doc/build',
        'dist'   => '/var/www/zanphp.io/zan-html/',
        'backup' => '/var/www/zanphp.io/zan_backup',
        'output' => '/var/www/zanphp.io/logs/zan_doc.update.log',
        'pid'    => '/var/www/zanphp.io/zan_pid',
    ],
    'ZanPHPComponents' => [
        'repo'   => 'https://github.com/zanphp/{APPNAME}.git',
        'secret' => '2X2u3PxaoX2dJbCb',
        'src'    => '/var/www/zanphp.io/zan-php/{APPNAME}',
        'backup' => '/var/www/zanphp.io/zanphp_backup/{APPNAME}',
        'output' => '/var/www/zanphp.io/logs/zanphp_{APPNAME}.update.log',
        'pid'    => '/var/www/zanphp.io/zanphp_{APPNAME}_pid',
    ],
    'ZanOSChina' => [
        'repo'   => 'https://github.com/youzan/{APPNAME}.git',
        'secret' => '2X2u3PxaoX2dJbCb',
        'src'    => '/var/www/zanphp.io/zan-oschina/{APPNAME}',
        'backup' => '/var/www/zanphp.io/zanoschina_backup/{APPNAME}',
        'output' => '/var/www/zanphp.io/logs/zanoschina_{APPNAME}.update.log',
        'pid'    => '/var/www/zanphp.io/zanoschina_{APPNAME}_pid',
    ]
];
