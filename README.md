# EComerce Bank

This is a bank application based on PHP and Laravel framework.  Register as new user and take posobilities of EComerce Bank. 
Create accounts with different currency's, manage them. Make transaction between accounts and users. 
Special feature buy and sell crypto coins.

---

### Features:
<ol>
    <li>Create accounts with various currency's</li>
    <li>Internal transaction</li>
    <li>Payments between users</li>
    <li>Transaction history</li>
    <li>Buy and sell crypto</li>
</ol>

---

![picture_screanshot](https://github.com/pentakostal/MyEBank/blob/main/public/pictures/screenshot_1.png)
![](https://github.com/pentakostal/MyEBank/blob/main/public/pictures/Peek%202022-12-26%2009-19.gif)
![](https://github.com/pentakostal/MyEBank/blob/main/public/pictures/Peek%202023-01-22%2016-23.gif)
![](https://github.com/pentakostal/MyEBank/blob/main/public/pictures/Peek%202023-01-22%2016-24.gif)
![picture_screenshot](https://github.com/pentakostal/MyEBank/blob/main/public/pictures/screenshot_1.png)

---

### Components used:
<ol>
    <li>PHP 7.4</li>
    <li>MySql (8.0.31-0ubuntu0.22.04.1 (Ubuntu))</li>
    <li>Laravel 8</li>
</ol>

---

### How to install
<ol>
<li>Clone repository to your local machine (more convenient way for you)</li>
<li>For these project you will need a API key from (register for free, and you will
get your API key): </li>

[CoinMarketCap](https://coinmarketcap.com/api/)

<li>After in console navigate to root folder, where you cloned project.</li>
<li>Then run command:</li>

> composer install

<li>Change .env.example to .env (ore create from scratch using .env.example)</li>
<li>Then generate a app key</li>

> php artisan key:generate

<li>Setup a .env file
    <ol>
        <li>You need enter your parameters in fields where you find "CUSTOM"</li>
        <li>Enter your data about database.</li>
        <li>Enter your api key. (In the end, for crypto use)</li>
    </ol>
</li>
<li>In root directory run command:</li>

>php artisan serve

<li>After you can open project in your favorite browser and start to use application</li>
</ol>
