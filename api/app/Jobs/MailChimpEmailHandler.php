<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \Mailchimp;
class MailChimpEmailHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $listId = '9f06c70688';
    public $mailchimp;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->mailchimp = new Mailchimp('8a8d787017982eaaf0b9dc549581495d-us15');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->send();
    }

    public function subscribe(){
        // $this->validate($request, [
        //     'email' => 'required|email',
        // ]);

        try {
            
            $this->mailchimp
            ->lists
            ->subscribe(
                $this->listId,
                ['email' => $request->input('email')]
            );

            return redirect()->back()->with('success','Email Subscribed successfully');
        } catch (\Mailchimp_List_AlreadySubscribed $e) {
            return redirect()->back()->with('error','Email is Already Subscribed');
        } catch (\Mailchimp_Error $e) {
            return redirect()->back()->with('error','Error from MailChimp');
        }
    }

    public function send(){
        // $this->validate($request, [
        //     'subject' => 'required',
        //     'to_email' => 'required',
        //     'from_email' => 'required',
        //     'message' => 'required',
        // ]);

        try {

            $options = [
            'list_id'   => $this->listId,
            'subject' => 'MailChimp Test',
            'from_name' => 'support@idfactory.ph',
            'from_email' => 'support@idfactory.ph',
            'to_name' => 'kennettecanales@gmail.com'
            ];

            $content = [
                'html' => View('email.verification'),
                'text' => strip_tags(View('email.verification'))
            ];

            $campaign = $this->mailchimp->campaigns->create('regular', $options, $content);
            $this->mailchimp->campaigns->send($campaign['id']);
            return redirect()->back()->with('success','send campaign successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error','Error from MailChimp');
        }
    }
}
