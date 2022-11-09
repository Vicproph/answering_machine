<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitPhoneForMessageRequest;
use App\Jobs\SendMessageJob;


class SubmitPhoneForDefaultMessageAction extends Controller
{
    public function __invoke(SubmitPhoneForMessageRequest $request)
    {
        $mobile = $request->mobile;
        preg_match('/9\d{9}$/', $mobile, $matches); // extract last 9 numbers 
        $mobile = $matches[0];

        SendMessageJob::dispatch($mobile);

        return response()->json(['message'=>__('message.sms.inqueue')]);
    }
}
