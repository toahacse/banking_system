<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index(){
        $deposits = Transaction::where('transaction_type', 'deposit')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(); 
        return view('deposit.index', compact('deposits'));
    }
    public function store(Request $request){
        $req = $request->all();
        Transaction::create([
            'user_id' =>  auth()->user()->id,
            'transaction_type' => 'deposit',
            'amount' => $req['amount'],
            'fee' => 0.00,
            'date' => now(),
        ]);

        $user = User::find(auth()->user()->id);
        $user->update([
            'balance' => $user->balance + $req['amount']
        ]);
        
        return redirect()->route('deposit.index')->with('success', 'Successfully Deposited');
    }
}
