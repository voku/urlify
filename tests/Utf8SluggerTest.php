<?php

/**
 * Class Utf8SluggerTest
 */
class Utf8SluggerTest extends BaseSluggerTest
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
        array('iso-8859-1.txt'),
        array('iso-8859-2.txt'),
        array('iso-8859-3.txt'),
        array('iso-8859-4.txt'),
        array('pangrams.txt'),
        array('arabic.txt'),
        array('hebrew.txt'),
        array('japanese.txt'),
    );
  }
}
