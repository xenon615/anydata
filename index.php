<?php

/*
Plugin Name: AnyData
*/

namespace AnyData;

spl_autoload_register(function ($class) {
    if (strpos($class, __NAMESPACE__) !== false) {
        $filename = __DIR__ . '/Classes/' . str_replace([__NAMESPACE__ .'\\', '\\'], ['', '/'], $class) . '.php';
        if(file_exists($filename) ) {
            require_once $filename;
        }  
    } 
});

register_activation_hook(__FILE__, function() {});
register_deactivation_hook(__FILE__, function() {});

function bootstrap($params) {
    $h = add_submenu_page($params['parent'], $params['menu_label'] ?? '', $params['page_title'], $params['capability'], $params['slug'], __NAMESPACE__ . '\dummy');
    add_action('load-' . $h, function() use($params) {
        $current_filter = current_filter();
        $h = str_replace('load-', '', $current_filter);
        remove_action($h, __NAMESPACE__ .'\dummy');
        $slug = preg_replace(['/^.+?page_/'], '', $current_filter);
        if ($params['what'] == 'grid') {
            new $params['class']($slug);
            add_action($h, function() {
                Grid::getInstance()->show();
            });
        } else {
            new Form($params);
            add_action($h, function() {
                Form::getInstance()->show();
            });
        }
    });
}

add_action( 'plugins_loaded', function() {
	add_filter('set-screen-option', function($status, $option, $value) {
        return $value;
    }, 10, 3); 
});