<?php

use voku\helper\URLify;

require_once dirname(__DIR__) . '/vendor/autoload.php';

for ($i = 0; $i <= 10000; $i++) {
  $str = "<h2>testing<br />öäü</h2>";
  $str_new = URLify::filter($str);
}