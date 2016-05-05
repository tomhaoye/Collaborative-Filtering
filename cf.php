<?php
include_once('db_connect.php');
require('ShellsSort.php');

$sql = "select * from scores";
$result = mysql_query($sql);
while ($row = mysql_fetch_row($result)) {
    $table[] = $row;
}

//查找Emma没有接触的商品
//用户id－1＝下标
$user_index = 2;
for ($i = 2; $i < 8; $i++) {
    if (empty($table[$user_index][$i])) {
        $never[] = $i;
    }else{
        $never = [5,6,7];
    }
}
print_r($never);


/**
 * 根据余弦公式, 夹角余弦 = 向量点积/ (向量长度的叉积) = ( x1x2 + y1y2 + z1z2) / ( 跟号(x1平方+y1平方+z1平方 ) x 跟号(x2平方+y2平方+z2平方 ) )
 */
$cos = [];
$denominator1 = 0;
for ($i = 2; $i < 8; $i++) {
    if (!empty($table[$user_index][$i])) {
        $denominator1 += $table[$user_index][$i] * $table[$user_index][$i];
    }
}
print_r($table);

for ($i = 0; $i < 6; $i++) {
    $numerator = 0;
    $denominator2 = 0;
    for ($j = 2; $j < 5; $j++) {
        if (!empty($table[$user_index][$j]) && !empty($table[$i][$j])) {
            $numerator += $table[$user_index][$j] * $table[$i][$j];
            $denominator2 += $table[$i][$j] * $table[$i][$j];
        }
    }
    $denominator = sqrt($denominator1 * $denominator2);
    $cos[$i] = $numerator / ($denominator);
}
print_r($cos);

//排序
$sort = new ShellsSort();
$back = $sort->start($cos);
print_r($back);

//确定邻居
$neighbour_group = [];
//从非自己开始
$index = count($back) - 1 - 1;
for ($i = $index; $i > $index - 3; $i--) {
    for ($j = 0; $j < 6; $j++) {
        if ($back[$i] == $cos[$j]) {
            $neighbour_group[$j][] = $cos[$j];
            //没有接触的项
            foreach ($never as $item) {
                $neighbour_group[$j][] = $table[$j][$item];
            }
        }
    }
}
print_r($neighbour_group);

//预测评分
for ($i = 1; $i < count($never) + 1; $i++) {
    $pre_numerator = 0;
    $pre_denominator = 0;
    foreach ($neighbour_group as $item) {
        if(!empty($item[$i])) {
            $pre_numerator += $item[0] * $item[$i];
            $pre_denominator += $item[0];
        }
    }
    $pre_score[] = $pre_numerator / ($pre_denominator);
}
print_r($pre_score);

