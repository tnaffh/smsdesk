<?php
/**
 * Created by PhpStorm.
 * User: Tnaffh
 * Date: 16/01/2017
 * Time: 5:35 PM
 */

\Illuminate\Support\Facades\Route::get('smsdesk/recieve', 'SMSDesk/MessageController@receive');