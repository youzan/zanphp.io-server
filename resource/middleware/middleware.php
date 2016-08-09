<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuomi
 * Date: 8/9/16
 * Time: 1:38 PM
 */

return [
    'group'     => [
        'github_doc'   => [
            Com\Youzan\ZanPhpIo\Middleware\GithubFilter::class,
            Com\Youzan\ZanPhpIo\Middleware\GithubTerminator::class
        ],
    ],
    'match'     => [
        ['^github/.*', 'github_doc'],
    ],
];
