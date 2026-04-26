<?php
if (!defined('IN_CRONLITE')) {
    define('IN_CRONLITE', true);
}

if (!defined('CUSTOM_GOODS_ROOT')) {
    define('CUSTOM_GOODS_ROOT', dirname(__FILE__) . '/');
}

if (!function_exists('custom_goods_require_login')) {
    function custom_goods_require_login()
    {
        global $islogin;
        if ($islogin != 1) {
            exit('{"code":-10,"msg":"请先登录"}');
        }
    }
}

if (!function_exists('custom_goods_require_admin')) {
    function custom_goods_require_admin()
    {
        global $userrow;
        custom_goods_require_login();
        if ($userrow['uid'] != 1) {
            exit('{"code":-2,"msg":"无权限"}');
        }
    }
}
?>
