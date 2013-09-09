<?php

$previous_set = \Novius\Sieste\Model_Set::find('first',
    array(
        'where' => array(
            array(
                'set_date',
                '<',
                $current_set->set_date
            )
        ),
        'order_by' => array('set_date' => 'DESC')
    )
);

$next_set = \Novius\Sieste\Model_Set::find('first',
    array(
        'where' => array(
            array(
                'set_date',
                '>',
                $current_set->set_date
            )
        ),
        'order_by' => array('set_date' => 'ASC')
    )
);

$raw_data = $current_set->getRawData();

echo $current_set->set_date;
echo '<table>';
$nb_rows = 4;
$nb_cols = 4;
$i = 0;
for ($row = 0; $row < $nb_rows; $row++) {
    echo '<tr>';
    for ($col = 0; $col < $nb_cols; $col++) {
        echo '<td>';
        echo $raw_data[$i];
        echo '</td>';
        $i++;
    }
    echo '</tr>';
}
echo '</table>';
if ($previous_set) {
    echo '<a href="visualize_data.php?id='.$previous_set->set_id.'">Previous</a><br/>';
}
if ($next_set) {
    echo '<a href="visualize_data.php?id='.$next_set->set_id.'">Next</a><br/>';
}