<?php

namespace App\Http\Controllers;

use App\Services\CoinDataService;

class CoinMarketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = (new CoinDataService())->getCurrencies();
        //echo '<pre>';
        //var_dump($data);die;
        return view('coinMarket', [
            'cryptoCurrencies' => $data
        ]);
    }
}
