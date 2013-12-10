<?php
define('NOS_ENTRY_POINT', 'front');

$_SERVER['NOS_ROOT'] = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');

require_once $_SERVER['NOS_ROOT'].DIRECTORY_SEPARATOR.'novius-os'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'bootstrap.php';

\Log::error('CALLED SAVE_DATA WITH '.print_r($_GET, true));
if (isset($_GET['v'])) {
    $values = explode('|', $_GET['v']);
    $averages = explode('|', $_GET['a']);
    $types = explode('|', $_GET['t']);
    $set = new \Novius\Sieste\Model_Set();
    $set->set_date = Date::forge()->format('mysql');
    $set->set_nb_sleeping = 0;
    $set->save();

    foreach ($values as $key => $value) {
        $type = $types[$key];
        if ($type == 'b') {
            $type = 'boom';
        } else if ($type == 'o') {
            $type = 'boom_from_others';
        } else { // $type == 'p'
            $type = 'periodic';
        }

        $data = new \Novius\Sieste\Model_Data();
        $data->data_set_id = $set->set_id;
        $data->data_capt_id = $key;
        $data->data_capt_value = $value / 100;
        $data->data_capt_average = $averages[$key] / 100;
        $data->data_type = $type;

        $data->save();
    }

    echo 'OK';
} else {
    echo 'NO_DATA_NOOB';
}