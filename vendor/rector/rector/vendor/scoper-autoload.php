<?php

// scoper-autoload.php @generated by PhpScoper

$loader = (static function () {
    // Backup the autoloaded Composer files
    $existingComposerAutoloadFiles = $GLOBALS['__composer_autoload_files'] ?? [];

    $loader = require_once __DIR__.'/autoload.php';
    // Ensure InstalledVersions is available
    $installedVersionsPath = __DIR__.'/composer/InstalledVersions.php';
    if (file_exists($installedVersionsPath)) require_once $installedVersionsPath;

    // Restore the backup and ensure the excluded files are properly marked as loaded
    $GLOBALS['__composer_autoload_files'] = \array_merge(
        $existingComposerAutoloadFiles,
        \array_fill_keys(['0e6d7bf4a5811bfa5cf40c5ccd6fae6a', '5928a00fa978807cf85d90ec3f4b0147'], true)
    );

    return $loader;
})();

// Class aliases. For more information see:
// https://github.com/humbug/php-scoper/blob/master/docs/further-reading.md#class-aliases
if (!function_exists('humbug_phpscoper_expose_class')) {
    function humbug_phpscoper_expose_class($exposed, $prefixed) {
        if (!class_exists($exposed, false) && !interface_exists($exposed, false) && !trait_exists($exposed, false)) {
            spl_autoload_call($prefixed);
        }
    }
}
humbug_phpscoper_expose_class('AutoloadIncluder', 'RectorPrefix202405\AutoloadIncluder');
humbug_phpscoper_expose_class('ComposerAutoloaderInit70e3025dac7e7555f69a9b4ca9e3dfde', 'RectorPrefix202405\ComposerAutoloaderInit70e3025dac7e7555f69a9b4ca9e3dfde');
humbug_phpscoper_expose_class('Product', 'RectorPrefix202405\Product');

// Function aliases. For more information see:
// https://github.com/humbug/php-scoper/blob/master/docs/further-reading.md#function-aliases
if (!function_exists('dump_node')) { function dump_node() { return \RectorPrefix202405\dump_node(...func_get_args()); } }
if (!function_exists('formatErrorMessage')) { function formatErrorMessage() { return \RectorPrefix202405\formatErrorMessage(...func_get_args()); } }
if (!function_exists('includeIfExists')) { function includeIfExists() { return \RectorPrefix202405\includeIfExists(...func_get_args()); } }
if (!function_exists('mb_check_encoding')) { function mb_check_encoding() { return \RectorPrefix202405\mb_check_encoding(...func_get_args()); } }
if (!function_exists('mb_chr')) { function mb_chr() { return \RectorPrefix202405\mb_chr(...func_get_args()); } }
if (!function_exists('mb_convert_case')) { function mb_convert_case() { return \RectorPrefix202405\mb_convert_case(...func_get_args()); } }
if (!function_exists('mb_convert_encoding')) { function mb_convert_encoding() { return \RectorPrefix202405\mb_convert_encoding(...func_get_args()); } }
if (!function_exists('mb_convert_variables')) { function mb_convert_variables() { return \RectorPrefix202405\mb_convert_variables(...func_get_args()); } }
if (!function_exists('mb_decode_mimeheader')) { function mb_decode_mimeheader() { return \RectorPrefix202405\mb_decode_mimeheader(...func_get_args()); } }
if (!function_exists('mb_decode_numericentity')) { function mb_decode_numericentity() { return \RectorPrefix202405\mb_decode_numericentity(...func_get_args()); } }
if (!function_exists('mb_detect_encoding')) { function mb_detect_encoding() { return \RectorPrefix202405\mb_detect_encoding(...func_get_args()); } }
if (!function_exists('mb_detect_order')) { function mb_detect_order() { return \RectorPrefix202405\mb_detect_order(...func_get_args()); } }
if (!function_exists('mb_encode_mimeheader')) { function mb_encode_mimeheader() { return \RectorPrefix202405\mb_encode_mimeheader(...func_get_args()); } }
if (!function_exists('mb_encode_numericentity')) { function mb_encode_numericentity() { return \RectorPrefix202405\mb_encode_numericentity(...func_get_args()); } }
if (!function_exists('mb_encoding_aliases')) { function mb_encoding_aliases() { return \RectorPrefix202405\mb_encoding_aliases(...func_get_args()); } }
if (!function_exists('mb_get_info')) { function mb_get_info() { return \RectorPrefix202405\mb_get_info(...func_get_args()); } }
if (!function_exists('mb_http_input')) { function mb_http_input() { return \RectorPrefix202405\mb_http_input(...func_get_args()); } }
if (!function_exists('mb_http_output')) { function mb_http_output() { return \RectorPrefix202405\mb_http_output(...func_get_args()); } }
if (!function_exists('mb_internal_encoding')) { function mb_internal_encoding() { return \RectorPrefix202405\mb_internal_encoding(...func_get_args()); } }
if (!function_exists('mb_language')) { function mb_language() { return \RectorPrefix202405\mb_language(...func_get_args()); } }
if (!function_exists('mb_list_encodings')) { function mb_list_encodings() { return \RectorPrefix202405\mb_list_encodings(...func_get_args()); } }
if (!function_exists('mb_ord')) { function mb_ord() { return \RectorPrefix202405\mb_ord(...func_get_args()); } }
if (!function_exists('mb_output_handler')) { function mb_output_handler() { return \RectorPrefix202405\mb_output_handler(...func_get_args()); } }
if (!function_exists('mb_parse_str')) { function mb_parse_str() { return \RectorPrefix202405\mb_parse_str(...func_get_args()); } }
if (!function_exists('mb_scrub')) { function mb_scrub() { return \RectorPrefix202405\mb_scrub(...func_get_args()); } }
if (!function_exists('mb_str_pad')) { function mb_str_pad() { return \RectorPrefix202405\mb_str_pad(...func_get_args()); } }
if (!function_exists('mb_str_split')) { function mb_str_split() { return \RectorPrefix202405\mb_str_split(...func_get_args()); } }
if (!function_exists('mb_stripos')) { function mb_stripos() { return \RectorPrefix202405\mb_stripos(...func_get_args()); } }
if (!function_exists('mb_stristr')) { function mb_stristr() { return \RectorPrefix202405\mb_stristr(...func_get_args()); } }
if (!function_exists('mb_strlen')) { function mb_strlen() { return \RectorPrefix202405\mb_strlen(...func_get_args()); } }
if (!function_exists('mb_strpos')) { function mb_strpos() { return \RectorPrefix202405\mb_strpos(...func_get_args()); } }
if (!function_exists('mb_strrchr')) { function mb_strrchr() { return \RectorPrefix202405\mb_strrchr(...func_get_args()); } }
if (!function_exists('mb_strrichr')) { function mb_strrichr() { return \RectorPrefix202405\mb_strrichr(...func_get_args()); } }
if (!function_exists('mb_strripos')) { function mb_strripos() { return \RectorPrefix202405\mb_strripos(...func_get_args()); } }
if (!function_exists('mb_strrpos')) { function mb_strrpos() { return \RectorPrefix202405\mb_strrpos(...func_get_args()); } }
if (!function_exists('mb_strstr')) { function mb_strstr() { return \RectorPrefix202405\mb_strstr(...func_get_args()); } }
if (!function_exists('mb_strtolower')) { function mb_strtolower() { return \RectorPrefix202405\mb_strtolower(...func_get_args()); } }
if (!function_exists('mb_strtoupper')) { function mb_strtoupper() { return \RectorPrefix202405\mb_strtoupper(...func_get_args()); } }
if (!function_exists('mb_strwidth')) { function mb_strwidth() { return \RectorPrefix202405\mb_strwidth(...func_get_args()); } }
if (!function_exists('mb_substitute_character')) { function mb_substitute_character() { return \RectorPrefix202405\mb_substitute_character(...func_get_args()); } }
if (!function_exists('mb_substr')) { function mb_substr() { return \RectorPrefix202405\mb_substr(...func_get_args()); } }
if (!function_exists('mb_substr_count')) { function mb_substr_count() { return \RectorPrefix202405\mb_substr_count(...func_get_args()); } }
if (!function_exists('parseArgs')) { function parseArgs() { return \RectorPrefix202405\parseArgs(...func_get_args()); } }
if (!function_exists('print_node')) { function print_node() { return \RectorPrefix202405\print_node(...func_get_args()); } }
if (!function_exists('showHelp')) { function showHelp() { return \RectorPrefix202405\showHelp(...func_get_args()); } }
if (!function_exists('trigger_deprecation')) { function trigger_deprecation() { return \RectorPrefix202405\trigger_deprecation(...func_get_args()); } }
if (!function_exists('uv_poll_init_socket')) { function uv_poll_init_socket() { return \RectorPrefix202405\uv_poll_init_socket(...func_get_args()); } }

return $loader;