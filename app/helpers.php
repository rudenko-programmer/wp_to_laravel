<?php

function linkTo($button, $path, $type, $name){
    $csrf = csrf_field();

    if(is_object($path)){
        $action = '/'.$path->getTable();
        if(in_array($type, ['PUT', 'PATCH', 'DELETE'])){
            $action .= '/'.$path->getKey();
        }
    }
    else{
        $action = $path;
    }

    return <<<EOT
        <form method='POST' action='{$action}' id='id-{$name}' class='class-{$name}'>
            <input type='hidden' name='_method' value='{$type}'>
            $csrf
            <button type='submit'>{$button}</button>
        </form>    
EOT;
}

/**
 * @param string $needle Необходимое значение
 * @param string $current Текущее значение
 * @return string
 */
function selected($needle, $current){
    if((string)$needle === (string)$current) return 'selected';
    return '';
}
/**
 * @param string $needle Необходимое значение
 * @param string $current Текущее значение
 * @return string
 */
function checked($needle, $current){
    if((string)$needle === (string)$current) return 'checked';
    return '';
}