<?php

namespace App\Models;

class Coin
{
    public string $symbol;
    public string $name;
    public string $price;
    public string $percentChange1h;
    public string $percentChange24h;
    public string $percentChange7d;

    public function __construct(
        string $symbol,
        string $name,
        string $price,
        string $percentChange1h,
        string $percentChange24h,
        string $percentChange7d
    )
    {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->price = $price;
        $this->percentChange1h = $percentChange1h;
        $this->percentChange24h = $percentChange24h;
        $this->percentChange7d = $percentChange7d;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getPercentChange1h(): string
    {
        return $this->percentChange1h;
    }

    public function getPercentChange24h(): string
    {
        return $this->percentChange24h;
    }

    public function getPercentChange7d(): string
    {
        return $this->percentChange7d;
    }
}
