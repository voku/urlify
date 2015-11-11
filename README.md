[![Build Status](https://travis-ci.org/voku/urlify.png?branch=master)](https://travis-ci.org/voku/urlify)
[![Coverage Status](https://coveralls.io/repos/github/voku/urlify/badge.svg?branch=master)](https://coveralls.io/github/voku/urlify?branch=master)
[![codecov.io](http://codecov.io/github/voku/urlify/coverage.svg?branch=master)](http://codecov.io/github/voku/urlify?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/voku/urlify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/voku/urlify/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/741def77-3945-4692-a2da-a4feadfb2928/mini.png)](https://insight.sensiolabs.com/projects/741def77-3945-4692-a2da-a4feadfb2928)
[![Dependency Status](https://www.versioneye.com/php/voku:urlify/dev-master/badge.svg)](https://www.versioneye.com/php/voku:urlify/dev-master)
[![Latest Stable Version](https://poser.pugx.org/voku/urlify/v/stable)](https://packagist.org/packages/voku/urlify) [![Total Downloads](https://poser.pugx.org/voku/urlify/downloads)](https://packagist.org/packages/voku/urlify) [![Latest Unstable Version](https://poser.pugx.org/voku/urlify/v/unstable)](https://packagist.org/packages/voku/urlify) [![License](https://poser.pugx.org/voku/urlify/license)](https://packagist.org/packages/voku/urlify)

# URLify for PHP

A PHP port of URLify.js from the Django project + str_transliterate from "Portable UTF-8".

- https://github.com/django/django/blob/master/django/contrib/admin/static/admin/js/urlify.js
- https://github.com/voku/portable-utf8

Handles symbols from Latin languages, Greek, Turkish, Russian, Ukrainian,
Czech, Polish, and Latvian and many other via "str_transliterate".

- Author: [jbroadway](http://github.com/jbroadway) / [voku](http://github.com/voku)
- License: MIT

## Install via "composer require"
```shell
composer require voku/urlify
```

## Usage:

namespace: "voku\helper\URLify"

To generate slugs for URLs:

```php
<?php

echo URLify::filter (' J\'étudie le français ');
// "J-etudie-le-francais"

echo URLify::filter ('Lo siento, no hablo español.');
// "Lo-siento-no-hablo-espanol"

?>
```

To generate slugs for file names:

```php
<?php

echo URLify::filter ('фото.jpg', 60, '', true);
// "foto.jpg"

?>
```


To simply transliterate characters:

```php
<?php

echo URLify::downcode ('J\'étudie le français');
// "J'etudie le francais"

echo URLify::downcode ('Lo siento, no hablo español.');
// "Lo siento, no hablo espanol."

/* Or use transliterate() alias: */

echo URLify::transliterate ('Lo siento, no hablo español.');
// "Lo siento, no hablo espanol."

?>
```

To extend the character list:

```php
<?php

URLify::add_chars (array (
	'¿' => '?', '®' => '(r)', '¼' => '1/4',
	'¼' => '1/2', '¾' => '3/4', '¶' => 'P'
));

echo URLify::downcode ('¿ ® ¼ ¼ ¾ ¶');
// "? (r) 1/2 1/2 3/4 P"

?>
```

To extend or replace the default replacing list:

```php
<?php

URLify::add_array_to_seperator(array (
	"/®/"
)
);

echo URLify::filter('¿ ® ¼ ¼ ¾ ¶');
// "14-14-34-P"

?>
```

To extend the list of words to remove for one language:

```php
<?php

URLify::remove_words (array ('remove', 'these', 'too'), 'de');

?>
```

To prioritize a certain language map:

```php
<?php

echo URLify::filter (' Ägypten und Österreich besitzen wie üblich ein Übermaß an ähnlich öligen Attachés ', 60, 'de');
// "Aegypten-und-Oesterreich-besitzen-wie-ueblich-ein-Uebermass-aehnlich-oeligen-Attaches"
   
echo URLify::filter ('Cağaloğlu, çalıştığı, müjde, lazım, mahkûm', 60, 'tr');
// "Cagaloglu-calistigi-mujde-lazim-mahkum"

?>
```
Please note that the "ü" is transliterated to "ue" in the first case, whereas it results in a simple "u" in the latter.
