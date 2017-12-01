<?php

/**
 * Class SeoUtf8SluggerTest
 */
class SeoUtf8SluggerTest extends BaseSluggerTest
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
        ['strings-2.txt'],
        ['sample-utf-8-bom.txt'],
        ['sample-unicode-chart.txt'],
    ];
  }
}
