<?php
include_once('db_connect.php');

$users = file('dataDir/u.user');
$items = file('dataDir/u.item');
$data = file('dataDir/u.data');

$user_sql1 = 'insert ml_users(id,age,gender,occupation) values ';
foreach ($users as $item) {
    $item = explode('|', $item);
    $user_id = $item[0];
    $user_age = $item[1];
    $user_gender = $item[2];
    $user_occupation = $item[3];
    $u_sql[] = '(' . $user_id . ',' . $user_age . ',' . "'" . $user_gender . "'" . ',' . "'" . $user_occupation . "'" . ')';
}
$user_sql2 = implode(',', $u_sql);
$user_sql = $user_sql1 . $user_sql2;
mysql_query($user_sql);


$item_sql1 = 'insert ml_items(id,title) values ';
foreach ($items as $item) {
    $item = iconv('iso-8859-1', 'utf-8',  $item);
    $item = explode('|', $item);
    $item_id = $item[0];
    $item_title = $item[1];
    $i_sql = "(" . $item_id . "," . '"' . $item_title . '"' . ")";
    $item_sql = $item_sql1 . $i_sql;
    mysql_query($item_sql);
}

$data_sql1 = 'insert ml_data(user_id,item_id,rating) values ';
foreach ($data as $item) {
    $item = explode('	', $item);
    $data_user_id = $item[0];
    $data_item_id = $item[1];
    $data_rating = $item[2];
    $d_sql = '(' . $data_user_id . ',' . $data_item_id . ',' . $data_rating . ')';
    $data_sql = $data_sql1 . $d_sql;
    mysql_query($data_sql);
}

