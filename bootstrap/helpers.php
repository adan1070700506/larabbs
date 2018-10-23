<?php
/**
 * 返回当前路由名称，用于页面CSS名称定制
 * @return [string] [当前路由名称]
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}