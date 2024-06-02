<?php

namespace App\Interfaces;

use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ChangePasswordRequest;

interface UserInterface extends BaseInterface
{
    public function sync_role($id,UserRequest $request);
    public function send_email_with_credentials($id,$data);
    public function profileUpdate(ProfileRequest $data, $id);
    public function changePassword(ChangePasswordRequest $data, $id);
}
