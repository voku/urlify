<?php

require_once __DIR__ . '/../vendor/autoload.php';

$start = \microtime(true);
for ($i = 0; $i <= 10000; ++$i) {
    $str = '<h2>testing<br />öäü</h2>';
    $str_new = \voku\helper\URLify::filter($str);
}
echo 'time: ' . (\microtime(true) - $start);
