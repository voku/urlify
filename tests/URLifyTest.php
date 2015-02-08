<?php

class URLifyTest extends PHPUnit_Framework_TestCase
{

  public function testDowncode()
  {
    $this->assertEquals('  J\'etudie le francais  ', URLify::downcode('  J\'étudie le français  '));
    $this->assertEquals('Lo siento, no hablo espanol.', URLify::downcode('Lo siento, no hablo español.'));
    $this->assertEquals('F3PWS, 中文空白', URLify::downcode('ΦΞΠΏΣ, 中文空白', 'de', true));
    $this->assertEquals('F3PWS, ', URLify::downcode('ΦΞΠΏΣ, 中文空白', 'de', false));
    $this->assertEquals('foo-bar', URLify::filter('_foo_bar_'));
  }

  public function testDefaultFilter()
  {
    $testArray = array(
        '  J\'étudie le français  '                                                    => 'J-etudie-le-francais',
        'Lo siento, no hablo español.'                                                 => 'Lo-siento-no-hablo-espanol',
        '—ΦΞΠΏΣ—Test—'                                                                 => 'F3PWS-Test',
        '大般若經'                                                                         => '',
        'ياكرهي لتويتر'                                                                => 'ykrhy-ltoytr',
        "test\xe2\x80\x99öäü"                                                          => 'test-oeaeue',
        'Ɓtest'                                                                        => 'Btest',
        '-ABC-中文空白'                                                                    => 'ABC',
        ' '                                                                            => '',
        ''                                                                             => '',
        '<strong>Subject<BR class="test">from a<br style="clear:both;" />CMS</strong>' => 'Subject-from-a-CMS'
    );

    foreach ($testArray as $before => $after) {
      $this->assertEquals($after, URLify::filter($before), $before);
    }
  }

  public function testFilterLanguage()
  {
    $testArray = array(
        'abz'        => array('أبز' => 'ar'),
        ''           => array('' => 'ar'),
        'testoeaeue' => array('testöäü' => 'ar'),
    );

    foreach ($testArray as $after => $beforeArray) {
      foreach ($beforeArray as $before => $lang) {
        $this->assertEquals($after, URLify::filter($before, 60, $lang), $before);
      }
    }
  }

  public function testFilterFile()
  {
    $testArray = array(
        'test-.txt'   => 'test-大般若經.txt',
        'foto.jpg'    => 'фото.jpg',
        'Foto.jpg'    => 'Фото.jpg',
        'oeaeue-test' => 'öäü  - test',
        ''            => ' ',
    );

    foreach ($testArray as $after => $before) {
      $this->assertEquals($after, URLify::filter($before, 60, 'de', true), $before);
    }

    // clean file-names
    $this->assertEquals('foto.jpg', URLify::filter('Фото.jpg', 60, 'de', true, false, true));

  }

  public function testFilter()
  {
    $this->assertEquals('AeOeUeaeoeue-der-AeOeUeaeoeue', URLify::filter('ÄÖÜäöü&amp;der & ÄÖÜäöü', 60, 'de', false));
    $this->assertEquals('AeOeUeaeoeue-der', URLify::filter('ÄÖÜäöü-der', 60, 'de', false));
    $this->assertEquals('aeoeueaeoeue der', URLify::filter('ÄÖÜäöü-der', 60, 'de', false, false, true, ' '));
    $this->assertEquals('aeoeueaeoeue#der', URLify::filter('####ÄÖÜäöü-der', 60, 'de', false, false, true, '#'));
    $this->assertEquals('AeOeUeaeoeue', URLify::filter('ÄÖÜäöü-der-die-das', 60, 'de', false, true));
    $this->assertEquals('Bobby-McFerrin-Don-t-worry-be-happy', URLify::filter('Bobby McFerrin — Don\'t worry be happy', 600, 'en'));
    $this->assertEquals('OUaeou', URLify::filter('ÖÜäöü', 60, 'tr'));
  }

  public function testAddArrayToSeperator()
  {
    if ('glibc' === ICONV_IMPL) {
      $this->assertEquals('R-14-14-34-test', URLify::filter('¿ ® ¼ ¼ ¾ test ¶'));
    } else {
      $this->assertEquals('R-14-14-34-test-P', URLify::filter('¿ ® ¼ ¼ ¾ test ¶'));
    }

    URLify::add_array_to_seperator(
        array(
            "/®/",
            "/test/"
        )
    );
    if ('glibc' === ICONV_IMPL) {
      $this->assertEquals('14-14-34', URLify::filter('¿ ® ¼ ¼ ¾ ¶'));
    } else {
      $this->assertEquals('14-14-34-P', URLify::filter('¿ ® ¼ ¼ ¾ ¶'));
    }
  }

  public function testAddChars()
  {
    if ('glibc' === ICONV_IMPL) {
      $this->assertEquals('? (R) 1/4 1/4 3/4 ?', URLify::downcode('¿ ® ¼ ¼ ¾ ¶', 'latin', false, '?'));
    } else {
      $this->assertEquals('? (R) 1/4 1/4 3/4 P', URLify::downcode('¿ ® ¼ ¼ ¾ ¶', 'latin', false, '?'));
    }

    URLify::add_chars(
        array(
            '¿' => '?',
            '®' => '(r)',
            '¼' => '1/4',
            '¾' => '3/4',
            '¶' => 'p'
        )
    );
    $this->assertEquals('? (r) 1/4 1/4 3/4 p', URLify::downcode('¿ ® ¼ ¼ ¾ ¶'));
  }

  public function testRemoveWords()
  {
    $this->assertEquals('foo-bar', URLify::filter('foo bar', 60, 'de', false, true));
    URLify::remove_words(
        array(
            'foo',
            'bar'
        ), 'de'
    );
    $this->assertEquals('', URLify::filter('foo bar', 60, 'de', false, true));
  }

  public function testManyRoundsWithUnknownLanguageCode()
  {
    $result = array();
    for ($i = 0; $i < 100; $i++) {
      $result[] = URLify::downcode('Lo siento, no hablo español.', $i);
    }

    foreach ($result as $res) {
      $this->assertEquals('Lo siento, no hablo espanol.', $res);
    }
  }

}

