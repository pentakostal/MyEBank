<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Rules\NumberIDnotSame;
use App\Services\TransitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();

        return view('payment', [
            'accounts' => $accounts
        ]);
    }

    public function payment(Request $request)
    {
        $payment = $request->validate([
            'accountFrom' => 'required',
            'receiver' => 'required',
            'accountTo' => ['required', 'different:accountFrom', new NumberIDnotSame($request['accountFrom'])],
            'amount' => 'required',
            'comment' => 'required'
        ]);

        (new TransitService(
            $payment['accountFrom'],
            $payment['accountTo'],
            $payment['amount'],
            $payment['receiver'] . ' / ' . $payment['comment'],
            "-",
            Auth::id()
        ))->makeTransit();

        return redirect()->route('payment')->with('success', 'Payment successful');
    }
}
