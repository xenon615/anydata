<?php

spl_autoload_register(function ($class) {
    $filename = __DIR__ . '/inc/'. str_replace('\\', '/', $class) . '.php';
    if(file_exists($filename) ) {
        require_once $filename;
    }  

});


require_once __DIR__ . '/inc/Customers/index.php';

// ---

function admin_submenu_page($params) {
    $h = add_submenu_page($params['parent'], $params['menu_label'], $params['page_title'], $params['capability'],$params['slug'], __NAMESPACE__ . '\dummy');
    add_action('load-' . $h, function() use($params) {
        $h = str_replace('load-', '', current_filter());
        remove_action($h, __NAMESPACE__ .'\dummy');
        $params['callback']($h);
    });     
}

// ---

function debug($val, $label = '', $name = 'log', $decoration = true, $append = true ) {
    $file = __DIR__ . '/_debug/debug-' . $name . '.log';
    $date_str = date('Y-m-d H:i:s');
    $ds = is_scalar($val) ? $val : print_r($val, true);

    if (!$decoration) {
        $dc = $ds;
    } else {

        $dc = "\n" . str_repeat('-', 40) . ' ' . $label . ' ' . $date_str . "\n";
        $dc .= $ds;
        $dc .= "\n" . str_repeat('-', 40). "\n";
    }
    
    file_put_contents($file, $dc, ($append ? FILE_APPEND : false) );
}
