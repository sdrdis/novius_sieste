<?php
define('NOS_ENTRY_POINT', 'front');

$_SERVER['NOS_ROOT'] = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');

require_once $_SERVER['NOS_ROOT'].DIRECTORY_SEPARATOR.'novius-os'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'bootstrap.php';


$limit = 1;
if (isset($_GET['limit'])) {
    $limit = (int) $_GET['limit'];
}
$from_date = null;
if (isset($_GET['from_date'])) {
    $from_date = \Date::forge($_GET['from_date']);
    $limit = null;
}

$res = Novius\Sieste\Helper::getDatas($limit, $from_date);
$res = array_reverse($res);
\Response::json($res);