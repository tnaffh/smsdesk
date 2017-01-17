<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    function createMessage($request, $msg = null)
    {
        if ($msg == null) {
            $m = new Message;
            $m->body = $request->input('message');
            $m->from = $request->input('sender');
            $m->to = $request->input('recipient');
            $m->sys_timestamp = $request->input('timestamp');
            $m->sys_id = $request->input('incomingsmsid');
            $m->direction = 'in';
            $m->save();

            return $m;


        } else {
            $m = new Message;
            $m->body = $msg;
            $m->from = $request->input('recipient');
            $m->to = $request->input('sender');
            $m->direction = 'out';
            $m->save();

            return $m;
        }


    }

    function send(Request $request)
    {

        $this->validate($request, ['group' => 'required', 'message' => 'required']);
        $group = $request->input('group');
        switch ($group) {
            case 'attendees':
            case 'stuffs':
            default:
                $list = People::all();
        }
        $body = $request->input('message');
        $count = 0;

        foreach ($list as $to) {
            SMSDesk::sent($to->mobile, $body);


            $count++;


        }
        return redirect()->back()->with('success', "$count Messages sent to $group");

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $msg = "Thank you. Your subscription is bieng processed, you will recieve a confirmation sms shortly. #Gosafe #EndaNawa";

        $validator = Validator::make($request->all(), [
            'sender' => 'required',
            'recipient' => 'required',
            'message' => 'required',
            'incomingsmsid' => 'required',
        ]);

        // if validation fails
        if ($validator->fails()) {
            //$this->createMessage($request);
            //$this->createMessage($request, 'Invalid request, please correct and try again.');
            return 'Invalid request, please correct and try again.';
        }

        // record in message
        $message = $this->createMessage($request);

        // if sms in save fails
        if (!$message) {
            $msg = 'Invalid request, please correct and try again.';
            $this->createMessage($request, $msg);
            return $msg . ' Ref: ' . rand(10000, 99999);
        } else {
            $ms = $this->createMessage($request, $msg);
            $ref = $ms->id . '-' . rand(1000, 9999);
            return $msg . ' Ref: ' . $ref;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
