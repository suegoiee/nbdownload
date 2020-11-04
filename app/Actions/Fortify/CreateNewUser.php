<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:cms_user'],
            'user_password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'user_name' => $input['user_name'],
            'user_email' => $input['user_email'],
            'user_password' => Hash::make($input['user_password']),
            'category_id' => 0,
            'user_country' => 'default',
            'user_account' => $input['user_name'],
            'user_fullname' => $input['user_name'],
            'user_image' => '',
            'user_admin' => 1,
            'user_actived' => 1,
            'user_author' => 1,
            'user_is_pm' => 1,
            'user_department' => '預設',
            'user_last_login' => date('Y-m-d H:i:s'),
            'user_create' => date('Y-m-d H:i:s'),
            'user_modify' => date('Y-m-d H:i:s'),
            'user_update' => date('Y-m-d H:i:s'),
            'draft' => 0
        ]);
    }
}
