<?php

use voku\helper\URLify;

class URLifyTest extends PHPUnit_Framework_TestCase
{

  public function testDowncode()
  {
    $testArray = array(
        '  J\'étudie le français  '    => '  J\'etudie le francais  ',
        'Lo siento, no hablo español.' => 'Lo siento, no hablo espanol.'
    );

    foreach ($testArray as $before => $after) {
      $this->assertEquals($after, URLify::downcode($before), $before);
      $this->assertEquals($after, URLify::transliterate($before), $before);
    }

    $this->assertEquals('F3PWS, 中文空白', URLify::downcode('ΦΞΠΏΣ, 中文空白', 'de', true));
    $this->assertEquals('F3PWS, Zhong Wen Kong Bai ', URLify::downcode('ΦΞΠΏΣ, 中文空白', 'de', false));
  }

  public function testDefaultFilter()
  {
    $testArray = array(
        '  J\'étudie le français  '                                                    => 'J-etudie-le-francais',
        'Lo siento, no hablo español.'                                                 => 'Lo-siento-no-hablo-espanol',
        '—ΦΞΠΏΣ—Test—'                                                                 => 'F3PWS-Test',
        '大般若經'                                                                         => 'Da-Ban-Ruo-Jing',
        'ياكرهي لتويتر'                                                                => 'ykrhy-ltoytr',
        "test\xe2\x80\x99öäü"                                                          => 'test-oeaeue',
        'Ɓtest'                                                                        => 'Btest',
        '-ABC-中文空白'                                                                    => 'ABC-Zhong-Wen-Kong-Bai',
        ' '                                                                            => '',
        ''                                                                             => '',
        '<strong>Subject<BR class="test">from a<br style="clear:both;" />CMS</strong>' => 'Subject-from-a-CMS'
    );

    for ($i = 0; $i < 10; $i++) { // increase this value to test the performance
      foreach ($testArray as $before => $after) {
        $this->assertEquals($after, URLify::filter($before), $before);
      }
    }

    // test static cache
    $this->assertEquals('foo-bar', URLify::filter('_foo_bar_'));
    $this->assertEquals('foo-bar', URLify::filter('_foo_bar_'));

    // test no language
    $this->assertEquals('', URLify::filter('_foo_bar_', -1, ''));

    // test no "seperator"
    $this->assertEquals('foo-bar', URLify::filter('_foo_bar_', -1, 'de', false, false, false, ''));

    // test new "seperator"
    $this->assertEquals('foo_bar', URLify::filter('_foo_bar_', -1, 'de', false, false, false, '_'));
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
        'test-Da-Ban-Ruo-Jing-.txt'             => 'test-大般若經.txt',
        'foto.jpg'                              => 'фото.jpg',
        'Foto.jpg'                              => 'Фото.jpg',
        'oeaeue-test'                           => 'öäü  - test',
        'shdgshdg.png'                          => 'שדגשדג.png',
        'cr-aaaaaeaaeOOOOOe141234SSucdthu-.jpg' => '—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–.jpg',
        '000-c-c.txt'                           => '000—©—©.txt',
        ''                                      => ' ',
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
    $this->assertEquals('hello-zs-privet', URLify::filter('hello žš, привет', 60, 'ru'));
    // test stripping and conversion of UTF-8 spaces
    $this->assertEquals('Xiang-Jing-Zhen-Ren-test-Mahito-Mukai', URLify::filter('向井　真人test　(Mahito Mukai)'));
  }

  public function testFilterAllLanguages()
  {
    $this->assertEquals('Dj-sh-l-cr-aaaaaeaaeOOOOOe141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'de'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'latin'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'latin_symbols'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'el'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'tr'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'ru'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'uk'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'cs'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'pl'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'ro'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'lv'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'lt'));
    $this->assertEquals('D-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'vn'));
    $this->assertEquals('D-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'ar'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'sr'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'az'));
    $this->assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'other'));
  }

  public function testAddArrayToSeperator()
  {
    $this->assertEquals('r-14-14-34-test-P', URLify::filter('¿ ® ¼ ¼ ¾ test ¶'));

    URLify::add_array_to_seperator(
        array(
            '/®/',
            '/tester/'
        )
    );
    $this->assertEquals('14-14-34-P', URLify::filter('¿ ® ¼ ¼ ¾ ¶'));
  }

  public function testAddChars()
  {
    $this->assertEquals('? (r) 1/4 1/4 3/4 P', URLify::downcode('¿ ® ¼ ¼ ¾ ¶', 'latin', false, '?'));

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
    // append
    $this->assertEquals('foo-bar', URLify::filter('foo bar', 60, 'de', false, true));
    URLify::remove_words(
        array(
            'foo',
            'bar'
        ), 'de', true
    );
    $this->assertEquals('', URLify::filter('foo bar', 60, 'de', false, true));

    // reset
    URLify::reset_remove_list();

    // replace
    $this->assertEquals('foo-bar', URLify::filter('foo bar', 60, 'de', false, true));
    URLify::remove_words(
        array(
            'foo',
            'bar'
        ), 'de', false
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

  public function testUrlSlug()
  {
    $tests = array(
        '  -ABC-中文空白-  ' => 'abc-zhong-wen-kong-bai',
        '      - ÖÄÜ- '  => 'oau',
        'öäü'            => 'oau',
        ''               => '',
        ' test test'     => 'test-test',
        'أبز'            => 'abz'
    );

    foreach ($tests as $before => $after) {
      $this->assertEquals($after, URLify::filter($before, 100, 'latin', false, true, true, '-'));
    }

    $tests = array(
        '  -ABC-中文空白-  ' => 'abc',
        '      - ÖÄÜ- '  => 'oau',
        '  öäüabc'       => 'oau',
        ' DÃ¼sseldorf'   => 'dus',
        'Abcdef'         => 'abcd',
    );

    foreach ($tests as $before => $after) {
      $this->assertEquals($after, URLify::filter($before, 4, 'latin', false, true, true, '-', false, true));
    }

    $tests = array(
        'Facebook bekämpft erstmals Durchsuchungsbefehle' => 'facebook-bekaempft-erstmals-durchsuchungsbefehle',
        '  -ABC-中文空白-  '                                  => 'abc-zhong-wen-kong-bai',
        '      - ÖÄÜ- '                                   => 'oeaeue',
        'öäü'                                             => 'oeaeue'
    );

    foreach ($tests as $before => $after) {
      $this->assertEquals($after, URLify::filter($before, 100, 'de', false, true, true, '-'));
    }
  }

  public function testGetRemoveList()
  {
    $test = new URLify();
    $test->reset_remove_list();

    $removeArray = $this->invokeMethod($test, 'get_remove_list', array('de'));
    $this->assertEquals(true, is_array($removeArray));
    $this->assertEquals(true, in_array('ein', $removeArray));

    $removeArray = $this->invokeMethod($test, 'get_remove_list', array(''));
    $this->assertEquals(true, is_array($removeArray));
    $this->assertEquals(false, in_array('ein', $removeArray));
  }

  /**
   * Call protected/private method of a class.
   *
   * @param object &$object    Instantiated object that we will run method on.
   * @param string $methodName Method name to call
   * @param array  $parameters Array of parameters to pass into method.
   *
   * @return mixed Method return.
   */
  public function invokeMethod(&$object, $methodName, array $parameters = array())
  {
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
  }
}
