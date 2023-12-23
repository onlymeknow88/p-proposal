<?php

namespace App\Http\Controllers\API;

use App\Models\Budget;
use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Models\ProposalBudget;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Amount;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        //Budget Mura Regency
        // $budgetMura = Budget::where('budget_bantuan', 1)->first();

        // $proposalBudget = ProposalBudget::all();

        // $data['budget'] = [
        //     'budgetMura' => [
        //         'total_budget' => $budgetMura->total_budget,
        //         'sisa_budget' => $proposalBudget->count() > 0 ? $budgetMura->sisa_budget : '0',
        //         'nama_budget' => 'Mura Regency'
        //     ]
        // ];

        if ($search) {
            //status skala prioritas
            $sPrioritasHigh = Proposal::where('skala_prioritas', 'high')->whereYear('start_date', $search)->get()->count();
            $sPrioritasMedium = Proposal::where('skala_prioritas', 'medium')->whereYear('start_date', $search)->get()->count();
            $sPrioritasLow = Proposal::where('skala_prioritas', 'low')->whereYear('start_date', $search)->get()->count();

            $data['skalaPrioritas'] = [
                'high' => [
                    'name' => 'High',
                    'value' => $sPrioritasHigh
                ],
                'medium' => [
                    'name' => 'Medium',
                    'value' => $sPrioritasMedium
                ],
                'low' => [
                    'name' => 'Low',
                    'value' => $sPrioritasLow
                ],
            ];

            //status proposal
            $sWaitProposal = Proposal::where('status', 1)->whereYear('start_date', $search)->get()->count();
            $sApproveProposal = Proposal::where('status', 3)->whereYear('start_date', $search)->get()->count();
            $sRejectProposal = Proposal::where('status', 5)->whereYear('start_date', $search)->get()->count();

            $data['status'] = [
                'wait' => [
                    'name' => 'Waiting for Approval',
                    'value' => $sWaitProposal
                ],
                // 'review' => [
                //     'name' => 'Reviewed',
                //     'value' => $sReviewProposal
                // ],
                'reject' => [
                    'name' => 'Rejected',
                    'value' => $sRejectProposal
                ],
                'approve' => [
                    'name' => 'Approved',
                    'value' => $sApproveProposal
                ],
                // 'return' => [
                //     'name' => 'Return',
                //     'value' => $sReturnProposal
                // ],
                // 'delete' => [
                //     'name' => 'Deleted',
                //     'value' => $sDeleteproposal
                // ],
                // 'done' => [
                //     'name' => 'Done',
                //     'value' => $sDoneProposal
                // ],
            ];


            $recentProposal = Proposal::whereYear('start_date', $search)->orderBy('created_at', 'desc')->take(5)->get();

            $data['historyProposal'] = $recentProposal;

            $amount = Amount::where('year', $search)->orderBy('created_at', 'desc')->get();

            $data['amount'] = $amount;
        } else {
            //status skala prioritas
            $sPrioritasHigh = Proposal::where('skala_prioritas', 'high')->get()->count();
            $sPrioritasMedium = Proposal::where('skala_prioritas', 'medium')->get()->count();
            $sPrioritasLow = Proposal::where('skala_prioritas', 'low')->get()->count();

            $data['skalaPrioritas'] = [
                'high' => [
                    'name' => 'High',
                    'value' => $sPrioritasHigh
                ],
                'medium' => [
                    'name' => 'Medium',
                    'value' => $sPrioritasMedium
                ],
                'low' => [
                    'name' => 'Low',
                    'value' => $sPrioritasLow
                ],
            ];

            //status proposal
            $sWaitProposal = Proposal::where('status', 1)->get()->count();
            $sApproveProposal = Proposal::where('status', 3)->get()->count();
            $sRejectProposal = Proposal::where('status', 5)->get()->count();

            $data['status'] = [
                'wait' => [
                    'name' => 'Waiting for Approval',
                    'value' => $sWaitProposal
                ],
                // 'review' => [
                //     'name' => 'Reviewed',
                //     'value' => $sReviewProposal
                // ],
                'reject' => [
                    'name' => 'Rejected',
                    'value' => $sRejectProposal
                ],
                'approve' => [
                    'name' => 'Approved',
                    'value' => $sApproveProposal
                ],
                // 'return' => [
                //     'name' => 'Return',
                //     'value' => $sReturnProposal
                // ],
                // 'delete' => [
                //     'name' => 'Deleted',
                //     'value' => $sDeleteproposal
                // ],
                // 'done' => [
                //     'name' => 'Done',
                //     'value' => $sDoneProposal
                // ],
            ];


            $recentProposal = Proposal::orderBy('created_at', 'desc')->take(5)->orderBy('prop_id', 'desc')->get();

            $data['historyProposal'] = $recentProposal;

            $amount = Amount::orderBy('created_at', 'desc')->orderBy('amount_id', 'desc')->get();

            $data['amount'] = $amount;
        }



        return ResponseFormatter::success(
            $data,
            'Data berhasil diambil'
        );
    }
}
