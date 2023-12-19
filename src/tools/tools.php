<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ .'/../classes/task.php';

define('TEMPS_EXPIRACIO', 5000);

define('ADMIN', '0');
define('CLIENT', '1');

define('START', '0');
define('WIP', '1');
define('FINALIZED', '2');

define('FITXER_USUARIS', __DIR__  .'/../credentials/users');
define('DIRECTORI_TASQUES', __DIR__  .'/../tasks');

function readtextfiles($filename)
{
    if ($fp = fopen($filename, "r")) {

        $textfilesize = filesize($filename);
        $dades = explode(PHP_EOL, fread($fp, $textfilesize));
        array_pop($dades);
        fclose($fp);
    }
    return $dades;
}

function writetextfiles($filename, $datas, $mode)
{
    if ($fp = fopen($filename, $mode)) {
        if (is_array($datas)) {
            foreach($datas as $data){
                fwrite($fp, $data);
            }
        }else if(is_object($datas)){
            fwrite($fp, $datas->__toString() . PHP_EOL);
        }else{
            fwrite($fp, $datas);
        }
        fclose($fp);
    }
}