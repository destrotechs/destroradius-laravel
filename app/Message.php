<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public static function sendSMS($phone,$message){
        $MobileNumbers="254".substr($phone,1);
        //write sms sending logic here
         $response=null;
        $Message1=$message . " To STOP sms from BUL S.H.G *456*9*5#";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.onfonmedia.co.ke/v1/sms/SendBulkSMS',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 200,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode([
            "SenderId"=>"BULSELFHELP",
            "MessageParameters"=>[
                [
                    "Number"=>$MobileNumbers,
                    "Text"=>$Message1
                ]
            ],
            "ApiKey"=> "+YVA7mZV/OaPoNjThgeKJK1BBOySDFhdrT4XqHh13jY=",
            // "ApiKey"=> "CWQsWeC7x2mS4fjtdiqVeHYBOl/QuccvJjYBsylzn1A=",
            "ClientId"=> "91e87d9a-7e43-46e1-8adf-73f1490edcd2"
            // "ClientId"=> "740825e2-1d22-47bc-95be-3085f20cc608"
        ])     
        ,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'AccessKey: aTLVmWasvnIkCwp2GtzmnKbUJGUU4qLV',
            // 'AccessKey: aTLVmWasvnIkCwp2GtzmnKbUJGUU4qLV',
            'Cookie: AWSALBTG=EDhs38fB5oVChP8GV5NFJxwg6gNzRGkDqCN/svOyywhdDKmVBRjrcLna9ijEJiFyEbWqd11m/BoR+QbvAiodXX5RwhCN/TVMf3tUigMGNqlfS5X7a6ZDDR3TIo0aoPE0aNk6SU3NPK87xTHFD1Q30uBmnClSytKz3ygNj8tqLtheX2/YNn4=; AWSALBTGCORS=EDhs38fB5oVChP8GV5NFJxwg6gNzRGkDqCN/svOyywhdDKmVBRjrcLna9ijEJiFyEbWqd11m/BoR+QbvAiodXX5RwhCN/TVMf3tUigMGNqlfS5X7a6ZDDR3TIo0aoPE0aNk6SU3NPK87xTHFD1Q30uBmnClSytKz3ygNj8tqLtheX2/YNn4='
          ),
        ));
    
    $response = curl_exec($curl);
    // { "ErrorCode": 0, "ErrorDescription": "Success", "Data": [ { "MobileNumber": "7894561230", "MessageId": "fc103131-5931-4530-ba8e-aa223c769536" }, { "MobileNumber": "7894561231", "MessageId": "f893293d-d6ea-45e8-b543-40f0df28e0c9" } ] }
    curl_close($curl);
    dd($response);
        $res_array = json_decode($response,true);

        $error_code = $res_array['ErrorCode'];

        if($error_code==0){ // find if message was sent
            return true;
        }
        return false;
    }
}
