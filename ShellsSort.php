<?php

Class ShellsSort{

    public $arr;

    function StaInsert($m, $arr, $divide1)
    {
        for ($i = $divide1; $i < $m; $i++) {
            if ($arr[$i] < $arr[$i - $divide1]) {
                $tmp = $arr[$i];
                $j = $i - $divide1;
                //将从j开始de数往后推直到不比前面得数小
                while ($tmp < $arr[$j]) {
                    $arr[$j + $divide1] = $arr[$j];
                    $j--;
                    if ($j < 0) break;
                }
                $arr[$j + $divide1] = $tmp;
            }
        }
        $this->arr = $arr;
    }

    function start($arr)
    {
        $m = count($arr);
        $divide1 = floor($m / 2);
        while ($divide1 >= 1) {
            $this->StaInsert($m, $arr, $divide1);
            $divide1 = floor($divide1 / 2);
        }
        return $this->arr;
    }

}
