<?php

if (!function_exists('debug')) {
    function debug(... $items)
    {
        $debugbar = Phile\Core\Container::getInstance()->get('siezi.debugbar');
        foreach ($items as $item) {
            $debugbar['messages']->addMessage($item);
        }
    }
}
