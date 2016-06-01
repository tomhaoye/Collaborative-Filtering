<?php

$end_time = explode(' ', microtime());
$this_time = $end_time[0] + $end_time[1] - ($start_time[0] + $start_time[1]);
$this_time = round($this_time, 3);
echo "耗时：" . $this_time . " 秒。";