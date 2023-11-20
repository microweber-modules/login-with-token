<?php


Route::name('api.')
    ->prefix('api')
    ->middleware(['api','admin'])
    ->namespace('\MicroweberPackages\Modules\LoginWithToken\Http\Controllers\Api')
    ->group(function () {

        Route::get('login_with_secret_key', function () {

            $secretKey = request()->get('key');

            if ($secretKey) {

                $get_temp_token = db_get('users_temp_login_tokens', 'single=1&token=' . $secretKey);
                if ($get_temp_token && $get_temp_token['user_id']) {

                    $temp_token_created_at = new \Illuminate\Support\Carbon($get_temp_token['created_at']);

                    if (\Illuminate\Support\Carbon::now()->diffInMinutes($temp_token_created_at) >= 30) {
                        db_delete('users_temp_login_tokens', $get_temp_token['id']);
                        return array('error' => 'User token expired.');
                    }

                    $update_temp = array();
                    $update_temp['id'] = $get_temp_token['id'];
                    $update_temp['login_ip'] = user_ip();
                    $update_temp['login_at'] = date('Y-m-d H:i:s');
                    $save_update_temp = db_save('users_temp_login_tokens', $update_temp);

                    if ($save_update_temp) {
                        mw()->user_manager->make_logged($get_temp_token['user_id']);
                        return array('success' => true, 'http_redirect' => admin_url());
                    }

                }
            }

            return [
                'error' => 'Invalid token.'
            ];


        });

    });


