<?php

/**
 * Class SeoSluggerTest
 */
class SeoSluggerTest extends BaseSluggerTest
{
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
        array('strings-1.txt'),
        array('pangrams-1.txt'),
    );
  }
}
