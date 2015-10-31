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
      self::assertEquals($after, URLify::downcode($before), $before);
      self::assertEquals($after, URLify::transliterate($before), $before);
    }

    self::assertEquals('F3PWS, 中文空白', URLify::downcode('ΦΞΠΏΣ, 中文空白', 'de', true));
    self::assertEquals('F3PWS, Zhong Wen Kong Bai ', URLify::downcode('ΦΞΠΏΣ, 中文空白', 'de', false));
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
        self::assertEquals($after, URLify::filter($before, 200, 'de', false, false, false, '-', false, true), $before);
      }
    }

    // test static cache
    self::assertEquals('foo-bar', URLify::filter('_foo_bar_'));
    self::assertEquals('foo-bar', URLify::filter('_foo_bar_'));

    // test no language
    self::assertEquals('', URLify::filter('_foo_bar_', -1, ''));

    // test no "seperator"
    self::assertEquals('foo-bar', URLify::filter('_foo_bar_', -1, 'de', false, false, false, ''));

    // test new "seperator"
    self::assertEquals('foo_bar', URLify::filter('_foo_bar_', -1, 'de', false, false, false, '_'));
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
        self::assertEquals($after, URLify::filter($before, 60, $lang), $before);
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
      self::assertEquals($after, URLify::filter($before, 60, 'de', true, false, false, '-', false, true), $before);
    }

    // clean file-names
    self::assertEquals('foto.jpg', URLify::filter('Фото.jpg', 60, 'de', true, false, true));

  }

  public function testFilter()
  {
    self::assertEquals('AeOeUeaeoeue-der-AeOeUeaeoeue', URLify::filter('ÄÖÜäöü&amp;der & ÄÖÜäöü', 60, 'de', false));
    self::assertEquals('AeOeUeaeoeue-der', URLify::filter('ÄÖÜäöü-der', 60, 'de', false));
    self::assertEquals('aeoeueaeoeue der', URLify::filter('ÄÖÜäöü-der', 60, 'de', false, false, true, ' '));
    self::assertEquals('aeoeueaeoeue#der', URLify::filter('####ÄÖÜäöü-der', 60, 'de', false, false, true, '#'));
    self::assertEquals('AeOeUeaeoeue', URLify::filter('ÄÖÜäöü-der-die-das', 60, 'de', false, true));
    self::assertEquals('Bobby-McFerrin-Don-t-worry-be-happy', URLify::filter('Bobby McFerrin — Don\'t worry be happy', 600, 'en'));
    self::assertEquals('OUaeou', URLify::filter('ÖÜäöü', 60, 'tr'));
    self::assertEquals('hello-zs-privet', URLify::filter('hello žš, привет', 60, 'ru'));
    // test stripping and conversion of UTF-8 spaces
    self::assertEquals('Xiang-Jing-Zhen-Ren-test-Mahito-Mukai', URLify::filter('向井　真人test　(Mahito Mukai)'));
  }

  public function testFilterAllLanguages()
  {
    self::assertEquals('Dj-sh-l-cr-aaaaaeaaeOOOOOe141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'de'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'latin'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'latin_symbols'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'el'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'tr'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'ru'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'uk'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'cs'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'pl'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'ro'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'lv'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'lt'));
    self::assertEquals('D-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'vn'));
    self::assertEquals('D-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'ar'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'sr'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'az'));
    self::assertEquals('Dj-sh-l-cr-aaaaaaaeOOOOO141234SSucdthu', URLify::filter('Đ-щ-λ—©®±àáâãäåæÒÓÔÕÖ¼½¾§µçðþú–', -1, 'other'));
  }

  public function testAddArrayToSeparator()
  {
    self::assertEquals('r-14-14-34-test-P', URLify::filter('¿ ® ¼ ¼ ¾ test ¶'));

    URLify::add_array_to_separator(
        array(
            '/®/',
            '/tester/'
        )
    );
    self::assertEquals('14-14-34-P', URLify::filter('¿ ® ¼ ¼ ¾ ¶'));
    URLify::reset_array_to_separator();
  }

  public function testAddChars()
  {
    self::assertEquals('? (r) 1/4 1/4 3/4 P', URLify::downcode('¿ ® ¼ ¼ ¾ ¶', 'latin', false, '?'));

    URLify::add_chars(
        array(
            '¿' => '?',
            '®' => '(r)',
            '¼' => '1/4',
            '¾' => '3/4',
            '¶' => 'p'
        )
    );
    self::assertEquals('? (r) 1/4 1/4 3/4 p', URLify::downcode('¿ ® ¼ ¼ ¾ ¶'));
  }

  public function testRemoveWords()
  {
    self::assertEquals('foo-bar', URLify::filter('foo bar', 60, 'de', false, true));

    // append (array)
    URLify::remove_words(
        array(
            'foo',
            'bar'
        ),
        'de',
        true
    );
    self::assertEquals('', URLify::filter('foo bar', 60, 'de', false, true));

    // append (string)
    URLify::remove_words('lall', 'de', true);
    self::assertEquals('123', URLify::filter('foo bar lall 123 ', 60, 'de', false, true));

    // reset
    URLify::reset_remove_list();

    // replace
    self::assertEquals('foo-bar', URLify::filter('foo bar', 60, 'de', false, true));
    URLify::remove_words(
        array(
            'foo',
            'bar'
        ),
        'de',
        false
    );
    self::assertEquals('', URLify::filter('foo bar', 60, 'de', false, true));

    // reset
    URLify::reset_remove_list();
  }

  public function testManyRoundsWithUnknownLanguageCode()
  {
    $result = array();
    for ($i = 0; $i < 100; $i++) {
      $result[] = URLify::downcode('Lo siento, no hablo español.', $i);
    }

    foreach ($result as $res) {
      self::assertEquals('Lo siento, no hablo espanol.', $res);
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
      self::assertEquals($after, URLify::filter($before, 100, 'latin', false, true, true, '-'));
    }

    $tests = array(
        '  -ABC-中文空白-  ' => 'abc',
        '      - ÖÄÜ- '  => 'oau',
        '  öäüabc'       => 'oau',
        ' DÃ¼sseldorf'   => 'dus',
        'Abcdef'         => 'abcd',
    );

    foreach ($tests as $before => $after) {
      self::assertEquals($after, URLify::filter($before, 4, 'latin', false, true, true, '-', false, true), $before);
    }

    $tests = array(
        'Facebook bekämpft erstmals Durchsuchungsbefehle' => 'facebook-bekaempft-erstmals-durchsuchungsbefehle',
        '  -ABC-中文空白-  '                                  => 'abc-zhong-wen-kong-bai',
        '      - ÖÄÜ- '                                   => 'oeaeue',
        'öäü'                                             => 'oeaeue'
    );

    foreach ($tests as $before => $after) {
      self::assertEquals($after, URLify::filter($before, 100, 'de', false, true, true, '-'), $before);
    }
  }

  public function testGetRemoveList()
  {
    $test = new URLify();
    $test->reset_remove_list();

    $removeArray = $this->invokeMethod($test, 'get_remove_list', array('de'));
    self::assertEquals(true, is_array($removeArray));
    self::assertEquals(true, in_array('ein', $removeArray, true));

    $removeArray = $this->invokeMethod($test, 'get_remove_list', array(''));
    self::assertEquals(true, is_array($removeArray));
    self::assertEquals(false, in_array('ein', $removeArray, true));
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
