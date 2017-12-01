<?php

/**
 * Class Utf8SluggerTest
 */
class Utf8SluggerTest extends BaseSluggerTest
{
  /**
   * set-up
   */
  public function setUp()
  {
    parent::setUp();
  }

  /**
   * @return array
   */
  public function provideSlugFileNames(): array
  {
    return [
        ['iso-8859-1.txt'],
        ['iso-8859-2.txt'],
        ['iso-8859-3.txt'],
        ['iso-8859-4.txt'],
        ['pangrams.txt'],
        ['arabic.txt'],
        ['hebrew.txt'],
        ['japanese.txt'],
    ];
  }
}
