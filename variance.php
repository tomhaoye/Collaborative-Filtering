<?php
include_once('db_connect.php');

$avg_sql = 'select AVG(rating),user_id from ml_data group by user_id';
$var_sql = 'select VARIANCE(rating),user_id from ml_data group by user_id';
$rs1 = mysql_query($avg_sql);
$rs2 = mysql_query($var_sql);
while($row  = mysql_fetch_row($rs1)){
    $avg[] = $row[0];
};
while($row  = mysql_fetch_row($rs2)){
    $var[] = $row[0];
};

print_r($avg);
print_r($var);

