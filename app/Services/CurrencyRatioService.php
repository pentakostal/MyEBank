<?php

namespace App\Services;
use Orchestra\Parser\Xml\Facade as XmlParser;
use SimpleXMLElement;

class CurrencyRatioService
{
    public function getRatio(string $currency): float
    {
        $todayDate=date("Ymd");
        $xml = new SimpleXMLElement('https://www.bank.lv/vk/ecb.xml?date=' . $todayDate, 0, TRUE);

        foreach ($xml->Currencies->Currency as $currencyRatio) {
            if ($currencyRatio->ID == $currency) {
                echo '<pre>';
                $currencyRatioSpecific = (float) $currencyRatio->Rate;
            }
        }
        return $currencyRatioSpecific;
    }
}
