<?php

namespace voku\helper;

/**
 * A PHP port of URLify.js from the Django project + str_transliterate from "Portable UTF-8".
 *
 * - https://github.com/django/django/blob/master/django/contrib/admin/static/admin/js/urlify.js
 * - https://github.com/voku/portable-utf8
 *
 * Handles symbols from latin languages, Arabic, Azerbaijani, Czech, German, Greek, Latvian, Lithuanian, Persian,
 * Polish, Romanian, Bulgarian, Russian, Serbian, Turkish, Ukrainian and Vietnamese
 * and many other via "str_transliterate".
 *
 * Usage:
 *
 *     echo URLify::filter(' J\'étudie le français ');
 *     // "jetudie-le-francais"
 *
 *     echo URLify::filter('Lo siento, no hablo español.');
 *     // "lo-siento-no-hablo-espanol"
 */
class URLify
{

  public static $maps = array(
    'latin'         => array(
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Ă' => 'A',
        'Æ' => 'AE',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ð' => 'D',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ő' => 'O',
        'Ø' => 'O',
        'Œ' => 'OE',
        'Ș' => 'S',
        'Ț' => 'T',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ű' => 'U',
        'Ý' => 'Y',
        'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'ă' => 'a',
        'æ' => 'ae',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'd',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ő' => 'o',
        'ø' => 'o',
        'œ' => 'oe',
        'ș' => 's',
        'ț' => 't',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'ű' => 'u',
        'ý' => 'y',
        'þ' => 'th',
        'ÿ' => 'y',
    ),
    'latin_symbols' => array(
        '©' => ' (c) ',
        '®' => ' (r) ',
        '@' => ' (at) ',
    ),
    // Greek
    'el'            => array(
        '=' => ' ίσος ',
        '%' => ' τοις εκατό ',
        '∑' => ' άθροισμα ',
        '∆' => ' δέλτα ',
        '∞' => ' άπειρο ',
        '♥' => ' αγάπη ',
        '&' => ' και ',
        '+' => ' συν ',
        'α' => 'a',
        'β' => 'b',
        'γ' => 'g',
        'δ' => 'd',
        'ε' => 'e',
        'ζ' => 'z',
        'η' => 'h',
        'θ' => '8',
        'ι' => 'i',
        'κ' => 'k',
        'λ' => 'l',
        'μ' => 'm',
        'ν' => 'n',
        'ξ' => '3',
        'ο' => 'o',
        'π' => 'p',
        'ρ' => 'r',
        'σ' => 's',
        'τ' => 't',
        'υ' => 'y',
        'φ' => 'f',
        'χ' => 'x',
        'ψ' => 'ps',
        'ω' => 'w',
        'ά' => 'a',
        'έ' => 'e',
        'ί' => 'i',
        'ό' => 'o',
        'ύ' => 'y',
        'ή' => 'h',
        'ώ' => 'w',
        'ς' => 's',
        'ϊ' => 'i',
        'ΰ' => 'y',
        'ϋ' => 'y',
        'ΐ' => 'i',
        'Α' => 'A',
        'Β' => 'B',
        'Γ' => 'G',
        'Δ' => 'D',
        'Ε' => 'E',
        'Ζ' => 'Z',
        'Η' => 'H',
        'Θ' => '8',
        'Ι' => 'I',
        'Κ' => 'K',
        'Λ' => 'L',
        'Μ' => 'M',
        'Ν' => 'N',
        'Ξ' => '3',
        'Ο' => 'O',
        'Π' => 'P',
        'Ρ' => 'R',
        'Σ' => 'S',
        'Τ' => 'T',
        'Υ' => 'Y',
        'Φ' => 'F',
        'Χ' => 'X',
        'Ψ' => 'PS',
        'Ω' => 'W',
        'Ά' => 'A',
        'Έ' => 'E',
        'Ί' => 'I',
        'Ό' => 'O',
        'Ύ' => 'Y',
        'Ή' => 'H',
        'Ώ' => 'W',
        'Ϊ' => 'I',
        'Ϋ' => 'Y',
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
        '=' => ' равен ',
        '%' => ' на сто ',
        '∑' => ' сума ',
        '∆' => ' делта ',
        '∞' => ' безкрайност ',
        '♥' => ' обичам ',
        '&' => ' и ',
        '+' => ' плюс ',
        'Щ' => 'Sht',
        'Ш' => 'Sh',
        'Ч' => 'Ch',
        'Ц' => 'C',
        'Ю' => 'Yu',
        'Я' => 'Ya',
        'Ж' => 'J',
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'Y',
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
        'Ь' => '',
        'Ъ' => 'A',
        'щ' => 'sht',
        'ш' => 'sh',
        'ч' => 'ch',
        'ц' => 'c',
        'ю' => 'yu',
        'я' => 'ya',
        'ж' => 'j',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
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
        'ь' => '',
        'ъ' => 'a',
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
    // Polish
    'pl'            => array (
        '=' => ' równy ',
        '%' => ' procent ',
        '∑' => ' suma ',
        '∆' => ' delta ',
        '∞' => ' nieskończoność ',
        '♥' => ' miłość ',
        '&' => ' i ',
        '+' => ' plus ',
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
        'ă' => 'a',
        'â' => 'a',
        'î' => 'i',
        'ș' => 's',
        'ț' => 't',
        'Ţ' => 'T',
        'ţ' => 't',
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
        '=' => ' متساوي ',
        '%' => ' نسبه مئويه ',
        '∑' => ' مجموع ',
        '∆' => ' دلتا ',
        '∞' => ' ما لا نهاية ',
        '♥' => ' حب ',
        '&' => ' و ',
        '+' => ' زائد ',
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
        'ђ' => 'dj',
        'ј' => 'j',
        'љ' => 'lj',
        'њ' => 'nj',
        'ћ' => 'c',
        'џ' => 'dz',
        'đ' => 'dj',
        'Ђ' => 'Dj',
        'Ј' => 'j',
        'Љ' => 'Lj',
        'Њ' => 'Nj',
        'Ћ' => 'C',
        'Џ' => 'Dz',
        'Đ' => 'Dj',
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
    // other
    'other'         => array(
        'ǽ' => 'ae',
        'ª' => 'a',
        'ǎ' => 'a',
        'ǻ' => 'a',
        'Ǽ' => 'AE',
        'Ǎ' => 'A',
        'Ǻ' => 'A',
        'ĉ' => 'c',
        'ċ' => 'c',
        '¢' => 'c',
        'Ĉ' => 'C',
        'Ċ' => 'C',
        'ĕ' => 'e',
        'Ĕ' => 'E',
        'ſ' => 'f',
        'ƒ' => 'f',
        'ĝ' => 'g',
        'ġ' => 'g',
        'Ĝ' => 'G',
        'Ġ' => 'G',
        'ĥ' => 'h',
        'ħ' => 'h',
        'Ĥ' => 'H',
        'Ħ' => 'H',
        'ĭ' => 'i',
        'ĳ' => 'ij',
        'ǐ' => 'i',
        'Ĭ' => 'I',
        'Ĳ' => 'IJ',
        'Ǐ' => 'I',
        'ĵ' => 'j',
        'Ĵ' => 'J',
        'ĺ' => 'l',
        'ľ' => 'l',
        'ŀ' => 'l',
        'Ĺ' => 'L',
        'Ľ' => 'L',
        'Ŀ' => 'L',
        'ŉ' => 'n',
        'ō' => 'o',
        'ŏ' => 'o',
        'œ' => 'oe',
        'ǒ' => 'o',
        'ǿ' => 'o',
        'Ō' => 'O',
        'Ŏ' => 'O',
        'Œ' => 'OE',
        'Ǒ' => 'O',
        'Ǿ' => 'O',
        'ŕ' => 'r',
        'ŗ' => 'r',
        'Ŕ' => 'R',
        'Ŗ' => 'R',
        'ŝ' => 's',
        'Ŝ' => 'S',
        'ţ' => 't',
        'ŧ' => 't',
        'Ţ' => 'T',
        'Ŧ' => 'T',
        'ŭ' => 'u',
        'ǔ' => 'u',
        'ǖ' => 'u',
        'ǘ' => 'u',
        'ǚ' => 'u',
        'ǜ' => 'u',
        'Ŭ' => 'U',
        'Ǔ' => 'U',
        'Ǖ' => 'U',
        'Ǘ' => 'U',
        'Ǚ' => 'U',
        'Ǜ' => 'U',
        'ŵ' => 'w',
        'Ŵ' => 'W',
        'ŷ' => 'y',
        'Ŷ' => 'Y',
        'Ÿ' => 'Y',
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
   * @param int     $maxLength                         <p>Max. length of the output string, set to -1 to disable it</p>
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
      $string = UTF8::clean($string);
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
      'en' => array(
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
      'de' => array(
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
      // Greek
      'el' => array(),
      // Turkish
      'tr' => array(),
      // Bulgarian
      'bg' => array(),
      // Russian
      'ru' => array(),
      // Ukrainian
      'uk' => array(),
      // Czech
      'cs' => array(),
      // Polish
      'pl' => array(),
      // Romanian
      'ro' => array(),
      // Latvian
      'lv' => array(),
      // Lithuanian
      'lt' => array(),
      // Vietnamese
      'vn' => array(),
      // Arabic
      'ar' => array(),
      // Serbian
      'sr' => array(),
      // Azerbaijani
      'az' => array(),
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
    $string = self::expandCurrencies($string);
    $string = self::expandSymbols($string, $language);

    return $string;
  }
  /**
   * Expands the numeric currencies in euros, dollars, pounds
   * and yens that the given string may include.
   *
   * @param string $string
   *
   * @return mixed
   */
  private static function expandCurrencies($string)
  {
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
