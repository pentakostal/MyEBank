<?php

namespace App\Services;

use App\Models\Coin;

class CoinDataService
{
    public array $currencies;
    public float $price;

    public function __construct(? string $symbol = 'BTC,ETH,USDT,BNB,XRP,ADA,SOL,DOT,LTC,AVAX')
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
        $parameters = [
            'symbol' => $symbol,
            'convert' => 'EUR',
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: ' . $_ENV["COIN_MARKET_API_KEY"]
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $response = json_decode($response); // print json decoded response
        curl_close($curl); // Close request

        $currencies = [];

        foreach ($response->data as $currency) {
            $currencies[] = new Coin(
              $currency->symbol,
              $currency->name,
              $currency->quote->EUR->price,
              $currency->quote->EUR->percent_change_1h,
              $currency->quote->EUR->percent_change_24h,
              $currency->quote->EUR->percent_change_7d
            );
        }

        $this->currencies = $currencies;
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function getPrice(string $symbol): float
    {
        $price = null;
        foreach ($this->currencies as $coin) {
            if ($coin->getSymbol() == $symbol) {
                $price = (float) $coin->getPrice();
            }
        }

        return number_format((float)$price, 2, '.', '');
    }
}
