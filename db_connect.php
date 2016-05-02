<?php

header("Content-type: text/html; charset=utf-8");

$link = mysql_connect("127.0.0.1", "root", "");
if($link)
{
    mysql_select_db("cf",$link);
}
else
{
    die('Could not connect: '.mysql_error());
}
