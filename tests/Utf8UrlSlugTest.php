<?php

use voku\helper\URLify;

/**
 * Class Utf8UrlSlugTest
 */
class Utf8UrlSlugTest extends PHPUnit_Framework_TestCase
{
  public function test_utf8()
  {
    $str = 'testiñg test.';
    $this->assertSame('testing-test', URLify::filter($str));
  }

  public function test_ascii()
  {
    $str = 'testing - test';
    $this->assertSame('testing-test', URLify::filter($str));
  }

  public function test_multi()
  {
    $str = "川 đņ ōķ ôõ ö+ ÷ø ųú ûü ũū˙ ^ foo \0 \x1 \\";

    $this->assertSame('Chuan-dn-ok-oo-oe-plus-o-uu-uue-uu-foo', URLify::filter($str));
    $this->assertSame('Chuan-dn-ok-oo-oe-apeng-o-uu-uue-uu-foo', URLify::filter($str, 0, 'by'));
  }

  public function test_xss()
  {
    $str = '<script>alert(\'lall\')</script><svg onload=alert(1)>';
    $this->assertSame('alert-lall', URLify::filter($str));
  }

  public function test_invalid_char()
  {
    $str = "tes\xE9ting";
    $this->assertSame('testing', URLify::filter($str));

    $str = 'W%F6bse';
    $this->assertSame('Woebse', URLify::filter($str, 200, 'de', false, false, false, '-', false, true));
  }

  public function test_empty_str()
  {
    $str = '';
    $this->assertEmpty(URLify::filter($str));
  }

  public function test_nul_and_non_7_bit()
  {
    $str = "a\x00ñ\x00c";
    $this->assertSame('anc', URLify::filter($str));
  }

  public function test_nul()
  {
    $str = "a\x00b\x00c";
    $this->assertSame('abc', URLify::filter($str));
  }

  public function test_html()
  {
    $str = '<p class="label-key" title="2014-03-12 13:06:53Z"><b>3   years ago !!!!</b></p>';
    $this->assertSame('3-years-ago', URLify::filter($str));
  }
}
