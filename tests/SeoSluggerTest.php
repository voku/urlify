<?php

/**
 * Class SeoSluggerTest
 */
class SeoSluggerTest extends BaseSluggerTest
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
        ['strings-1.txt'],
        ['pangrams-1.txt'],
    ];
  }
}
