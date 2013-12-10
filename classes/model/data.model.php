<?php

namespace Novius\Sieste;

class Model_Data extends \Nos\Orm\Model
{

    protected static $_primary_key = array('data_id');
    protected static $_table_name = 'novius_sieste_datas';

    protected static $_properties = array(
        'data_id',
        'data_set_id',
        'data_capt_id',
        'data_capt_value',
        'data_type',
    );

    protected static $_behaviours = array();

    protected static $_belongs_to  = array();
    protected static $_has_many  = array(


    );
    protected static $_many_many = array();
}
