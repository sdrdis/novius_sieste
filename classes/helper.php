<?php
namespace Novius\Sieste;
class Helper {
    static function getDatas($limit = null, $from_date = null) {
        $find_params = array(
            'related' => 'datas',
            'order_by' => array(
                'set_id' => 'DESC'
            )
        );
        if ($limit != null) {
            $find_params['limit'] = $limit;
        }
        if ($from_date != null) {
            $find_params['where'] = array(array('set_date', '>', $from_date->format('mysql')));
        }
        $sets = \Novius\Sieste\Model_Set::find('all', $find_params);

        $res = array();
        foreach ($sets as $set) {
            $set_res = array(
                'date' => \Date::create_from_string($set->set_date, 'mysql')->get_timestamp(),
                'datas' => array(),
            );
            foreach ($set->datas as $data) {
                $set_res['datas'][$data->data_capt_id] = array(
                    'value'     => $data->data_capt_value,
                    'average'   => $data->data_capt_average,
                    'type'      => $data->data_type
                );
            }
            $res[] = $set_res;
        }

        return $res;
    }
}