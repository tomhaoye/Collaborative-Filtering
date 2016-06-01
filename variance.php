<?php
include_once('db_connect.php');

$user_id = 1;
$per_den = 15;
$arr = [];

$avg_sql = 'select AVG(rating),user_id from ml_data group by user_id ORDER BY AVG(rating)';
$var_sql = 'select VARIANCE(rating),user_id from ml_data group by user_id order by VARIANCE(rating)';
$rs1 = mysqli_query($link, $avg_sql);
$rs2 = mysqli_query($link, $var_sql);
while ($row = mysqli_fetch_row($rs1)) {
    $avg[$row[1]] = $row[0];
};
while ($row = mysqli_fetch_row($rs2)) {
    $var[$row[1]] = $row[0];
};

function getNB()
{
    $nb1 = $nb2 = [];
    global $arr, $avg, $var, $user_id, $per_den;
    foreach ($avg as $key => $item) {
        if (abs($item - $avg[$user_id]) < ($avg[$user_id] / $per_den)) {
            $nb1[$key] = $item;
        }
    }
    foreach ($var as $key => $item) {
        if (abs($item - $var[$user_id]) < ($var[$user_id] / $per_den)) {
            $nb2[$key] = $item;
        }
    }
    $arr = array_intersect_key($nb1, $nb2);
    if (count($arr) < 10 && $per_den) {
        --$per_den;
        getNB();
    } elseif (count($arr) > 20) {
        ++$per_den;
        getNB();
    }
}

getNB();
print_r($arr);

