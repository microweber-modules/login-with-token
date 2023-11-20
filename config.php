<?php
$config = array();
$config['name'] = "Server login with token";
$config['author'] = "Bozhidar Slaveykov";
$config['ui'] = false; //if set to true, module will be visible in the toolbar
$config['ui_admin'] = false; //if set to true, module will be visible in the admin panel
$config['categories'] = "content";
$config['position'] = 99;
$config['version'] = 0.8;

$config['tables'] = array(
    'users_temp_login_tokens' => [
        'user_id' => 'integer',
        'token' => 'text',
        'server_ip' => 'string',
        'login_ip' => 'string',
        'login_at' => 'dateTime',
        'created_at' => 'dateTime'
    ]
);


$config['settings']['autoload_namespace'] = [
    [
        'path' => __DIR__ . '/src/',
        'namespace' => 'MicroweberPackages\\Modules\\LoginWithToken'
    ],
];

$config['settings']['service_provider'] = [
    \MicroweberPackages\Modules\LoginWithToken\Providers\LoginWithTokenServiceProvider::class
];
