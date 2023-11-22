<?php
function dd( ...$params)
{
    foreach ($params as $param) {
        echo "<pre>";
        var_dump($param);
        echo "</pre>";
    }
    return;
}

function ddd( ...$params)
{
    echo "<pre>";
    var_dump($params);
    echo "</pre>";
    die();
}

function debugMode($active)
{
    if($active){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
 
    }
    return;
}

function fromPage($name){
    if(file_exists("./templates/includes/page/". $name . ".page.php")){
        include "./templates/includes/page/". $name . ".page.php";
    } else {
        echo "Le fichier ".$name.".page.php n'a pas été trouvé.";
        return false;
    }
}
function fromInc($name){
    if(file_exists("./templates/includes/elements/". $name . ".inc.php")){
        include "./templates/includes/elements/". $name . ".inc.php";
    }else{
        echo "Le fichier ".$name.".inc.php n'a pas été trouvé.";
        return false;
    }
}
