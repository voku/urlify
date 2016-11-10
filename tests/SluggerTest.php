<?php

/**
 * Class SluggerTest
 */
class SluggerTest extends BaseSluggerTest
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
        array('strings-3.txt'),
    );
  }

  /**
   * @return array
   */
  public function provideSlugFileNamesWithNull()
  {
    return array(
        array('iso-8859-1-1.txt'),
        array('iso-8859-2-1.txt'),
        array('iso-8859-3-1.txt'),
        array('iso-8859-4-1.txt'),
    );
  }
}
