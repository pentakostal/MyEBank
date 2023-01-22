<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeyCardController extends Controller
{
    public function index()
    {
        $codes = [];
        for ($i = 1; $i < 11; $i++) {
            $codes[] = DB::table('key_cards')->where('user_id', Auth::id())->value($i);
        }
        //echo "<pre>";
        //var_dump($codes[1]);die;
        return view('keyCard', [
            'codes' => $codes
        ]);
    }
}
