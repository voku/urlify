<?php

use voku\helper\URLify;

/**
 * Class BaseSluggerTest
 */
abstract class BaseSluggerTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @var string
   */
  protected $sluggerClassName = 'URLify';

  /**
   * @var URLify
   */
  protected $slugger;

  /**
   * @var string
   */
  protected $inputFixturesDir;

  /**
   * @var string
   */
  protected $expectedFixturesDir;

  public function setUp()
  {
    $sluggerClassNamespace = '\\voku\\helper\\' . $this->sluggerClassName;
    $this->slugger = new $sluggerClassNamespace();

    $fixturesBaseDir = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . strtolower($this->sluggerClassName);
    $this->inputFixturesDir = $fixturesBaseDir . DIRECTORY_SEPARATOR . 'input';
    $this->expectedFixturesDir = $fixturesBaseDir . DIRECTORY_SEPARATOR . 'expected';
  }

  /**
   * @dataProvider provideSlugFileNames
   *
   * @param $fileName
   */
  public function testDefaultSlugify($fileName)
  {
    $inputStrings = file($this->inputFixturesDir . DIRECTORY_SEPARATOR  . $fileName, FILE_IGNORE_NEW_LINES);
    $expectedSlugs = file($this->expectedFixturesDir . DIRECTORY_SEPARATOR  . $fileName, FILE_IGNORE_NEW_LINES);

    $slugger = $this->slugger;
    $slugs = array_map(
        function ($string) use ($slugger) {
          /** @noinspection StaticInvocationViaThisInspection */
          return $slugger->slug($string, 'en', '-', true);
        }, $inputStrings
    );

    if (version_compare(PHP_VERSION, '5.4.0', '<')) {
      self::markTestSkipped('TODO: not working with PHP < 5.4');
    } else {
      foreach ($expectedSlugs as $key => $expectedSlugValue) {
        self::assertSame($expectedSlugs[$key], $slugs[$key], 'tested-file: ' . $fileName . ' | ' . $slugs[$key]);
      }

      self::assertSame($expectedSlugs, $slugs, 'tested-file: ' . $fileName);
    }
  }

  public function testSlugifyOptions()
  {
    $input = ' a+A+ - a+A_a _';
    $output = URLify::slug($input, 'de', '_', true);

    self::assertSame('a_a_a_a_a', $output);
  }

  public function testSlugifyOptionsV2()
  {
    $input = ' a+A+ - a+A_a _ ♥';
    $output = URLify::slug($input, 'ar', '_', true);

    self::assertSame('a_a_a_a_a_hb', $output);
  }

  /**
   * @dataProvider provideSlugEdgeCases
   *
   * @param $string
   * @param $expectedSlug
   */
  public function testSlugifyEdgeCases($string, $expectedSlug)
  {
    $slug = URLify::slug($string, 'de', '-', true);

    self::assertSame($expectedSlug, $slug);
  }

  /**
   * @return array
   */
  public function provideSlugEdgeCases()
  {
    return array(
        array('', ''),
        array('    ', ''),
        array('-', ''),
        array('-A', 'a'),
        array('A-', 'a'),
        array('-----', ''),
        array('-a-A-A-a-', 'a-a-a-a'),
        array('A-a-A-a-A-a', 'a-a-a-a-a-a'),
        array(' -- ', ''),
        array('a--A', 'a-a'),
        array('a- -A', 'a-a'),
        array('a-&nbsp;-A', 'a-a'),
        array('a-' . html_entity_decode('&nbsp;') . '-A', 'a-a'),
        array('a - ' . html_entity_decode('&nbsp;') . ' -A', 'a-a'),
        array(' - - ', ''),
        array(' -A- ', 'a'),
        array(' - A - ', 'a'),
        array(null, ''),
        array(true, '1'),
        array(false, ''),
        array(1, '1'),
    );
  }
}
