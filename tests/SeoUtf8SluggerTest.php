<?php

class SeoUtf8SluggerTest extends BaseSluggerTest
{
  public function setUp()
  {
    parent::setUp();
  }

  public function provideSlugFileNames()
  {
    return array(
        array('strings-2.txt'),
    );
  }
}
