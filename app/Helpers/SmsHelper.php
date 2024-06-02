<?php

namespace App\Helpers;

use AdnSms\AdnSmsNotification;
use App\Models\OtpSms;

require_once(__DIR__ . "../../Library/AdnSms/lib/AdnSmsNotification.php");

class SmsHelper
{

    public static function sms_send($data)
    {
        $message = $data['message'];
        $phone = ltrim($data['phone'], '0');
        $country_code = $data['country_code'];
        $user_id = @$data['user_id'] ?? null;
        $otp = @$data['otp'] ?? null;
        $expire_at = @$data['expire_at'] ?? null;
        $recipient = $country_code . $phone;
        $requestType = 'SINGLE_SMS';
        $messageType = 'TEXT';
        $sms = new AdnSmsNotification();
        $res = $sms->sendSms($requestType, $message, $recipient, $messageType);
        OtpSms::query()->create([
            'message' => $message,
            'phone' => $phone,
            'country_code' => $country_code,
            'response' => $res,
            'user_id' => $user_id,
            'otp' => $otp,
            'expire_at' => $expire_at,
            'created_by' => $user_id,
        ]);
        return $res;
    }

    public static function welcome_sms_send($data)
    {
        $message = $data['message'];
        $phone = ltrim($data['phone'], '0');
        $country_code = $data['country_code'];
        $recipient = $country_code . $phone;
        $requestType = 'SINGLE_SMS';
        $messageType = 'TEXT';
        $sms = new AdnSmsNotification();
        $sms->sendSms($requestType, $message, $recipient, $messageType);
        OtpSms::query()->create([
            'message' => $message,
            'phone' => $phone,
            'country_code' => $country_code,
            // 'response' => $res,
        ]);
        return 1;
    }

}