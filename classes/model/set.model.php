<?php

namespace Novius\Sieste;

class Model_Set extends \Nos\Orm\Model
{

    protected static $_primary_key = array('set_id');
    protected static $_table_name = 'novius_sieste_sets';

    protected static $_properties = array(
        'set_id',
        'set_date',
        'set_nb_sleeping',
    );

    protected static $_behaviours = array();

    protected static $_belongs_to  = array();
    protected static $_has_many  = array(
        'datas' => array(
            'key_from' => 'set_id',
            'model_to' => '\Novius\Sieste\Model_Data',
            'key_to' => 'data_set_id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );
    protected static $_many_many = array();

    public function getRawData() {
        $rawData = array();
        foreach ($this->datas as $data) {
            $rawData[$data->capt_id] = $data->capt_value;
        }
        return $rawData;
    }
}
