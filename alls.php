<?php
include_once('db_connect.php');

$user_id = 1;
$arr = [];

$all_user_id_sql = 'select id from ml_users';
$rs1 = mysqli_query($link, $all_user_id_sql);
while ($row = mysqli_fetch_row($rs1)) {
    $arr[$row[0]] = $row[0];
};
