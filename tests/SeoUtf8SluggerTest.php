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
  public function provideSlugFileNames()
  {
    return array(
        array('strings-2.txt'),
    );
  }
}
