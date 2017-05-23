<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/9/16
 * Time: 1:38 PM
 */

return [
    'group'     => [
        'ZanPhpDoc'   => [
            Com\Youzan\ZanPhpIo\Middleware\ZanPhpDocFilter::class,
            Com\Youzan\ZanPhpIo\Middleware\ZanPhpDocTerminator::class
        ],
        'ZanDoc'   => [
            Com\Youzan\ZanPhpIo\Middleware\ZanDocFilter::class,
            Com\Youzan\ZanPhpIo\Middleware\ZanDocTerminator::class
        ],
    ],
    'match'     => [
        ['^github/hooks/updateZanPhpDoc', 'ZanPhpDoc'],
        ['^github/hooks/updateZanDoc', 'ZanDoc'],
    ],
];
