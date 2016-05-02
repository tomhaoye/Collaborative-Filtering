<?php
include_once('db_connect.php');

$sql = "select * from scores";
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)) {
    $array[] = $row;
}
$cos = array();
$cos[0] = 0;
$fm1 = 0;
for ($i = 0; $i < 6; $i++) {
    if ($array[5][$i] != null) {
        $fm1 += $array[5][$i] * $array[5][$i];
    }
}

$fm1 = sqrt($fm1);

for ($i = 0; $i < 5; $i++) {
    $fz = 0;
    $fm2 = 0;
    echo "Cos(" . $array[5][0] . "," . $array[$i][0] . ")=";

    for ($j = 2; $j < 8; $j++) {
        if ($array[5][$j] != null && $array[$i][$j] != null) {
            $fz += $array[5][$j] * $array[$i][$j];
        }
        if ($array[$i][$j] != null) {
            $fm2 += $array[$i][$j] * $array[$i][$j];
        }
    }
    $fm2 = sqrt($fm2);
    $cos[$i] = $fz / $fm1 / $fm2;
    echo $cos[$i];
}