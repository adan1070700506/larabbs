<?php
/**
 * 返回当前路由名称，用于页面CSS名称定制
 * @return [string] [当前路由名称]
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 生成文章摘要
 */
function make_excerpt($value, $length = 200){
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}