<?php
$parentPid = getmypid();

$pid = pcntl_fork();

$a = 0;

if ($pid == -1) {

    die('fork failed');

} else if ($pid == 0) {

    $mypid = getmypid();
    sleep(1);
    echo 'I am child process. My PID is ' . $mypid . ' and my father\'s PID is ' . $parentPid . PHP_EOL;
    $a += 1;

} else {

    sleep(1);
    echo 'Oh my god! I am a father now! My child\'s PID is ' . $pid . ' and mine is ' . $parentPid . PHP_EOL;
    $a += 2;

}

echo($a . PHP_EOL);
include 'time_help.php';