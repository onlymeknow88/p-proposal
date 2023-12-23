<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalNotificationDeptHead extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {


        return $this->view('email_approval.notif_approval_request')
            ->subject('PROPOSAL #' . $this->mailData['prop_no'])
            ->with([
                'nama_approval' => $this->mailData['nama_approval'],
                'data' => $this->mailData['data'],
                'sts_approval' => $this->mailData['sts_approval'],
                'tgl_approval' => $this->mailData['tgl_approval'],
                'approval_level' => $this->mailData['approval_level'],
            ]);
    }
}
