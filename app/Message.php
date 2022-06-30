<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public static function sendSMS($phone,$message){
        //write sms sending logic here

        if($resultcode=='Message Sent:1701'){ // find if message was sent
            return true;
        }
        return false;
    }
}
