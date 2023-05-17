<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

/**
 *  Helpers
 */
if (!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool   $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if (!function_exists('bcrypt')) {
    /**
     * Hash the given value against the bcrypt algorithm.
     *
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->driver('bcrypt')->make($value, $options);
    }
}

if (!function_exists('resolve')) {
    /**
     * Resolve a service from the container.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @return mixed
     */
    function resolve($name, array $parameters = [])
    {
        return app($name, $parameters);
    }
}

if (!function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string|null $key
     * @param  array       $replace
     * @param  string|null $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function trans($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return app('translator');
        }

        return app('translator')->get($key, $replace, $locale);
    }
}

if (!function_exists('trans_choice')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $key
     * @param  \Countable|int|array  $number
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string
     */
    function trans_choice($key, $number, array $replace = [], $locale = null)
    {
        return app('translator')->choice($key, $number, $replace, $locale);
    }
}

if (!function_exists('__')) {
    /**
     * Translate the given message.
     *
     * @param  string|null $key
     * @param  array       $replace
     * @param  string|null $locale
     * @return string|array|null
     */
    function __($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return $key;
        }

        return trans($key, $replace, $locale);
    }
}

function BetweenStr($InputString, $StartStr, $EndStr = 0, $StartLoc = 0)
{
    if (($StartLoc = strpos($InputString, $StartStr, $StartLoc)) === false) {
        return null;
    }
    $StartLoc += strlen($StartStr);
    if (!$EndStr) {
        $EndStr = $StartStr;
    }
    if (!$EndLoc = strpos($InputString, $EndStr, $StartLoc)) {
        return null;
    }
    return substr($InputString, $StartLoc, ($EndLoc - $StartLoc));
}


function image_url_create($img, $size = null, $folder = 'avatars', $full_url = true)
{
    if ($size !== null) {
        $size = "-$size.jpg";
    }
    if (empty($img)) {
        return asset("images/thumbs/$folder-default$size");
    } elseif (substr($img, 0, 4) == "http") {
        return $img;
    }

    $path = "/upload/" . $folder . "/" . $img . $size;

    if ($full_url) {
        return url($path);
    }

    return $path;
}


/**
 * Success Returns
 *
 * @param string $hash
 *
 * @return array
 */
function parse_user_hash($user_hash)
{
    $userhashin = urldecode(base64_decode($user_hash));
    $CUSER = BetweenStr($userhashin, "CUSER=", "&");
    $CUSER_ID = BetweenStr($userhashin, "CUSER_ID=", "&");
    $CUSER_NAME = BetweenStr($userhashin, "CUSER_NAME=", "&");
    $CUSER_ICON = BetweenStr($userhashin, "CUSER_ICON=", "&");
    $CUSER_LINK = BetweenStr($userhashin, "CUSER_LINK=", "&");

    return compact('CUSER', 'CUSER_ID', 'CUSER_NAME', 'CUSER_ICON', 'CUSER_LINK');
}

/**
 * Translate the given message.
 *
 * @return object
 */
function get_current_content_user()
{
    static $userData;

    if (!empty($userData)) {
        return $userData;
    }

    $data = new \stdClass();
    $data->CUSER = false;
    $data->user_type = null;
    $data->authenticated = false;

    if (Auth::check()) {
        $data->authenticated = true;
        $user = request()->user()->toArray();
        foreach ($user as $key => $val) {
            if ($key === 'icon') {
                $data->{$key} = image_url_create($val, 's', 'avatars');
            } else {
                $data->{$key} = $val;
            }
        }
    } elseif (request()->has('user_hash')) {
        $user = parse_user_hash(request()->get('user_hash'));
        $data->id = Arr::get($user, 'CUSER_ID');
        $data->username = Arr::get($user, 'CUSER_NAME');
        $data->icon = Arr::get($user, 'CUSER_ICON');
        if (empty($data->icon)) {
            $data->icon = asset("images/thumbs/avatars-default-s.jpg");
        }
        $data->link = Arr::get($user, 'CUSER_LINK');
        $data->CUSER = true;
        $data->authenticated = !empty($data->id) && !empty($data->username) && !empty($data->icon) && !empty($data->link);
    } else {
        $data->id = null;
        $data->username = __("Guest");
        $data->icon = image_url_create(null, 's', 'avatars');
        $data->link = '#';
    }

    $userData = $data;

    return $data;
}

/**
 * Translate the given message.
 *
 * @return array
 */
function get_available_themes()
{
    return ['Default', 'Blog', 'Boxed', 'Dark', 'Envato'];
}

/**
 * Get available languages
 *
 * @return array
 */
function get_available_languages()
{
    $languages = Cache::get('available_languages');
    if (!empty($languages)) {
        return $languages;
    }

    $_languages = [];
    $filesInFolder = File::files(resource_path('/lang/'));
    foreach ($filesInFolder as $path) {
        $file = File::name($path);
        $_languages = Arr::add($_languages, $file, $file);
    }

    Cache::forever('available_languages', $_languages);

    return $_languages;
}


/**
 * Get available languages
 *
 * @return array
 */
function get_current_user_language()
{
    $language = env('APP_LOCALE', 'en');
    $available_languages = get_available_languages();

    if ($userLanguage = request()->cookie('easy_locale')) {
        if (in_array($userLanguage, $available_languages, true)) {
            return $userLanguage;
        }
    }

    return $language;
}

/**
 * Get user is online
 *
 * @return array
 */
function get_user_is_online($last_seen)
{
    $language = \Carbon\Carbon::now()->subMinutes(30);

    return $language->lt($last_seen);
}


/**
 * All languages
 *
 * @return array
 */
function get_translatable_language($language = '')
{
    $languages =  array(
        "af" => __("Afrikaans"),
        "ga" => __("Irish"),
        "sq" => __("Albanian"),
        "it" => __("Italian"),
        "ar" => __("Arabic"),
        "ja" => __("Japanese"),
        "az" => __("Azerbaijani"),
        "kn" => __("Kannada"),
        "eu" => __("Basque"),
        "ko" => __("Korean"),
        "bn" => __("Bengali"),
        "la" => __("Latin"),
        "be" => __("Belarusian"),
        "lv" => __("Latvian"),
        "bg" => __("Bulgarian"),
        "lt" => __("Lithuanian"),
        "ca" => __("Catalan"),
        "mk" => __("Macedonian"),
        "zh-CN" => __("Chinese Simplified"),
        "ms" => __("Malay"),
        "zh-TW" => __("Chinese Traditional"),
        "mt" => __("Maltese"),
        "hr" => __("Croatian"),
        "no" => __("Norwegian"),
        "cs" => __("Czech"),
        "fa" => __("Persian"),
        "da" => __("Danish"),
        "pl" => __("Polish"),
        "nl" => __("Dutch"),
        "pt" => __("Portuguese"),
        "en" => __("English"),
        "ro" => __("Romanian"),
        "eo" => __("Esperanto"),
        "ru" => __("Russian"),
        "et" => __("Estonian"),
        "sr" => __("Serbian"),
        "tl" => __("Filipino"),
        "sk" => __("Slovak"),
        "fi" => __("Finnish"),
        "sl" => __("Slovenian"),
        "fr" => __("French"),
        "es" => __("Spanish"),
        "gl" => __("Galician"),
        "sw" => __("Swahili"),
        "ka" => __("Georgian"),
        "sv" => __("Swedish"),
        "de" => __("German"),
        "ta" => __("Tamil"),
        "el" => __("Greek"),
        "te" => __("Telugu"),
        "gu" => __("Gujarati"),
        "th" => __("Thai"),
        "ht" => __("Haitian Creole"),
        "tr" => __("Turkish"),
        "iw" => __("Hebrew"),
        "uk" => __("Ukrainian"),
        "hi" => __("Hindi"),
        "ur" => __("Urdu"),
        "hu" => __("Hungarian"),
        "vi" => __("Vietnamese"),
        "is" => __("Icelandic"),
        "cy" => __("Welsh"),
        "id" => __("Indonesian"),
        "yi" => __("Yiddish"),
    );

    if (!empty($language)) {
        return Arr::get($languages, $language, null);
    }

    return $languages;
}


/**
 * Translate the datatable.
 *
 * @return array
 */
function get_datatable_languages()
{
    return [
        "decimal" =>        "",
        "emptyTable" =>     __('No data available in table'),
        "info" =>           __("Showing _START_ to _END_ of _TOTAL_ entries"),
        "infoEmpty" =>      __("Showing 0 to 0 of 0 entries"),
        "infoFiltered" =>   __("(filtered from _MAX_ total entries)"),
        "infoPostFix" =>    "",
        "thousands" =>      ",",
        "lengthMenu" =>     __('Show _MENU_ entries'),
        "loadingRecords" => __('Show _MENU_ entries'),
        "processing" =>     __("Processing..."),
        "search" =>         __("Search=>"),
        "zeroRecords" =>    __("No matching records found"),
        "paginate" => [
            "first" =>      __("First"),
            "last" =>       __("Last"),
            "next" =>       __("Next"),
            "previous" =>   __("Previous")
        ],
        "aria" => [
            "sortAscending" =>  __(":activate to sort column ascending"),
            "sortDescending" => __(":activate to sort column descending")
        ]
    ];
}

function parse_comment_text($output)
{
    $output = preg_replace('/(http[s]?:\/\/[^\s]*)/i', '<a href="$1" target="_blank">$1</a>', $output);

    $output = trim($output);

    $smiles = array(
        ':)' => 'smile',
        ':(' => 'sadsmile',
        ':D' => 'bigsmile',
        ':d' => 'bigsmile',
        '8)' => 'cool',
        ':o' => 'wink',
        ':|' => 'speechless',
        ':*' => 'kiss',
        ':P' => 'tongueout',
        ':^)' => 'wondering',
        '<3' => 'inlove'
    );

    foreach ($smiles as $key => $name) {
        $img_url = url('images/smiles/' . $name . '.png');
        $img = '<img src="' . $img_url . '" title="' . $name . '" alt="' . $name . '" />';

        $output =   str_replace($key, $img, $output);
    }

    return nl2br($output);
}
