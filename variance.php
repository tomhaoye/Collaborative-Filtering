<?php
include_once('db_connect.php');

$u_sql = 'select count(0) from ml_users';
$u_r = mysql_query($u_sql);
$u_c = mysql_fetch_row($u_r)[0];

for ($i = 1; $i <= $u_c; $i++) {
    $rating_arr = [];
    $sql = 'select * from ml_data where user_id = ' . $i;
    $all_rating = 0;
    $res = mysql_query($sql);
    while ($row = mysql_fetch_row($res)) {
        if ($row[3]) {
            $all_rating += $row[3];
            $rating_arr[] = $row[3];
        }
    };
    $num_rows = mysql_num_rows($res);
    //平均评分
    $average_rating[] = ($all_rating / $num_rows);

    //方差计算
    $variance = 0;
    foreach ($rating_arr as $item) {
        $variance += pow(($item - $average_rating[$i-1]), 2) / $num_rows;
    }
}


