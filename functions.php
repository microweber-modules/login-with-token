<?php

\Artisan::command('microweber:server-clear-cache', function () {
    clearcache();
});

\Artisan::command('microweber:server-set-config {--config=config} {--key=key} {--value=value}', function ($config, $key, $value) {

    Config::set($config . '.' . $key, $value);
    Config::save(array($config));
    Cache::flush();

});


\Artisan::command('microweber:change-admin-details {--username=username} {--new_password=new_password} {--new_email=new_email}', function ($username, $new_password, $new_email) {

    // Find first admin
    $firstAdmin = get_users('is_admin=1&single=1&is_active=1&username=' . $username);
    if (!$firstAdmin) {
        return false;
    }

    // Save user
    $updateUser = array();
    $updateUser['id'] = $firstAdmin['id'];
    $updateUser['password'] = Hash::make($new_password);
    $updateUser['email'] = $new_email;

    $save = db_save('users', $updateUser);
    if ($save) {
        echo 'Done!';
    }

});

\Artisan::command('microweber:generate-admin-login-token', function () {

    // Generate token
    $generateToken = str_random(123);

    // Find first admin
    $firstAdmin = get_users('is_admin=1&single=1&is_active=1');
    if (!$firstAdmin) {
        return false;
    }

    $saveToken = array();
    $saveToken['token'] = $generateToken;
    $saveToken['user_id'] = $firstAdmin['id'];
    $saveToken['created_at'] = date('Y-m-d H:i:s');
    $saveToken['server_ip'] = user_ip();

    // Save temp token
    $save = db_save('users_temp_login_tokens', $saveToken);
    if ($save) {
        echo $generateToken;
    }

});
