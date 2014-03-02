<?php

if (is_file(dirname(__DIR__) . '/URLify.php')) {
  # for netbeans
  require_once dirname(__DIR__) . '/URLify.php';  
} else {
  # for travis-ci
  require_once dirname(__DIR__) . '/vendor/composer/autoload.php';
}
