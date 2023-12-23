<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestingEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('testing@mail.com')
                   ->view('email_approval.approval_request')
                   ->with(
                    [
                        'nama' => 'Fadjri Wivindi',
                        'deskripsi' => '<p>Untuk ke depannya mohon untuk dapat dicatat di bagian Access SAP untuk dapat ditulis Y karena setiap karyawan direct hire AMC mempunyai akses SAP, kalau pun tidak punya akses SAP GUI / backend, pasti punya akses SAP Fiori. Sehingga kita harus terminate user ID SAP karyawan</p>'
                    ]);
    }
}
