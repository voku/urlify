<?php

use voku\helper\URLify;

/**
 * Class BaseSluggerTest
 */
abstract class BaseSluggerTest extends \PHPUnit\Framework\TestCase
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
    $inputStrings = file($this->inputFixturesDir . DIRECTORY_SEPARATOR . $fileName, FILE_IGNORE_NEW_LINES);
    $expectedSlugs = file($this->expectedFixturesDir . DIRECTORY_SEPARATOR . $fileName, FILE_IGNORE_NEW_LINES);

    $slugger = $this->slugger;
    $slugs = array_map(
        function ($string) use ($slugger) {
          /** @noinspection StaticInvocationViaThisInspection */
          /** @noinspection PhpStaticAsDynamicMethodCallInspection */
          return $slugger->slug($string, 'en', '-', true);
        }, $inputStrings
    );

    foreach ($expectedSlugs as $key => $expectedSlugValue) {
      self::assertSame($expectedSlugs[$key], $slugs[$key], 'tested-file: ' . $fileName . ' | ' . $slugs[$key]);
    }

    self::assertSame($expectedSlugs, $slugs, 'tested-file: ' . $fileName);
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
  public function provideSlugEdgeCases(): array
  {
    return [
        ['', ''],
        ['    ', ''],
        ['-', ''],
        ['-A', 'a'],
        ['A-', 'a'],
        ['-----', ''],
        ['-a-A-A-a-', 'a-a-a-a'],
        ['A-a-A-a-A-a', 'a-a-a-a-a-a'],
        [' -- ', ''],
        ['a--A', 'a-a'],
        ['a- -A', 'a-a'],
        ['a-&nbsp;-A', 'a-a'],
        ['a-' . html_entity_decode('&nbsp;') . '-A', 'a-a'],
        ['a - ' . html_entity_decode('&nbsp;') . ' -A', 'a-a'],
        [' - - ', ''],
        [' -A- ', 'a'],
        [' - A - ', 'a'],
        ["\0", ''],
        [true, '1'],
        [false, ''],
        [1, '1'],
    ];
  }
}
