<?php

namespace voku\helper;

/**
 * A PHP port of URLify.js from the Django project + str_transliterate from "Portable UTF-8".
 *
 * - https://github.com/django/django/blob/master/django/contrib/admin/static/admin/js/urlify.js
 * - https://github.com/voku/portable-utf8
 *
 * Handles symbols from latin languages, Arabic, Azerbaijani, Bulgarian, Burmese, Croatian, Czech, Danish, Esperanto,
 * Estonian, Finnish, French, Switzerland (French), Austrian (French), Georgian, German, Switzerland (German),
 * Austrian (German), Greek, Hindi, Latvian, Lithuanian, Norwegian, Persian, Polish, Romanian, Russian, Swedish,
 * Serbian, Turkish, Ukrainian and Vietnamese ... and many other via "str_transliterate".
 */
class URLify
{

  /**
   * The language-mapping array.
   *
   * ISO 639-1 codes: https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
   *
   * @var array
   */
  public static $maps = array(
    // Greek
    'el'            => array(
        '='  => ' ίσος ',
        '%'  => ' τοις εκατό ',
        '∑'  => ' άθροισμα ',
        '∆'  => ' δέλτα ',
        '∞'  => ' άπειρο ',
        '♥'  => ' αγάπη ',
        '&'  => ' και ',
        '+'  => ' συν ',
        //
        'α'  => 'a',
        'β'  => 'b',
        'γ'  => 'g',
        'δ'  => 'd',
        'ε'  => 'e',
        'ζ'  => 'z',
        'η'  => 'h',
        'θ'  => '8',
        'ι'  => 'i',
        'κ'  => 'k',
        'λ'  => 'l',
        'μ'  => 'm',
        'ν'  => 'n',
        'ξ'  => '3',
        'ο'  => 'o',
        'π'  => 'p',
        'ρ'  => 'r',
        'σ'  => 's',
        'τ'  => 't',
        'υ'  => 'y',
        'φ'  => 'f',
        'χ'  => 'x',
        'ψ'  => 'ps',
        'ω'  => 'w',
        'ά'  => 'a',
        'έ'  => 'e',
        'ί'  => 'i',
        'ό'  => 'o',
        'ύ'  => 'y',
        'ή'  => 'h',
        'ώ'  => 'w',
        'ς'  => 's',
        'ϊ'  => 'i',
        'ΰ'  => 'y',
        'ϋ'  => 'y',
        'ΐ'  => 'i',
        'Α'  => 'A',
        'Β'  => 'B',
        'Γ'  => 'G',
        'Δ'  => 'D',
        'Ε'  => 'E',
        'Ζ'  => 'Z',
        'Η'  => 'H',
        'Θ'  => '8',
        'Ι'  => 'I',
        'Κ'  => 'K',
        'Λ'  => 'L',
        'Μ'  => 'M',
        'Ν'  => 'N',
        'Ξ'  => '3',
        'Ο'  => 'O',
        'Π'  => 'P',
        'Ρ'  => 'R',
        'Σ'  => 'S',
        'Τ'  => 'T',
        'Υ'  => 'Y',
        'Φ'  => 'F',
        'Χ'  => 'X',
        'Ψ'  => 'PS',
        'Ω'  => 'W',
        'Ά'  => 'A',
        'Έ'  => 'E',
        'Ί'  => 'I',
        'Ό'  => 'O',
        'Ύ'  => 'Y',
        'Ή'  => 'H',
        'Ώ'  => 'W',
        'Ϊ'  => 'I',
        'Ϋ'  => 'Y',
        'ΑΥ' => 'AU',
        'Αυ' => 'Au',
        'ΟΥ' => 'OU',
        'Ου' => 'Ou',
        'ΕΥ' => 'EU',
        'Ευ' => 'Eu',
        'ΕΙ' => 'I',
        'Ει' => 'I',
        'ΟΙ' => 'I',
        'Οι' => 'I',
        'ΥΙ' => 'I',
        'Υι' => 'I',
        'ΑΎ' => 'AU',
        'Αύ' => 'Au',
        'ΟΎ' => 'OU',
        'Ού' => 'Ou',
        'ΕΎ' => 'EU',
        'Εύ' => 'Eu',
        'ΕΊ' => 'I',
        'Εί' => 'I',
        'ΟΊ' => 'I',
        'Οί' => 'I',
        'ΎΙ' => 'I',
        'Ύι' => 'I',
        'ΥΊ' => 'I',
        'Υί' => 'I',
        'αυ' => 'au',
        'ου' => 'ou',
        'ευ' => 'eu',
        'ει' => 'i',
        'οι' => 'i',
        'υι' => 'i',
        'αύ' => 'au',
        'ού' => 'ou',
        'εύ' => 'eu',
        'εί' => 'i',
        'οί' => 'i',
        'ύι' => 'i',
        'υί' => 'i',
        'ϐ'  => 'v',
        'ϑ'  => 'th',
    ),
    // Hindi
    'hi'            => array(
        '='  => ' समान ',
        '%'  => ' प्रतिशत ',
        '∑'  => ' योग ',
        '∆'  => ' डेल्टा ',
        '∞'  => ' अनंत ',
        '♥'  => ' प्यार ',
        '&'  => ' और ',
        '+'  => ' प्लस ',
        //
        'अ'  => 'a',
        'आ'  => 'aa',
        'ए'  => 'e',
        'ई'  => 'ii',
        'ऍ'  => 'ei',
        'ऎ'  => 'ae',
        'ऐ'  => 'ai',
        'इ'  => 'i',
        'ओ'  => 'o',
        'ऑ'  => 'oi',
        'ऒ'  => 'oii',
        'ऊ'  => 'uu',
        'औ'  => 'ou',
        'उ'  => 'u',
        'ब'  => 'B',
        'भ'  => 'Bha',
        'च'  => 'Ca',
        'छ'  => 'Chha',
        'ड'  => 'Da',
        'ढ'  => 'Dha',
        'फ'  => 'Fa',
        'फ़' => 'Fi',
        'ग'  => 'Ga',
        'घ'  => 'Gha',
        'ग़' => 'Ghi',
        'ह'  => 'Ha',
        'ज'  => 'Ja',
        'झ'  => 'Jha',
        'क'  => 'Ka',
        'ख'  => 'Kha',
        'ख़' => 'Khi',
        'ल'  => 'L',
        'ळ'  => 'Li',
        'ऌ'  => 'Li',
        'ऴ'  => 'Lii',
        'ॡ'  => 'Lii',
        'म'  => 'Ma',
        'न'  => 'Na',
        'ङ'  => 'Na',
        'ञ'  => 'Nia',
        'ण'  => 'Nae',
        'ऩ'  => 'Ni',
        'ॐ'  => 'oms',
        'प'  => 'Pa',
        'क़' => 'Qi',
        'र'  => 'Ra',
        'ऋ'  => 'Ri',
        'ॠ'  => 'Ri',
        'ऱ'  => 'Ri',
        'स'  => 'Sa',
        'श'  => 'Sha',
        'ष'  => 'Shha',
        'ट'  => 'Ta',
        'त'  => 'Ta',
        'ठ'  => 'Tha',
        'द'  => 'Tha',
        'थ'  => 'Tha',
        'ध'  => 'Thha',
        'ड़' => 'ugDha',
        'ढ़' => 'ugDhha',
        'व'  => 'Va',
        'य'  => 'Ya',
        'य़' => 'Yi',
        'ज़' => 'Za',
    ),
    // Swedish
    'sv'            => array(
        'Ä' => 'A',
        'Å' => 'a',
        'Ö' => 'O',
        'ä' => 'a',
        'å' => 'a',
        'ö' => 'o',
    ),
    // Turkish
    'tr'            => array(
        '=' => ' eşit ',
        '%' => ' yüzde ',
        '∑' => ' Toplam ',
        '∆' => ' delta ',
        '∞' => ' sonsuzluk ',
        '♥' => ' Aşk ',
        '&' => ' ve ',
        '+' => ' artı ',
        //
        'ş' => 's',
        'Ş' => 'S',
        'ı' => 'i',
        'İ' => 'I',
        'ç' => 'c',
        'Ç' => 'C',
        'ü' => 'u',
        'Ü' => 'U',
        'ö' => 'o',
        'Ö' => 'O',
        'ğ' => 'g',
        'Ğ' => 'G',
    ),
    // Bulgarian
    'bg'            => array(
        '='  => ' равен ',
        '%'  => ' на сто ',
        '∑'  => ' сума ',
        '∆'  => ' делта ',
        '∞'  => ' безкрайност ',
        '♥'  => ' обичам ',
        '&'  => ' и ',
        '+'  => ' плюс ',
        //
        'Щ'  => 'Sht',
        'Ш'  => 'Sh',
        'Ч'  => 'Ch',
        'Ц'  => 'C',
        'Ю'  => 'Yu',
        'Я'  => 'Ya',
        'Ж'  => 'J',
        'А'  => 'A',
        'Б'  => 'B',
        'В'  => 'V',
        'Г'  => 'G',
        'Д'  => 'D',
        'Е'  => 'E',
        'З'  => 'Z',
        'И'  => 'I',
        'Й'  => 'Y',
        'К'  => 'K',
        'Л'  => 'L',
        'М'  => 'M',
        'Н'  => 'N',
        'О'  => 'O',
        'П'  => 'P',
        'Р'  => 'R',
        'С'  => 'S',
        'Т'  => 'T',
        'У'  => 'U',
        'Ф'  => 'F',
        'Х'  => 'H',
        'Ь'  => '',
        'Ъ'  => 'A',
        'щ'  => 'sht',
        'ш'  => 'sh',
        'ч'  => 'ch',
        'ц'  => 'c',
        'ю'  => 'yu',
        'я'  => 'ya',
        'ж'  => 'j',
        'а'  => 'a',
        'б'  => 'b',
        'в'  => 'v',
        'г'  => 'g',
        'д'  => 'd',
        'е'  => 'e',
        'з'  => 'z',
        'и'  => 'i',
        'й'  => 'y',
        'к'  => 'k',
        'л'  => 'l',
        'м'  => 'm',
        'н'  => 'n',
        'о'  => 'o',
        'п'  => 'p',
        'р'  => 'r',
        'с'  => 's',
        'т'  => 't',
        'у'  => 'u',
        'ф'  => 'f',
        'х'  => 'h',
        'ь'  => '',
        'ъ'  => 'a',
        'ия' => 'ia',
        'йо' => 'iо',
        'ьо' => 'io',
    ),
    // Burmese
    'by'            =>
        array(
            '='     => ' တန်းတူညီမျှ ',
            '%'     => ' ရာခိုင်နှုန်းက ',
            '∑'     => ' လဒ် ',
            '∆'     => ' မြစ်ဝကျွန်းပေါ် ',
            '∞'     => ' အဆုံးမဲ့ ',
            '♥'     => ' မေတ္တာ ',
            '&'     => ' နဲ့ ',
            '+'     => ' အပေါင်း ',
            //
            'က'     => 'k',
            'ခ'     => 'kh',
            'ဂ'     => 'g',
            'ဃ'     => 'ga',
            'င'     => 'ng',
            'စ'     => 's',
            'ဆ'     => 'sa',
            'ဇ'     => 'z',
            'စျ'    => 'za',
            'ည'     => 'ny',
            'ဋ'     => 't',
            'ဌ'     => 'ta',
            'ဍ'     => 'd',
            'ဎ'     => 'da',
            'ဏ'     => 'na',
            'တ'     => 't',
            'ထ'     => 'ta',
            'ဒ'     => 'd',
            'ဓ'     => 'da',
            'န'     => 'n',
            'ပ'     => 'p',
            'ဖ'     => 'pa',
            'ဗ'     => 'b',
            'ဘ'     => 'ba',
            'မ'     => 'm',
            'ယ'     => 'y',
            'ရ'     => 'ya',
            'လ'     => 'l',
            'ဝ'     => 'w',
            'သ'     => 'th',
            'ဟ'     => 'h',
            'ဠ'     => 'la',
            'အ'     => 'a',
            'ြ'     => 'y',
            'ျ'     => 'ya',
            'ွ'     => 'w',
            'ြွ'    => 'yw',
            'ျွ'    => 'ywa',
            'ှ'     => 'h',
            'ဧ'     => 'e',
            '၏'     => '-e',
            'ဣ'     => 'i',
            'ဤ'     => '-i',
            'ဉ'     => 'u',
            'ဦ'     => '-u',
            'ဩ'     => 'aw',
            'သြော'  => 'aw',
            'ဪ'     => 'aw',
            '၍'     => 'ywae',
            '၌'     => 'hnaik',
            '၀'     => '0',
            '၁'     => '1',
            '၂'     => '2',
            '၃'     => '3',
            '၄'     => '4',
            '၅'     => '5',
            '၆'     => '6',
            '၇'     => '7',
            '၈'     => '8',
            '၉'     => '9',
            '္'     => '',
            '့'     => '',
            'း'     => '',
            'ာ'     => 'a',
            'ါ'     => 'a',
            'ေ'     => 'e',
            'ဲ'     => 'e',
            'ိ'     => 'i',
            'ီ'     => 'i',
            'ို'    => 'o',
            'ု'     => 'u',
            'ူ'     => 'u',
            'ေါင်'  => 'aung',
            'ော'    => 'aw',
            'ော်'   => 'aw',
            'ေါ'    => 'aw',
            'ေါ်'   => 'aw',
            '်'     => 'at',
            'က်'    => 'et',
            'ိုက်'  => 'aik',
            'ောက်'  => 'auk',
            'င်'    => 'in',
            'ိုင်'  => 'aing',
            'ောင်'  => 'aung',
            'စ်'    => 'it',
            'ည်'    => 'i',
            'တ်'    => 'at',
            'ိတ်'   => 'eik',
            'ုတ်'   => 'ok',
            'ွတ်'   => 'ut',
            'ေတ်'   => 'it',
            'ဒ်'    => 'd',
            'ိုဒ်'  => 'ok',
            'ုဒ်'   => 'ait',
            'န်'    => 'an',
            'ာန်'   => 'an',
            'ိန်'   => 'ein',
            'ုန်'   => 'on',
            'ွန်'   => 'un',
            'ပ်'    => 'at',
            'ိပ်'   => 'eik',
            'ုပ်'   => 'ok',
            'ွပ်'   => 'ut',
            'န်ုပ်' => 'nub',
            'မ်'    => 'an',
            'ိမ်'   => 'ein',
            'ုမ်'   => 'on',
            'ွမ်'   => 'un',
            'ယ်'    => 'e',
            'ိုလ်'  => 'ol',
            'ဉ်'    => 'in',
            'ံ'     => 'an',
            'ိံ'    => 'ein',
            'ုံ'    => 'on',
        ),
    // Croatian
    'hr'            =>
        array(
            '=' => ' Jednaki ',
            '%' => ' Posto ',
            '∑' => ' zbroj ',
            '∆' => ' Delta ',
            '∞' => ' beskonačno ',
            '♥' => ' ljubav ',
            '&' => ' I ',
            '+' => ' Plus ',
            //
            'Č' => 'C',
            'Ć' => 'C',
            'Ž' => 'Z',
            'Š' => 'S',
            'Đ' => 'Dj',
            'č' => 'c',
            'ć' => 'c',
            'ž' => 'z',
            'š' => 's',
            'đ' => 'dj',
        ),
    // Finnish
    'fi'            => array(
        '=' => ' Sama ',
        '%' => ' Prosenttia ',
        '∑' => ' sum ',
        '∆' => ' delta ',
        '∞' => ' ääretön ',
        '♥' => ' rakkautta ',
        '&' => ' Ja ',
        '+' => ' Plus ',
        //
        'Ä' => 'A',
        'Ö' => 'O',
        'ä' => 'a',
        'ö' => 'o',
    ),
    // Georgian
    'ka'            => array(
        '=' => ' თანასწორი ',
        '%' => ' პროცენტი ',
        '∑' => ' თანხა ',
        '∆' => ' დელტა ',
        '∞' => ' უსასრულო ',
        '♥' => ' სიყვარული ',
        '&' => ' და ',
        '+' => ' პლუს ',
        //
        'ა' => 'a',
        'ბ' => 'b',
        'გ' => 'g',
        'დ' => 'd',
        'ე' => 'e',
        'ვ' => 'v',
        'ზ' => 'z',
        'თ' => 't',
        'ი' => 'i',
        'კ' => 'k',
        'ლ' => 'l',
        'მ' => 'm',
        'ნ' => 'n',
        'ო' => 'o',
        'პ' => 'p',
        'ჟ' => 'zh',
        'რ' => 'r',
        'ს' => 's',
        'ტ' => 't',
        'უ' => 'u',
        'ფ' => 'f',
        'ქ' => 'k',
        'ღ' => 'gh',
        'ყ' => 'q',
        'შ' => 'sh',
        'ჩ' => 'ch',
        'ც' => 'ts',
        'ძ' => 'dz',
        'წ' => 'ts',
        'ჭ' => 'ch',
        'ხ' => 'kh',
        'ჯ' => 'j',
        'ჰ' => 'h',
    ),
    // Russian
    'ru'            => array(
        '=' => ' равный ',
        '%' => ' процент ',
        '∑' => ' сумма ',
        '∆' => ' дельта ',
        '∞' => ' бесконечность ',
        '♥' => ' люблю ',
        '&' => ' а также ',
        '+' => ' плюс ',
        //
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sh',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ё' => 'Yo',
        'Ж' => 'Zh',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'J',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'Ch',
        'Ш' => 'Sh',
        'Щ' => 'Sh',
        'Ъ' => '',
        'Ы' => 'Y',
        'Ь' => '',
        'Э' => 'E',
        'Ю' => 'Yu',
        'Я' => 'Ya',
        '№' => '',
    ),
    // Ukrainian
    'uk'            => array(
        '=' => ' рівний ',
        '%' => ' відсотків ',
        '∑' => ' сума ',
        '∆' => ' дельта ',
        '∞' => ' нескінченність ',
        '♥' => ' любов ',
        '&' => ' і ',
        '+' => ' плюс ',
        //
        'Є' => 'Ye',
        'І' => 'I',
        'Ї' => 'Yi',
        'Ґ' => 'G',
        'є' => 'ye',
        'і' => 'i',
        'ї' => 'yi',
        'ґ' => 'g',
    ),
    // Czech
    'cs'            => array(
        '=' => ' rovnat se ',
        '%' => ' procento ',
        '∑' => ' součet ',
        '∆' => ' delta ',
        '∞' => ' nekonečno ',
        '♥' => ' láska ',
        '&' => ' a ',
        '+' => ' plus ',
        //
        'č' => 'c',
        'ď' => 'd',
        'ě' => 'e',
        'ň' => 'n',
        'ř' => 'r',
        'š' => 's',
        'ť' => 't',
        'ů' => 'u',
        'ž' => 'z',
        'Č' => 'C',
        'Ď' => 'D',
        'Ě' => 'E',
        'Ň' => 'N',
        'Ř' => 'R',
        'Š' => 'S',
        'Ť' => 'T',
        'Ů' => 'U',
        'Ž' => 'Z',
    ),
    // Danish
    'da'            => array(
        '=' => ' Lige ',
        '%' => ' Prozent ',
        '∑' => ' sum ',
        '∆' => ' delta ',
        '∞' => ' uendelig ',
        '♥' => ' kærlighed ',
        '&' => ' Og ',
        '+' => ' Plus ',
        //
        'Æ' => 'Ae',
        'æ' => 'ae',
        'Ø' => 'Oe',
        'ø' => 'oe',
        'Å' => 'Aa',
        'å' => 'aa',
        'É' => 'E',
        'é' => 'e',
    ),
    // Polish
    'pl'            => array(
        '=' => ' równy ',
        '%' => ' procent ',
        '∑' => ' suma ',
        '∆' => ' delta ',
        '∞' => ' nieskończoność ',
        '♥' => ' miłość ',
        '&' => ' i ',
        '+' => ' plus ',
        //
        'ą' => 'a',
        'ć' => 'c',
        'ę' => 'e',
        'ł' => 'l',
        'ń' => 'n',
        'ó' => 'o',
        'ś' => 's',
        'ź' => 'z',
        'ż' => 'z',
        'Ą' => 'A',
        'Ć' => 'C',
        'Ę' => 'e',
        'Ł' => 'L',
        'Ń' => 'N',
        'Ó' => 'O',
        'Ś' => 'S',
        'Ź' => 'Z',
        'Ż' => 'Z',
    ),
    // Romanian
    'ro'            => array(
        '=' => ' egal ',
        '%' => ' la sută ',
        '∑' => ' sumă ',
        '∆' => ' deltă ',
        '∞' => ' infinit ',
        '♥' => ' dragoste ',
        '&' => ' și ',
        '+' => ' la care se adauga ',
        //
        'ă' => 'a',
        'â' => 'a',
        'Ă' => 'A',
        'Â' => 'A',
        'î' => 'i',
        'Î' => 'I',
        'ș' => 's',
        'ş' => 's',
        'Ş' => 'S',
        'Ș' => 'S',
        'ț' => 't',
        'ţ' => 't',
        'Ţ' => 'T',
        'Ț' => 'T',
    ),
    // Esperanto
    'eo'            => array(
        '=' => ' Egalaj ',
        '%' => ' Procento ',
        '∑' => ' sumo ',
        '∆' => ' delto ',
        '∞' => ' senfina ',
        '♥' => ' amo ',
        '&' => ' Kaj ',
        '+' => ' Pli ',
        //
        'ĉ' => 'cx',
        'ĝ' => 'gx',
        'ĥ' => 'hx',
        'ĵ' => 'jx',
        'ŝ' => 'sx',
        'ŭ' => 'ux',
        'Ĉ' => 'CX',
        'Ĝ' => 'GX',
        'Ĥ' => 'HX',
        'Ĵ' => 'JX',
        'Ŝ' => 'SX',
        'Ŭ' => 'UX',
    ),
    // Estonian
    'et'            => array(
        '=' => ' Võrdsed ',
        '%' => ' Protsenti ',
        '∑' => ' summa ',
        '∆' => ' õ ',
        '∞' => ' lõputut ',
        '♥' => ' armastus ',
        '&' => ' Ja ',
        '+' => ' Pluss ',
        //
        'Š' => 'S',
        'Ž' => 'Z',
        'Õ' => 'O',
        'Ä' => 'A',
        'Ö' => 'O',
        'Ü' => 'U',
        'š' => 's',
        'ž' => 'z',
        'õ' => 'o',
        'ä' => 'a',
        'ö' => 'o',
        'ü' => 'u',
    ),
    // Latvian
    'lv'            => array(
        '=' => ' vienāds ',
        '%' => ' procents ',
        '∑' => ' summa ',
        '∆' => ' delta ',
        '∞' => ' bezgalība ',
        '♥' => ' mīlestība ',
        '&' => ' un ',
        '+' => ' pluss ',
        //
        'ā' => 'a',
        'č' => 'c',
        'ē' => 'e',
        'ģ' => 'g',
        'ī' => 'i',
        'ķ' => 'k',
        'ļ' => 'l',
        'ņ' => 'n',
        'š' => 's',
        'ū' => 'u',
        'ž' => 'z',
        'Ā' => 'A',
        'Č' => 'C',
        'Ē' => 'E',
        'Ģ' => 'G',
        'Ī' => 'i',
        'Ķ' => 'k',
        'Ļ' => 'L',
        'Ņ' => 'N',
        'Š' => 'S',
        'Ū' => 'u',
        'Ž' => 'Z',
    ),
    // Lithuanian
    'lt'            => array(
        '=' => ' lygus ',
        '%' => ' procentų ',
        '∑' => ' suma ',
        '∆' => ' delta ',
        '∞' => ' begalybė ',
        '♥' => ' meilė ',
        '&' => ' ir ',
        '+' => ' plius ',
        //
        'ą' => 'a',
        'č' => 'c',
        'ę' => 'e',
        'ė' => 'e',
        'į' => 'i',
        'š' => 's',
        'ų' => 'u',
        'ū' => 'u',
        'ž' => 'z',
        'Ą' => 'A',
        'Č' => 'C',
        'Ę' => 'E',
        'Ė' => 'E',
        'Į' => 'I',
        'Š' => 'S',
        'Ų' => 'U',
        'Ū' => 'U',
        'Ž' => 'Z',
    ),
    // Norwegian
    'no'            => array(
        '=' => ' Lik ',
        '%' => ' Prosent ',
        '∑' => ' sum ',
        '∆' => ' delta ',
        '∞' => ' uendelig ',
        '♥' => ' kjærlighet ',
        '&' => ' Og ',
        '+' => ' Pluss ',
        //
        'Æ' => 'AE',
        'Ø' => 'OE',
        'Å' => 'AA',
        'æ' => 'ae',
        'ø' => 'oe',
        'å' => 'aa',
    ),
    // Vietnamese
    'vn'            => array(
        '=' => ' công bằng ',
        '%' => ' phần trăm ',
        '∑' => ' tổng số ',
        '∆' => ' đồng bằng ',
        '∞' => ' vô cực ',
        '♥' => ' Yêu ',
        '&' => ' và ',
        '+' => ' thêm ',
        //
        'Á' => 'A',
        'À' => 'A',
        'Ả' => 'A',
        'Ã' => 'A',
        'Ạ' => 'A',
        'Ă' => 'A',
        'Ắ' => 'A',
        'Ằ' => 'A',
        'Ẳ' => 'A',
        'Ẵ' => 'A',
        'Ặ' => 'A',
        'Â' => 'A',
        'Ấ' => 'A',
        'Ầ' => 'A',
        'Ẩ' => 'A',
        'Ẫ' => 'A',
        'Ậ' => 'A',
        'á' => 'a',
        'à' => 'a',
        'ả' => 'a',
        'ã' => 'a',
        'ạ' => 'a',
        'ă' => 'a',
        'ắ' => 'a',
        'ằ' => 'a',
        'ẳ' => 'a',
        'ẵ' => 'a',
        'ặ' => 'a',
        'â' => 'a',
        'ấ' => 'a',
        'ầ' => 'a',
        'ẩ' => 'a',
        'ẫ' => 'a',
        'ậ' => 'a',
        'É' => 'E',
        'È' => 'E',
        'Ẻ' => 'E',
        'Ẽ' => 'E',
        'Ẹ' => 'E',
        'Ê' => 'E',
        'Ế' => 'E',
        'Ề' => 'E',
        'Ể' => 'E',
        'Ễ' => 'E',
        'Ệ' => 'E',
        'é' => 'e',
        'è' => 'e',
        'ẻ' => 'e',
        'ẽ' => 'e',
        'ẹ' => 'e',
        'ê' => 'e',
        'ế' => 'e',
        'ề' => 'e',
        'ể' => 'e',
        'ễ' => 'e',
        'ệ' => 'e',
        'Í' => 'I',
        'Ì' => 'I',
        'Ỉ' => 'I',
        'Ĩ' => 'I',
        'Ị' => 'I',
        'í' => 'i',
        'ì' => 'i',
        'ỉ' => 'i',
        'ĩ' => 'i',
        'ị' => 'i',
        'Ó' => 'O',
        'Ò' => 'O',
        'Ỏ' => 'O',
        'Õ' => 'O',
        'Ọ' => 'O',
        'Ô' => 'O',
        'Ố' => 'O',
        'Ồ' => 'O',
        'Ổ' => 'O',
        'Ỗ' => 'O',
        'Ộ' => 'O',
        'Ơ' => 'O',
        'Ớ' => 'O',
        'Ờ' => 'O',
        'Ở' => 'O',
        'Ỡ' => 'O',
        'Ợ' => 'O',
        'ó' => 'o',
        'ò' => 'o',
        'ỏ' => 'o',
        'õ' => 'o',
        'ọ' => 'o',
        'ô' => 'o',
        'ố' => 'o',
        'ồ' => 'o',
        'ổ' => 'o',
        'ỗ' => 'o',
        'ộ' => 'o',
        'ơ' => 'o',
        'ớ' => 'o',
        'ờ' => 'o',
        'ở' => 'o',
        'ỡ' => 'o',
        'ợ' => 'o',
        'Ú' => 'U',
        'Ù' => 'U',
        'Ủ' => 'U',
        'Ũ' => 'U',
        'Ụ' => 'U',
        'Ư' => 'U',
        'Ứ' => 'U',
        'Ừ' => 'U',
        'Ử' => 'U',
        'Ữ' => 'U',
        'Ự' => 'U',
        'ú' => 'u',
        'ù' => 'u',
        'ủ' => 'u',
        'ũ' => 'u',
        'ụ' => 'u',
        'ư' => 'u',
        'ứ' => 'u',
        'ừ' => 'u',
        'ử' => 'u',
        'ữ' => 'u',
        'ự' => 'u',
        'Ý' => 'Y',
        'Ỳ' => 'Y',
        'Ỷ' => 'Y',
        'Ỹ' => 'Y',
        'Ỵ' => 'Y',
        'ý' => 'y',
        'ỳ' => 'y',
        'ỷ' => 'y',
        'ỹ' => 'y',
        'ỵ' => 'y',
        'Đ' => 'D',
        'đ' => 'd',
    ),
    // Arabic
    'ar'            => array(
        '=' => ' متساوي ',
        '%' => ' نسبه مئويه ',
        '∑' => ' مجموع ',
        '∆' => ' دلتا ',
        '∞' => ' ما لا نهاية ',
        '♥' => ' حب ',
        '&' => ' و ',
        '+' => ' زائد ',
        //
        'أ' => 'a',
        'ب' => 'b',
        'ت' => 't',
        'ث' => 'th',
        'ج' => 'g',
        'ح' => 'h',
        'خ' => 'kh',
        'د' => 'd',
        'ذ' => 'th',
        'ر' => 'r',
        'ز' => 'z',
        'س' => 's',
        'ش' => 'sh',
        'ص' => 's',
        'ض' => 'd',
        'ط' => 't',
        'ظ' => 'th',
        'ع' => 'aa',
        'غ' => 'gh',
        'ف' => 'f',
        'ق' => 'k',
        'ك' => 'k',
        'ل' => 'l',
        'م' => 'm',
        'ن' => 'n',
        'ه' => 'h',
        'و' => 'o',
        'ي' => 'y',
        'ا' => 'a',
        'إ' => 'a',
        'آ' => 'a',
        'ؤ' => 'o',
        'ئ' => 'y',
        'ء' => 'aa',
        '٠' => '0',
        '١' => '1',
        '٢' => '2',
        '٣' => '3',
        '٤' => '4',
        '٥' => '5',
        '٦' => '6',
        '٧' => '7',
        '٨' => '8',
        '٩' => '9',
    ),
    // Persian
    'fa'            => array(
        '=' => ' برابر ',
        '%' => ' در صد ',
        '∑' => ' مجموع ',
        '∆' => ' دلتا ',
        '∞' => ' بی نهایت ',
        '♥' => ' عشق ',
        '&' => ' و ',
        '+' => ' به علاوه ',
        //
        'گ' => 'g',
        'ژ' => 'j',
        'پ' => 'p',
        'چ' => 'ch',
        'ی' => 'y',
        'ک' => 'k',
        '۰' => '0',
        '۱' => '1',
        '۲' => '2',
        '۳' => '3',
        '۴' => '4',
        '۵' => '5',
        '۶' => '6',
        '۷' => '7',
        '۸' => '8',
        '۹' => '9',
    ),
    // Serbian
    'sr'            => array(
        '=' => ' једнак ',
        '%' => ' проценат ',
        '∑' => ' збир ',
        '∆' => ' делта ',
        '∞' => ' бескрај ',
        '♥' => ' љубав ',
        '&' => ' и ',
        '+' => ' више ',
        //
        'ј' => 'j',
        'љ' => 'lj',
        'њ' => 'nj',
        'ћ' => 'c',
        'џ' => 'dz',
        'Ј' => 'j',
        'Љ' => 'Lj',
        'Њ' => 'Nj',
        'Ћ' => 'C',
        'Џ' => 'Dz',
        'Đ' => 'Dj',
        'Ð' => 'Dj',
        'ð' => 'dj',
        'ђ' => 'dj',
        'đ' => 'dj',
        'Ђ' => 'Dj',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ж' => 'z',
        'з' => 'z',
        'и' => 'i',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'c',
        'ш' => 's',
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ж' => 'Z',
        'З' => 'Z',
        'И' => 'I',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'C',
        'Ш' => 'S',
        'š' => 's',
        'ž' => 'z',
        'ć' => 'c',
        'č' => 'c',
        'Š' => 'S',
        'Ž' => 'Z',
        'Ć' => 'C',
        'Č' => 'C',
    ),
    // Azerbaijani
    'az'            => array(
        '=' => ' bərabər ',
        '%' => ' faiz ',
        '∑' => ' məbləğ ',
        '∆' => ' delta ',
        '∞' => ' sonsuzluq ',
        '♥' => ' sevgi ',
        '&' => ' və ',
        '+' => ' plus ',
        //
        'ç' => 'c',
        'ə' => 'e',
        'ğ' => 'g',
        'ı' => 'i',
        'ö' => 'o',
        'ş' => 's',
        'ü' => 'u',
        'Ç' => 'C',
        'Ə' => 'E',
        'Ğ' => 'G',
        'İ' => 'I',
        'Ö' => 'O',
        'Ş' => 'S',
        'Ü' => 'U',
    ),
    // French
    'fr'            => array(
        '=' => ' Égal ',
        '%' => ' Pourcentage ',
        '∑' => ' somme ',
        '∆' => ' delta ',
        '∞' => ' infini ',
        '♥' => ' amour ',
        '&' => ' Et ',
        '+' => ' Plus ',
        //
    ),
    // Austrian (French)
    'fr_at'         => array(
        '=' => ' Égal ',
        '%' => ' Pourcentage ',
        '∑' => ' somme ',
        '∆' => ' delta ',
        '∞' => ' infini ',
        '♥' => ' amour ',
        '&' => ' Et ',
        '+' => ' Plus ',
        //
        'ß' => 'sz',
        'ẞ' => 'SZ',
    ),
    // Switzerland (French)
    'fr_ch'         => array(
        '=' => ' Égal ',
        '%' => ' Pourcentage ',
        '∑' => ' somme ',
        '∆' => ' delta ',
        '∞' => ' infini ',
        '♥' => ' amour ',
        '&' => ' Et ',
        '+' => ' Plus ',
        //
        'ß' => 'ss',
        'ẞ' => 'SS',
    ),
    // German
    'de'            => array(
        '=' => ' gleich ',
        '%' => ' Prozent ',
        '∑' => ' gesamt ',
        '∆' => ' Unterschied ',
        '∞' => ' undendlich ',
        '♥' => ' liebe ',
        '&' => ' und ',
        '+' => ' plus ',
        //
        'Ä' => 'Ae',
        'Ö' => 'Oe',
        'Ü' => 'Ue',
        'ä' => 'ae',
        'ö' => 'oe',
        'ü' => 'ue',
        'ß' => 'ss',
        'ẞ' => 'SS',
    ),
    // Austrian (German)
    'de_at'         => array(
        '=' => ' gleich ',
        '%' => ' Prozent ',
        '∑' => ' gesamt ',
        '∆' => ' Unterschied ',
        '∞' => ' undendlich ',
        '♥' => ' liebe ',
        '&' => ' und ',
        '+' => ' plus ',
        //
        'Ä' => 'AE',
        'Ö' => 'OE',
        'Ü' => 'UE',
        'ß' => 'sz',
        'ẞ' => 'SZ',
        'ä' => 'ae',
        'ö' => 'oe',
        'ü' => 'ue',
    ),
    // Switzerland (German)
    'de_ch'         => array(
        '=' => ' gleich ',
        '%' => ' Prozent ',
        '∑' => ' gesamt ',
        '∆' => ' Unterschied ',
        '∞' => ' undendlich ',
        '♥' => ' liebe ',
        '&' => ' und ',
        '+' => ' plus ',
        //
        'Ä' => 'Ae',
        'Ö' => 'Oe',
        'Ü' => 'Ue',
        'ä' => 'ae',
        'ö' => 'oe',
        'ü' => 'ue',
        'ß' => 'ss',
        'ẞ' => 'SS',
    ),
    // English
    'en'            => array(
        '=' => ' equal ',
        '%' => ' percent ',
        '∑' => ' sum ',
        '∆' => ' delta ',
        '∞' => ' infinity ',
        '♥' => ' love ',
        '&' => ' and ',
        '+' => ' plus ',
        //
    ),
    'latin'         => array(
        '¹' => '1',
        '²' => '2',
        '³' => '3',
        '⁴' => '4',
        '⁵' => '5',
        '⁶' => '6',
        '⁷' => '7',
        '⁸' => '8',
        '⁹' => '9',
        '₀' => '0',
        '₁' => '1',
        '₂' => '2',
        '₃' => '3',
        '₄' => '4',
        '₅' => '5',
        '₆' => '6',
        '₇' => '7',
        '₈' => '8',
        '₉' => '9',
        'æ' => 'ae',
        'ǽ' => 'ae',
        'Ä' => 'A',
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Å' => 'A',
        'Ǻ' => 'A',
        'Ă' => 'A',
        'Ǎ' => 'A',
        'Æ' => 'AE',
        'Ǽ' => 'AE',
        'ä' => 'a',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'å' => 'a',
        'ǻ' => 'a',
        'ă' => 'a',
        'ǎ' => 'a',
        'ª' => 'a',
        'Ç' => 'C',
        'Ĉ' => 'C',
        'ç' => 'c',
        'Ċ' => 'C',
        'ĉ' => 'c',
        'ċ' => 'c',
        'Ð' => 'D',
        'Đ' => 'D',
        'ð' => 'd',
        'đ' => 'd',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ĕ' => 'E',
        'Ė' => 'E',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ĕ' => 'e',
        'ė' => 'e',
        'ƒ' => 'f',
        'Ĝ' => 'G',
        'Ġ' => 'G',
        'ĝ' => 'g',
        'ġ' => 'g',
        'Ĥ' => 'H',
        'Ħ' => 'H',
        'ĥ' => 'h',
        'ħ' => 'h',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ĩ' => 'I',
        'Ĭ' => 'I',
        'Ǐ' => 'I',
        'Į' => 'I',
        'Ĳ' => 'IJ',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ĩ' => 'i',
        'ĭ' => 'i',
        'ǐ' => 'i',
        'į' => 'i',
        'ĳ' => 'ij',
        'Ĵ' => 'J',
        'ĵ' => 'j',
        'Ĺ' => 'L',
        'Ľ' => 'L',
        'Ŀ' => 'L',
        'ĺ' => 'l',
        'ľ' => 'l',
        'ŀ' => 'l',
        'Ñ' => 'N',
        'ñ' => 'n',
        'ŉ' => 'n',
        'Ö' => 'O',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ō' => 'O',
        'Ŏ' => 'O',
        'Ǒ' => 'O',
        'Ő' => 'O',
        'Ơ' => 'O',
        'Ø' => 'O',
        'Ǿ' => 'O',
        'Œ' => 'OE',
        'ö' => 'o',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ō' => 'o',
        'ŏ' => 'o',
        'ǒ' => 'o',
        'ő' => 'o',
        'ơ' => 'o',
        'ø' => 'o',
        'ǿ' => 'o',
        'º' => 'o',
        'œ' => 'oe',
        'Ŕ' => 'R',
        'Ŗ' => 'R',
        'ŕ' => 'r',
        'ŗ' => 'r',
        'Ŝ' => 'S',
        'Ș' => 'S',
        'ŝ' => 's',
        'ș' => 's',
        'ſ' => 's',
        'Ţ' => 'T',
        'Ț' => 'T',
        'Ŧ' => 'T',
        'Þ' => 'TH',
        'ţ' => 't',
        'ț' => 't',
        'ŧ' => 't',
        'þ' => 'th',
        'Ü' => 'U',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ũ' => 'U',
        'Ŭ' => 'U',
        'Ű' => 'U',
        'Ų' => 'U',
        'Ư' => 'U',
        'Ǔ' => 'U',
        'Ǖ' => 'U',
        'Ǘ' => 'U',
        'Ǚ' => 'U',
        'Ǜ' => 'U',
        'ü' => 'u',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ũ' => 'u',
        'ŭ' => 'u',
        'ű' => 'u',
        'ų' => 'u',
        'ư' => 'u',
        'ǔ' => 'u',
        'ǖ' => 'u',
        'ǘ' => 'u',
        'ǚ' => 'u',
        'ǜ' => 'u',
        'Ŵ' => 'W',
        'ŵ' => 'w',
        'Ý' => 'Y',
        'Ÿ' => 'Y',
        'Ŷ' => 'Y',
        'ý' => 'y',
        'ÿ' => 'y',
        'ŷ' => 'y',
    ),
    // currency
    'currency'      => array(
        '€' => ' Euro ',
        '$' => ' Dollar ',
        '₢' => ' rruzeiro ',
        '₣' => ' french franc ',
        '£' => ' pound ',
        '₤' => ' lira ',
        '₥' => ' mill ',
        '₦' => ' naira ',
        '₧' => ' peseta ',
        '₨' => ' rupee ',
        '₩' => ' won ',
        '₪' => ' new shequel ',
        '₫' => ' dong ',
        '₭' => ' kip ',
        '₮' => ' tugrik ',
        '₯' => ' drachma ',
        '₰' => ' penny ',
        '₱' => ' peso ',
        '₲' => ' guarani ',
        '₳' => ' austral ',
        '₴' => ' hryvnia ',
        '₵' => ' cedi ',
        '¢' => ' cent ',
        '¥' => ' yen ',
        '元' => ' yuan ',
        '円' => ' yen ',
        '﷼' => ' rial ',
        '₠' => ' ecu ',
        '¤' => ' currency ',
        '฿' => ' baht ',
    ),
    'latin_symbols' => array(
        '©' => ' (c) ',
        '®' => ' (r) ',
        '@' => ' (at) ',
        '=' => '=',
        '%' => '%',
        '∑' => '∑',
        '∆' => '∆',
        '∞' => '∞',
        '♥' => '♥',
        '&' => '&',
        '+' => '+',
    ),
  );

  /**
   * List of words to remove from URLs.
   *
   * @var array
   */
  public static $remove_list = array();

  /**
   * The character map.
   *
   * @var array
   */
  private static $map = array();

  /**
   * An array of strings that will convert into the separator-char - used by "URLify::filter()".
   *
   * @var array
   */
  private static $arrayToSeparator = array();

  /**
   * The character list as a string.
   *
   * @var string
   */
  private static $chars = '';

  /**
   * The character list as a regular expression.
   *
   * @var string
   */
  private static $regex = '';

  /**
   * The current language.
   *
   * @var string
   */
  private static $language = '';

  /**
   * Add new strings the will be replaced with the separator.
   *
   * @param array $array
   * @param bool  $append
   */
  public static function add_array_to_separator(array $array, $append = true)
  {
    if ($append === true) {
      self::$arrayToSeparator = array_merge(self::$arrayToSeparator, $array);
    }

    self::$arrayToSeparator = $array;
  }

  /**
   * Reset the internal "self::$arrayToSeparator" to the default values.
   */
  public static function reset_array_to_separator()
  {
    self::$arrayToSeparator = array(
        '/&quot;|&amp;|&lt;|&gt;|&ndash;|&mdash;/i',  // ", &, <, >, –, —
        '/⁻|-|—|_|"|`|´|\'/',
        '/\<br.*\>/iU',
    );
  }

  /**
   * Add new characters to the list. `$map` should be a hash.
   *
   * @param array $map
   */
  public static function add_chars(array $map)
  {
    self::$maps[] = $map;
    self::$map = array();
    self::$chars = '';
  }

  /**
   * Append words to the remove list. Accepts either single words or an array of words.
   *
   * @param mixed   $words
   * @param string  $language
   * @param boolean $merge <p>Keep the previous (default) remove-words-array</p>
   */
  public static function remove_words($words, $language = 'de', $merge = true)
  {
    if (is_array($words) !== true) {
      $words = array($words);
    }

    if ($merge === true) {
      self::$remove_list[$language] = array_merge(self::get_remove_list($language), $words);
    } else {
      self::$remove_list[$language] = $words;
    }
  }

  /**
   * return the "self::$remove_list[$language]" array
   *
   * @param string $language
   *
   * @return array
   */
  private static function get_remove_list($language = 'de')
  {
    // check for language
    if (!$language) {
      return array();
    }

    // set remove-array
    if (!isset(self::$remove_list[$language])) {
      self::reset_remove_list();
    }

    // check for array
    if (
        !isset(self::$remove_list[$language])
        ||
        !is_array(self::$remove_list[$language])
        ||
        empty(self::$remove_list[$language])
    ) {
      return array();
    }

    foreach (self::$remove_list[$language] as &$removeWord) {
      $removeWord = preg_quote($removeWord, '/');
    }

    return self::$remove_list[$language];
  }

  /**
   * slug
   *
   * @param string  $string
   * @param string  $language
   * @param string  $separator
   * @param boolean $strToLower
   *
   * @return bool|string
   */
  public static function slug($string, $language = 'de', $separator = '-', $strToLower = false)
  {
    return self::filter($string, 200, $language, false, false, $strToLower, $separator, false, true);
  }

  /**
   * Convert a String to URL.
   *
   * e.g.: "Petty<br>theft" to "Petty-theft"
   *
   * @param string  $string                            <p>The text you want to convert.</p>
   * @param int     $maxLength                         <p>Max. length of the output string, set to "0" (zero) to disable it</p>
   * @param string  $language                          <p>The language you want to convert to.</p>
   * @param boolean $fileName                          <p>
   *                                                   Keep the "." from the extension e.g.: "imaäe.jpg" => "image.jpg"
   *                                                   </p>
   * @param boolean $removeWords                       <p>
   *                                                   Remove some "words" from the string.<br />
   *                                                   Info: Set extra words via <strong>remove_words()</strong>.
   *                                                   </p>
   * @param boolean $strToLower                        <p>Use <strong>strtolower()</strong> at the end.</p>
   * @param string  $separator                         <p>Define a new separator for the words.</p>
   * @param boolean $convertToAsciiOnlyViaLanguageMaps <p>
   *                                                   Set to <strong>true</strong> if you only want to convert the
   *                                                   language-maps.
   *                                                   (better performance, but less complete ASCII converting)
   *                                                   </p>
   * @param boolean $convertUtf8Specials               <p>
   *                                                   Convert (html) special chars with portable-utf8 (e.g. \0,
   *                                                   \xE9, %F6, ...).
   *                                                   </p>
   *
   * @return string|false false on error
   */
  public static function filter($string, $maxLength = 200, $language = 'de', $fileName = false, $removeWords = false, $strToLower = false, $separator = '-', $convertToAsciiOnlyViaLanguageMaps = false, $convertUtf8Specials = false)
  {
    if (!$language) {
      return '';
    }

    // separator-fallback
    if (null === $separator) {
      $separator = '';
    } elseif (!$separator) {
      $separator = '-';
    }

    // escaped separator
    $separatorEscaped = preg_quote($separator, '/');

    if (0 === count(self::$arrayToSeparator)) {
      self::reset_array_to_separator();
    }

    // 1) clean invalid chars
    if ($convertUtf8Specials) {
      $string = UTF8::clean($string, true, true, true, true);
    }

    // 2) replace with $separator
    $string = preg_replace(self::$arrayToSeparator, $separator, $string);
    // 3) remove all other html-tags
    $string = strip_tags($string);
    // 4) use special language replacer
    $string = self::downcode($string, $language, $convertToAsciiOnlyViaLanguageMaps, '', $convertUtf8Specials);
    // 5) replace with $separator, again
    $string = preg_replace(self::$arrayToSeparator, $separator, $string);

    $removeWordsSearch = '//';
    // remove all these words from the string before urlifying
    if ($removeWords === true) {
      $removeWordsSearch = '/\b(?:' . implode('|', self::get_remove_list($language)) . ')\b/i';
    }

    $removePatternAddOn = '';
    // keep the "." from e.g.: a file-extension?
    if ($fileName) {
      $removePatternAddOn = '.';
    }

    $string = preg_replace(
        array(
            '/[' . ($separatorEscaped ?: ' ') . ']+/',                            // 6) remove double $separator's
            '[^A-Za-z0-9]',                                                       // 5) keep only ASCII-chars
            '/[^' . $separatorEscaped . $removePatternAddOn . '\-a-zA-Z0-9\s]/u', // 4) remove un-needed chars
            '/[' . ($separatorEscaped ?: ' ') . '\s]+/',                          // 3) convert spaces to $separator
            '/^\s+|\s+$/',                                                        // 2) trim leading & trailing spaces
            $removeWordsSearch,                                                   // 1) remove some extras words
        ),
        array(
            $separator,
            '',
            '',
            $separator,
            '',
            '',
        ),
        $string
    );

    // convert to lowercase
    if ($strToLower === true) {
      $string = strtolower($string);
    }

    // "substr" only if "$length" is set
    if ($maxLength && $maxLength > 0) {
      $string = (string)substr($string, 0, $maxLength);
    }

    // trim "$separator" from beginning and end of the string
    return trim($string, $separator);
  }

  /**
   * reset the word-remove-array
   */
  public static function reset_remove_list()
  {
    self::$remove_list = array(
      // English
      'en'    => array(
          'a',
          'an',
          'as',
          'at',
          'before',
          'but',
          'by',
          'for',
          'from',
          'is',
          'in',
          'into',
          'like',
          'of',
          'off',
          'on',
          'onto',
          'per',
          'since',
          'than',
          'the',
          'this',
          'that',
          'to',
          'up',
          'via',
          'with',
      ),
      // German
      'de'    => array(
          'ein',
          'eine',
          'wie',
          'an',
          'vor',
          'aber',
          'von',
          'für',
          'ist',
          'in',
          'von',
          'auf',
          'pro',
          'da',
          'als',
          'der',
          'die',
          'das',
          'dass',
          'zu',
          'mit',
      ),
      // Austrian (German)
      'de_at' => array(
          'ein',
          'eine',
          'wie',
          'an',
          'vor',
          'aber',
          'von',
          'für',
          'ist',
          'in',
          'von',
          'auf',
          'pro',
          'da',
          'als',
          'der',
          'die',
          'das',
          'dass',
          'zu',
          'mit',
      ),
      // Switzerland (German)
      'de_ch' => array(
          'ein',
          'eine',
          'wie',
          'an',
          'vor',
          'aber',
          'von',
          'für',
          'ist',
          'in',
          'von',
          'auf',
          'pro',
          'da',
          'als',
          'der',
          'die',
          'das',
          'dass',
          'zu',
          'mit',
      ),
      // French
      'fr'    => array(
          'a',
          'of',
          'in',
          'on',
          'aa',
          'as',
          'le',
          'les',
          'la',
          'ce',
          'to',
      ),
      // Austrian (French)
      'fr_at' => array(
          'a',
          'of',
          'in',
          'on',
          'aa',
          'as',
          'le',
          'les',
          'la',
          'ce',
          'to',
      ),
      // Switzerland (French)
      'fr_ch' => array(
          'a',
          'of',
          'in',
          'on',
          'aa',
          'as',
          'le',
          'les',
          'la',
          'ce',
          'to',
      ),
      // Greek
      'el'    => array(),
      // Estonian
      'et'    => array(),
      // Esperanto
      'eo'    => array(),
      // Hindi
      'hi'    => array(),
      // Swedish
      'sv'    => array(),
      // Turkish
      'tr'    => array(),
      // Bulgarian
      'bg'    => array(),
      // Burmese
      'by'    => array(),
      // Croatian
      'hr'    => array(),
      // Danish
      'da'    => array(),
      // Finnish
      'fi'    => array(),
      // Georgian
      'ka'    => array(),
      // Russian
      'ru'    => array(),
      // Ukrainian
      'uk'    => array(),
      // Czech
      'cs'    => array(),
      // Polish
      'pl'    => array(),
      // Romanian
      'ro'    => array(),
      // Latvian
      'lv'    => array(),
      // Lithuanian
      'lt'    => array(),
      // Norwegian
      'no'    => array(),
      // Vietnamese
      'vn'    => array(),
      // Arabic
      'ar'    => array(),
      // Serbian
      'sr'    => array(),
      // Azerbaijani
      'az'    => array(),
    );
  }

  /**
   * Expands the given string replacing some special parts for words.
   * e.g. "lorem@ipsum.com" is replaced by "lorem at ipsum dot com".
   *
   * Most of these transformations have been inspired by the pelle/slugger
   * project, distributed under the Eclipse Public License.
   * Copyright 2012 Pelle Braendgaard
   *
   * @param string $string The string to expand
   * @param string $language
   *
   * @return string The result of expanding the string
   */
  protected static function expandString($string, $language = 'de')
  {
    $string = self::expandCurrencies($string, $language);
    $string = self::expandSymbols($string, $language);

    return $string;
  }
  /**
   * Expands the numeric currencies in euros, dollars, pounds
   * and yens that the given string may include.
   *
   * @param string $string
   * @param string $language
   *
   * @return mixed
   */
  private static function expandCurrencies($string, $language = 'de')
  {
    if ($language == 'de') {
      return preg_replace(
          array(
              '/(?:\s|^)(\d+)(?:\ )*€(?:\s|$)/',
              '/(?:\s|^)\$(?:\ )*(\d+)(?:\s|$)/',
              '/(?:\s|^)\£(?:\ )*(\d+)(?:\s|$)/',
              '/(?:\s|^)\¥(?:\ )*(\d+)(?:\s|$)/',
              '/(?:\s|^)(\d+)[\.|,](\d+)(?:\ )*€(?:\s|$)/',
              '/(?:\s|^)\$(?:\ )*(\d+)[\.|,](\d+)(?:\s|$)/',
              '/(?:\s|^)£(?:\ )*(\d+)[\.|,](\d+)(?:\s|$)/',
          ),
          array(
              ' \1 Euro ',
              ' \1 Dollar ',
              ' \1 Pound ',
              ' \1 Yen ',
              ' \1 Euro \2 Cent ',
              ' \1 Dollar \2 Cent ',
              ' \1 Pound \2 Pence ',
          ),
          $string
      );
    }

    return preg_replace(
        array(
            '/(?:\s|^)1(?:\ )*€(?:\s|$)/',
            '/(?:\s|^)(\d+)(?:\ )*€(?:\s|$)/',
            '/(?:\s|^)\$(?:\ )*1(?:\s|$)/',
            '/(?:\s|^)\$(?:\ )*(\d+)(?:\s|$)/',
            '/(?:\s|^)\£(?:\ )*1(?:\s|$)/',
            '/(?:\s|^)\£(?:\ )*(\d+)(?:\s|$)/',
            '/(?:\s|^)\¥(?:\ )*(\d+)(?:\s|$)/',
            '/(?:\s|^)1[\.|,](\d+)(?:\ )*€(?:\s|$)/',
            '/(?:\s|^)(\d+)[\.|,](\d+)(?:\ )*€(?:\s|$)/',
            '/(?:\s|^)1[\.|,](\d+)(?:\ )*$(?:\s|$)/',
            '/(?:\s|^)\$(?:\ )*(\d+)[\.|,](\d+)(?:\s|$)/',
            '/(?:\s|^)1[\.|,](\d+)(?:\ )*£(?:\s|$)/',
            '/(?:\s|^)£(?:\ )*(\d+)[\.|,](\d+)(?:\s|$)/',
        ),
        array(
            ' 1 Euro ',
            ' \1 Euros ',
            ' 1 Dollar ',
            ' \1 Dollars ',
            ' 1 Pound ',
            ' \1 Pounds ',
            ' \1 Yen ',
            ' 1 Euros \1 Cents ',
            ' \1 Euros \2 Cents ',
            ' 1 Dollars \1 Cents ',
            ' \1 Dollars \2 Cents ',
            ' 1 Pounds \1 Pence ',
            ' \1 Pounds \2 Pence ',
        ),
        $string
    );
  }
  /**
   * Expands the special symbols that the given string may include, such as '@', '.', '#' and '%'.
   *
   * @param string $string
   * @param string $language
   *
   * @return mixed
   */
  private static function expandSymbols($string, $language = 'de')
  {
    return preg_replace(
        array(
            '/\s*©\s*/',
            '/\s*®\s*/',
            '/\s*@\s*/',
            '/\s*&\s*/',
            '/\s*%\s*/',
            '/(\s*=\s*)/',
        ),
        array(
            self::$maps['latin_symbols']['©'],
            self::$maps['latin_symbols']['®'],
            self::$maps['latin_symbols']['@'],
            isset(self::$maps[$language]['&']) ? self::$maps[$language]['&'] : '&',
            isset(self::$maps[$language]['%']) ? self::$maps[$language]['%'] : '%',
            isset(self::$maps[$language]['=']) ? self::$maps[$language]['='] : '=',
        ),
        $string
    );
  }

  /**
   * Transliterates characters to their ASCII equivalents.
   * $language specifies a priority for a specific language.
   * The latter is useful if languages have different rules for the same character.
   *
   * @param string  $string                            <p>The input string.</p>
   * @param string  $language                          <p>Your primary language.</p>
   * @param boolean $convertToAsciiOnlyViaLanguageMaps <p>
   *                                                   Set to <strong>true</strong> if you only want to convert the
   *                                                   language-maps.
   *                                                   (better performance, but less complete ASCII converting)
   *                                                   </p>
   * @param boolean $convertUtf8Specials               <p>
   *                                                   Convert (html) special chars with portable-utf8 (e.g. \0,
   *                                                   \xE9, %F6, ...).
   *                                                   </p>
   * @param string  $unknown                           <p>Character use if character unknown. (default is ?).</p>
   *
   * @return string
   */
  public static function downcode($string, $language = 'de', $convertToAsciiOnlyViaLanguageMaps = false, $unknown = '', $convertUtf8Specials = true)
  {
    self::init_downcode($language);

    if ($convertUtf8Specials === true) {
      // INFO: "UTF8::to_utf8()" will be used by "UTF8::to_ascii()"
      $string = UTF8::urldecode($string);
    }

    $string = self::expandString($string, $language);

    $searchArray = array();
    $replaceArray = array();
    if (preg_match_all(self::$regex, $string, $matches)) {
      $matchesCounter = count($matches[0]);

      /** @noinspection ForeachInvariantsInspection */
      for ($i = 0; $i < $matchesCounter; $i++) {
        $char = $matches[0][$i];
        if (isset(self::$map[$char])) {
          $searchArray[] = $char;
          $replaceArray[] = self::$map[$char];
        }
      }
    }

    $string = str_replace($searchArray, $replaceArray, $string);

    if ($convertToAsciiOnlyViaLanguageMaps === true) {
      return (string)$string;
    }

    return UTF8::to_ascii($string, $unknown);
  }

  /**
   * Initializes the character map.
   *
   * @param string $language
   *
   * @return bool
   */
  private static function init_downcode($language = 'de')
  {
    if (!$language) {
      return false;
    }

    // check if we already created the regex for this lang
    if (
        $language === self::$language
        &&
        count(self::$map) > 0
    ) {
      return true;
    }

    // is a specific map associated with $language?
    if (
        isset(self::$maps[$language])
        &&
        is_array(self::$maps[$language])
    ) {
      // move this map to end. This means it will have priority over others
      $m = self::$maps[$language];
      unset(self::$maps[$language]);
      self::$maps[$language] = $m;
    }

    // reset static vars
    self::$language = $language;
    self::$map = array();
    self::$chars = '';

    foreach (self::$maps as $map) {
      foreach ($map as $orig => $conv) {
        self::$map[$orig] = $conv;
        self::$chars .= $orig;
      }
    }

    self::$regex = '/[' . self::$chars . ']/u';

    return true;
  }

  /**
   * Alias of `URLify::downcode()`.
   *
   * @param string $string
   *
   * @return string
   */
  public static function transliterate($string)
  {
    return self::downcode($string);
  }

}
