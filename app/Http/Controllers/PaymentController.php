<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Rules\KeyCodeCorrect;
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
            'accounts' => $accounts,
            'code' => rand(1, 10)
        ]);
    }

    public function payment(Request $request)
    {
        $payment = $request->validate([
            'accountFrom' => 'required',
            'receiver' => 'required',
            'accountTo' => ['required', 'different:accountFrom', new NumberIDnotSame($request['accountFrom'])],
            'amount' => 'required',
            'comment' => 'required',
            'keyCodeNumber' => 'required',
            'keyCode' => ['required', new KeyCodeCorrect(Auth::id(), (int) $request['keyCodeNumber'])]
        ]);
        $amount = (float) $payment['amount'];
        (new TransitService(
            $payment['accountFrom'],
            $payment['accountTo'],
            $amount,
            $payment['comment'],
            "-",
            Auth::id()
        ))->makeTransit();

        return redirect()->route('payment')->with('success', 'Payment successful');
    }
}
