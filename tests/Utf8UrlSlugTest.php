<?php

use voku\helper\Bootup;
use voku\helper\URLify;
use voku\helper\UTF8;

/**
 * Class Utf8UrlSlugTest
 */
class Utf8UrlSlugTest extends PHPUnit_Framework_TestCase
{
  public function test_utf8()
  {
    $str = 'testiñg test.';
    self::assertSame('testing-test', URLify::filter($str));
  }

  public function test_ascii()
  {
    $str = 'testing - test';
    self::assertSame('testing-test', URLify::filter($str));
  }

  public function test_multi()
  {
    $str = "川 đņ ōķ ôõ ö+ ÷ø ųú ûü ũū˙ ^ foo \0 \x1 \\";
    if (UTF8::intl_loaded() === true && Bootup::is_php('5.4')) {
      $expected = 'chuan-djn-ok-oo-oe-o-uu-uue-uu-foo';
    } else {
      $expected = 'Chuan-djn-ok-oo-oe-o-uu-uue-uu-foo';
    }
    self::assertSame($expected, URLify::filter($str));
  }

  public function test_xss()
  {
    $str = '<script>alert(\'lall\')</script><svg onload=alert(1)>';
    self::assertSame('alert-lall', URLify::filter($str));
  }

  public function test_invalid_char()
  {
    $str = "tes\xE9ting";
    self::assertSame('testing', URLify::filter($str));

    $str = 'W%F6bse';
    self::assertSame('Woebse', URLify::filter($str, 200, 'de', false, false, false, '-', false, true));
  }

  public function test_empty_str()
  {
    $str = '';
    self::assertEmpty(URLify::filter($str));
  }

  public function test_nul_and_non_7_bit()
  {
    $str = "a\x00ñ\x00c";
    self::assertSame('anc', URLify::filter($str));
  }

  public function test_nul()
  {
    $str = "a\x00b\x00c";
    self::assertSame('abc', URLify::filter($str));
  }
}
