<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\FormNop;
use App\Models\InboxApp;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Homepage\UserHomepage;
use App\Mail\ApprovalNotificationDivHead;
use App\Models\Homepage\EmployeeHomepage;
use App\Mail\ApprovalNotificationDeptHead;
use App\Mail\ApprovalNotificationDirector;

class InboxAppController extends Controller
{
    protected $client;

    protected $folder;

    protected $messages;

    public function __construct()
    {
        $this->client = Client::account('default');
    }

    public function index()
    {
        $this->checkConnect();

        foreach ($this->messages as $email) {

            $existingEmail = InboxApp::where('uid', $email->getUid())->first();

            $textBody = substr(strtolower(preg_replace('/[^a-zA-Z]/', '', $email->getTextBody())), 0, 1);

            $text = substr(strtolower(preg_replace('/[^a-zA-Z]/', '', $email->getHTMLBody(true))), 172, 1);

            $checkTextBody = strpos($textBody, 'y') !== false;

            $checkText = strpos($text, 'y') !== false;

            if (!$existingEmail) {
                $data = InboxApp::create([
                    'subject' => $email->getSubject(),
                    'from' => $email->getFrom()[0]->mail,
                    'body_text_mobile' => $checkTextBody == true ? 'y' : '',
                    'uid' => $email->getUid(),
                    'body_text_desktop' => $checkText == true ? 'y' : '',
                ]);

                if ($data) {
                    $this->handle($data);
                }
            }

            // Attempt to delete the email with retries
            $attempts = 3; // Number of retry attempts
            $retryDelaySeconds = 3; // Delay between retries (in seconds)
            $deleted = false;

            for ($i = 1; $i <= $attempts && !$deleted; $i++) {
                try {
                    $email->delete();
                    $deleted = true;
                } catch (\Exception $e) {
                    // Log the error details
                    // Log::error('Error deleting email (Attempt ' . $i . '): ' . $e->getMessage());

                    // Wait before retrying
                    sleep($retryDelaySeconds);
                }
            }

            // $this->client->disconnect();
        }

        return 'Berhasil mengambil data email...';

        // return view('pages.email.inbox');
    }

    public function checkConnect()
    {
        if (!$this->client->isConnected()) {
            $this->client->connect();
            $twoDaysAgo = Carbon::now()->subDays(2);

            $this->folder = $this->client->getFolderByName('INBOX');
            $this->messages = $this->folder->query()->subject('RE:')->since($twoDaysAgo)->get();
        }
    }

    public function getItemById(int $UID)
    {
        try {
            $this->checkConnect();
        } catch (Exception $e) {
            return view('error', [
                'error' => 'Failed to connect and gathering data...'
            ]);
        }
        foreach ($this->messages as $oMessage) {
            if ($UID == $oMessage->getUid()) {
                return $oMessage;
            }
        }
    }

    public function handle($data)
    {
        //get subject from inbox appr and substr 14 prop_no
        $prop_no_subject = substr($data->subject[0], 14);

        //get email from inbox appr
        $email_app = $data->from;

        //user employee from homepage get is_department_head, is_division_head
        $userHomepage = UserHomepage::where('email', $email_app)->first();

        // employee from homepage get is_director by nik Pak TOTOK
        $userDirector = EmployeeHomepage::where('email', 'fadjri.wivindi@adaro.com')
            ->first();

        $is_director = [
            'name' => $userDirector->name,
            'email' => $userDirector->email,
            'position' => $userDirector->position,
            'is_director' => '1',
        ];

        //get data proposal by prop_no
        $proposal = Proposal::where('prop_no', $prop_no_subject)->first();

        //get user from proposal
        $userProposal = $proposal->user;

        // send email notifikasi if approved to user
        $send_email_to = $userProposal->email;

        //get prop_no
        $prop_no = $proposal['prop_no'];

        if ($proposal) {
            // check if body_text_mobile or body_text_desktop is y
            if ($data->body_text_mobile == 'y' || $data->body_text_desktop == 'y') {

                if ($userHomepage->IsDeptHead == 1) {
                    $proposal->update([
                        'status' => '1', //status proposal waiting for approval
                        'appr_deptHead' => $userHomepage->nik, //approved nik dept head
                        'sts_appr_deptHead' => 2, //approved sts 2
                        'appr_deptHead_date' => now() //approved date
                    ]);

                    //notifsikasi email to user approved department head
                    $mailDataDeptHead = [
                        'data' => $proposal,
                        'prop_no' => $prop_no,
                        'nama_approval' => $userHomepage->name,
                        'approval_level' => 'Department Head',
                        'sts_approval' => 'Approved',
                        'tgl_approval' => $proposal->appr_deptHead_date
                    ];

                    Mail::to($send_email_to)->send(new ApprovalNotification($mailDataDeptHead));

                    // approval to Division Head
                    if ($proposal->status == 1) {
                        $appr_divHead = User::where('is_div_head', 1)->first();
                        $mailDataDivHead = [
                            'data' => $proposal,
                            'prop_no' => $prop_no,
                            'nama_approval' => $appr_divHead->name,
                            'approval_level' => 'Division Head',
                            'sts_approval' => 'Waiting for Approval',
                            'tgl_approval' => '....'
                        ];

                        $when = now()->addMinutes(5);

                        Mail::to($appr_divHead)->later($when, new ApprovalNotificationDivHead($mailDataDivHead));
                    }
                } elseif ($userHomepage->IsDivHead == 1) {
                    $proposal->update([
                        'status' => '1', //status proposal waiting for approval
                        'appr_divHead' => $userHomepage->nik, //approved nik div head
                        'sts_appr_divHead' => 2, //approved sts 2
                        'appr_divHead_date' => now() //approved date
                    ]);

                    //notifsikasi email to user approved division head
                    $mailDataDivHead = [
                        'data' => $proposal,
                        'prop_no' => $prop_no,
                        'nama_approval' => $userHomepage->name,
                        'approval_level' => 'Division Head',
                        'sts_approval' => 'Approved',
                        'tgl_approval' => $proposal->appr_divHead_date
                    ];

                    $when = now()->addMinutes(5);

                    Mail::to($send_email_to)->later($when, new ApprovalNotification($mailDataDivHead));

                    // approval to Division Head
                    if ($proposal->status == 1) {
                        // $appr_director = User::where('is_director', 1)->first();
                        $mailDataDirector = [
                            'data' => $proposal,
                            'prop_no' => $prop_no,
                            'nama_approval' => $is_director['name'],
                            'approval_level' => 'Director',
                            'sts_approval' => 'Waiting for Approval',
                            'tgl_approval' => '....'
                        ];

                        $when = now()->addMinutes(5);

                        Mail::to('nathanael.jonathan@adaro.com')->later($when, new ApprovalNotificationDirector($mailDataDirector));
                    }
                } elseif ($is_director['is_director'] == '1') {
                    $proposal->update([
                        'status' => '2', //status proposal waiting for approval
                        'appr_director' => $userHomepage->nik, //approved nik div head
                        'sts_appr_director' => 2, //approved sts 2
                        'appr_director_date' => now() //approved date
                    ]);

                    $formNop = FormNop::with('getAmount')->where('prop_id', $proposal->prop_id)->first();

                    $totalAmount = $formNop->getAmount->amount;

                    $formNop->update([
                        'sisa_amount' => $totalAmount - $formNop->amount
                    ]);

                    //notifsikasi email to user approved division head
                    $mailDataDirector = [
                        'data' => $proposal,
                        'prop_no' => $prop_no,
                        'nama_approval' => $userHomepage->name,
                        'approval_level' => 'Director',
                        'sts_approval' => 'Approved',
                        'tgl_approval' => $proposal->appr_director_date
                    ];

                    Mail::to($send_email_to)->send(new ApprovalNotification($mailDataDirector));
                }
            } else {

            }
            $inbox = InboxApp::where('uid', $data->uid)->first();
            $inbox->delete();
        }

        return 'approval section head berhasil dilakukan...';
    }
}
