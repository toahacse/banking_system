<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index(){
        $withdrawals = Transaction::where('transaction_type', 'withdrawal')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(); 
        return view('withdrawal.index', compact('withdrawals'));
    }
    
    public function store(Request $request){
        try {
            $req = $request->all();
            
            $user = User::find(auth()->user()->id);
            $balance = $user->balance;
     
            if($balance < (int)$req['amount']) throw new Exception("You don't have enough balance!", 404);
            $isIndividual = $user->account_type === 'individual';
            $isFriday = now('asia/dhaka')->dayOfWeek === 5;
     
            
            $totalWithdrawals = $isIndividual ? 0 : $user->withdrawals()
                                        ->where('transaction_type', 'withdrawal')
                                        ->sum('amount');

            $monthlyWithdrawals = $user->withdrawals()
                                    ->where('transaction_type', 'withdrawal')
                                    ->whereMonth('created_at', now()->month)
                                    ->sum('amount');

            $isFreeWithdrawal = $isIndividual && ($isFriday || $monthlyWithdrawals + $req['amount'] <= 5000);
            $withdrawalRate = $isIndividual ? ($isFreeWithdrawal ? 0 : 0.015) : ($totalWithdrawals + $req['amount'] > 50000 ? 0.015 : 0.025);
       
            if($isIndividual){
                $freeWithdrawalLimit = 1000;

                if ($req['amount'] > $freeWithdrawalLimit && !$isFreeWithdrawal) {
                    $fee = ($req['amount'] - $freeWithdrawalLimit) * ($withdrawalRate/100);
                } else {
                    $fee = 0;
                }
            }else{
                $fee = $req['amount'] * ($withdrawalRate/100);
            }
    
            Transaction::create([
                'user_id' =>  auth()->user()->id,
                'transaction_type' => 'withdrawal',
                'amount' => $req['amount'],
                'fee' => $fee,
                'date' => now(),
            ]);
    
            $user->update([
                'balance' => $user->balance - ($req['amount']+$fee) 
            ]);
            
            return redirect()->route('withdrawal.index')->with('success', 'Successfully Withdrawal');

        }catch(Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
