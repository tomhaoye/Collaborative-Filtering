<?php
require('ShellsSort.php');
include_once('db_connect.php');
include('variance.php');

$u_sql = 'select count(0) from ml_users';
$i_sql = 'select count(0) from ml_items';
$u_r = mysql_query($u_sql);
$i_r = mysql_query($i_sql);
$u_c = mysql_fetch_row($u_r)[0];
$i_c = mysql_fetch_row($i_r)[0];

//构建矩阵
foreach ($arr as $key => $item) {
    for ($j = 1; $j <= $i_c; $j++) {
        $sql = 'select * from ml_data where user_id = ' . $key . ' and item_id = ' . $j;
        $resource = mysql_query($sql);
        if ($row = mysql_fetch_assoc($resource)) {
            $de_array[$key][$j] = $row['rating'];
        } else {
            $de_array[$key][$j] = null;
        }
    }
}

//项目开始列
$start_col = 1;
//用户id ＝下标
/**
 * variance中定义
 */
//是否预测
$predict = true;
//查找没有接触的项目
if ($predict) {
    //预测评分
    for ($i = 1; $i < 1600; $i++) {
        $never[] = $i;
    }
} else {
    for ($j = $start_col; $j < $i_c; $j++) {
        if (empty($de_array[$user_id][$j])) {
            $never[] = $j;
        }
    }
}
print_r($never);

/**
 * 根据余弦公式, 夹角余弦 = 向量点积/ (向量长度的叉积) = ( x1x2 + y1y2 + z1z2) / ( 跟号(x1平方+y1平方+z1平方 ) x 跟号(x2平方+y2平方+z2平方 ) )
 */
$cos = [];
foreach ($arr as $key => $item) {
    $numerator = 0;
    $denominator1 = 0;
    $denominator2 = 0;
    for ($j = $start_col; $j < $i_c; $j++) {
        if (!empty($de_array[$user_id][$j]) && !empty($de_array[$key][$j])) {
            $numerator += $de_array[$user_id][$j] * $de_array[$key][$j];
            $denominator1 += $de_array[$user_id][$j] * $de_array[$user_id][$j];
            $denominator2 += $de_array[$key][$j] * $de_array[$key][$j];
        }
    }
    $denominator = sqrt($denominator1 * $denominator2);
    $cos[$key] = $numerator / ($denominator);
}
echo '相似度';
print_r($cos);

//排序
//$sort = new ShellsSort();
//$back = $sort->start($cos);
//echo '排序后';
//print_r($back);

//确定邻居
$neighbour_group = [];
//从非自己开始找到最相近的三人
//$index = count($back) - 1 - 1;
//for ($i = $index; $i > $index - 3; $i--) {
//    for ($j = 0; $j < $usr_count; $j++) {
//        if ($back[$i] == $cos[$j]) {
//            $neighbour_group[$j][] = $cos[$j];
//            //没有接触的项
//            foreach ($never as $item) {
//                $neighbour_group[$j][] = $de_array[$j + 1][$item];
//            }
//        }
//    }
//}

//大于0.95的相似度则加入邻居组
foreach ($cos as $cos_key => $cos_item) {
    foreach ($arr as $key => $nb) {
        if ($cos_key == $key && $cos_item > 0.95) {
            $neighbour_group[$key][] = $cos_item;
            //需要预测的项
            foreach ($never as $item) {
                $neighbour_group[$key][] = $de_array[$key][$item];
            }
        }
    }
}
//print_r($neighbour_group);

//预测评分
foreach ($never as $key => $value) {
    $pre_numerator = 0;
    $pre_denominator = 0;
    foreach ($neighbour_group as $item) {
        if (!empty($item[$key])) {
            $pre_numerator += $item[0] * $item[$key];
            $pre_denominator += $item[0];
        }
    }
    if (!empty($pre_denominator)) $pre_score[$value] = $pre_numerator / $pre_denominator;
    else $pre_score[$value] = null;
}
echo '预测评分';
print_r($pre_score);
