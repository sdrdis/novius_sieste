<?php
define('NOS_ENTRY_POINT', 'front');

$_SERVER['NOS_ROOT'] = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');

require_once $_SERVER['NOS_ROOT'].DIRECTORY_SEPARATOR.'novius-os'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'bootstrap.php';


$set = new \Novius\Sieste\Model_Set();
$set->set_date = (new Date())->format('mysql');
$set->set_nb_sleeping = 0;
$set->save();

$values = array();

foreach ($_GET['v'] as $key => $value) {
    $data = new \Novius\Sieste\Model_Data();
    $data->data_set_id = $set->set_id;
    $data->data_capt_id = $key;
    $data->data_capt_value = $value;
    $data->save();
    $values[$key] = $value;
}
echo 'OK';