<?php

namespace voku\tests;

/**
 * Class SeoSluggerTest
 *
 * @internal
 */
final class SeoSluggerTest extends BaseSluggerTest
{
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
