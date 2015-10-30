<?php

class SeoSluggerTest extends BaseSluggerTest
{
  public function setUp()
  {
    parent::setUp();
  }

  public function provideSlugFileNames()
  {
    return array(
        array('strings-1.txt'),
        array('pangrams-1.txt'),
    );
  }
}
