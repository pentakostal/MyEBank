<?php

namespace App\Services;
use Orchestra\Parser\Xml\Facade as XmlParser;

class CurrencyRatio
{
    public function getRatio()
    {
        $xml = new SimpleXMLElement('https://www.bank.lv/vk/ecb.xml?date=20050323', 0, TRUE);

        var_dump($xml);die;
    }
}
