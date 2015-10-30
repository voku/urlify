<?php

class SluggerTest extends BaseSluggerTest
{
  public function setUp()
  {
    parent::setUp();
  }

  public function provideSlugFileNames()
  {
    return array(
        array('strings-3.txt'),
    );
  }

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
