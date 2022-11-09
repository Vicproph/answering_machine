<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Spatie\ArrayToXml\ArrayToXml;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
    
    
 - username : نام کاربری مورد استفاده در سامانه پیامک  [اجباری]

 - password : رمز عبور مورد استفاده در سامانه پیامک [اجباری]

 - sender_number : شماره ارسال کننده در سامانه پیامک  [اجباری]

 - reciever_number : شماره دریافت کننده پیامک  [اجباری]

- note : متن پیامک ارسالی  [اجباری]

- date : تاریخ ارسال پیامک ( ارسال در آینده ) [ اختیاری ] - این متغیر به صورت آرایه ارسال میشود و میتواند شامل یک یا بیش از یک تاریخ باشد . 


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public string $mobile;

    public function __construct(string $mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $username =  env('SMS_USERNAME');
        $password =  env('SMS_PASSWORD');
        $sender =  env('SMS_FROM');
        $reciever =  $this->mobile;
        $note =  __('message.phone.default.message');
        $date =  (string) now();

        $endpoint = "http://sms20.ir/send_via_get/send_sms.php?username={$username}&password={$password}&sender_number={$sender}&receiver_number={$reciever}&note={$note}";

        $client = new Client;
        $response = $client->get($endpoint);
        
        return ($response->getBody()->getContents());
    }
}
