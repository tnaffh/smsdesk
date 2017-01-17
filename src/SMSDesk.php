<?php

namespace Tnaffh\SMSDesk;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Validation\Validator;


class SMSDesk
{

    function _construct(){

    }

    function auth($email,$password){

    }

    function send($to,$from,$message,$ref = null){
        $ref = $ref === null ? $ref = str_random(4).'-'.rand(10000000,99999999): $ref;
        $key = 'cb31d6a5af4cc1c39da087c743e0fc5d8d43d508';
        $api = "http://www.efinity.com.na/smsdesk/app/api/http/?key=$key&action=sendsms&to=$to&msg=$message";
        $client = new Client();
        $res = $client->request('GET', $api);
        //echo $res->getStatusCode();

        $sms = new Message();
        $sms->to = $to;
        $sms->body = $message;
        $sms->from = 50505;
        $sms->status = $res->getBody();
        $sms->direction = 'in';
        $sms->save();
    }

    function receive(Request $request){
        $validator = Validator::make($request,[

        ]);


        if($validator->fails()){

        }

    }

}