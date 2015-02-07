<?php

class URLifyTest extends PHPUnit_Framework_TestCase
{

  function test_downcode()
  {
    $this->assertEquals('  J\'etudie le francais  ', URLify::downcode('  J\'étudie le français  '));
    $this->assertEquals('Lo siento, no hablo espanol.', URLify::downcode('Lo siento, no hablo español.'));
    $this->assertEquals('F3PWS', URLify::downcode('ΦΞΠΏΣ'));
    $this->assertEquals('foo-bar', URLify::filter('_foo_bar_'));
  }

  function test_filter()
  {
    $this->assertEquals('J-etudie-le-francais', URLify::filter('  J\'étudie le français  '));
    $this->assertEquals('Lo-siento-no-hablo-espanol', URLify::filter('Lo siento, no hablo español.'));
    $this->assertEquals('F3PWS-Test', URLify::filter('—ΦΞΠΏΣ—Test—'));
    $this->assertEquals('', URLify::filter('大般若經'));
    $this->assertEquals('test-.txt', URLify::filter('test-大般若經.txt', 60, '', true));
    $this->assertEquals('ykrhy-ltoytr', URLify::filter('ياكرهي لتويتر'));
    $this->assertEquals('test-oeaeue', URLify::filter("test\xe2\x80\x99öäü"));
    $this->assertEquals('Btest', URLify::filter("Ɓtest "));
    $this->assertEquals('ABC', URLify::filter("-ABC-中文空白"));

    // priorization of language-specific maps
    $this->assertEquals('abz', URLify::filter('أبز', 60, 'ar'));

    $this->assertEquals('foto.jpg', URLify::filter('фото.jpg', 60, 'de', true));
    $this->assertEquals('Foto.jpg', URLify::filter('Фото.jpg', 60, 'de', true));
    $this->assertEquals('foto.jpg', URLify::filter('Фото.jpg', 60, 'de', true, false, true));

    $this->assertEquals('Subject-from-a-CMS', URLify::filter('<strong>Subject<BR class="test">from a<br style="clear:both;" />CMS</strong>', 60, 'de'));

    $this->assertEquals('AeOeUeaeoeue-der-AeOeUeaeoeue', URLify::filter('ÄÖÜäöü&amp;der & ÄÖÜäöü', 60, 'de', false));
    $this->assertEquals('AeOeUeaeoeue-der', URLify::filter('ÄÖÜäöü-der', 60, 'de', false));
    $this->assertEquals('aeoeueaeoeue der', URLify::filter('ÄÖÜäöü-der', 60, 'de', false, false, true, ' '));
    $this->assertEquals('aeoeueaeoeue#der', URLify::filter('####ÄÖÜäöü-der', 60, 'de', false, false, true, '#'));
    $this->assertEquals('AeOeUeaeoeue', URLify::filter('ÄÖÜäöü-der-die-das', 60, 'de', false, true));

    $this->assertEquals('Bobby-McFerrin-Don-t-worry-be-happy', URLify::filter('Bobby McFerrin — Don\'t worry be happy', 600, 'en'));
    $this->assertEquals('OUaeou', URLify::filter('ÖÜäöü', 60, 'tr'));
  }

  function test_add_chars()
  {
    $this->assertEquals('¿ ® ¼ ¼ ¾ ¶', URLify::downcode('¿ ® ¼ ¼ ¾ ¶'));
    URLify::add_chars(
        array(
            '¿' => '?',
            '®' => '(r)',
            '¼' => '1/4',
            '¾' => '3/4',
            '¶' => 'P'
        )
    );
    $this->assertEquals('? (r) 1/4 1/4 3/4 P', URLify::downcode('¿ ® ¼ ¼ ¾ ¶'));
  }

  function test_remove_words()
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

  function test_many_rounds_with_unknown_language_code()
  {
    for ($i = 0; $i < 1000; $i++) {
      URLify::downcode('Lo siento, no hablo español.', -1);
    }
  }

}

