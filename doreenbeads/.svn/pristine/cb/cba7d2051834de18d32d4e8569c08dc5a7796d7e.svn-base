<?php
$path_new = $_GET['pn'];
header("Content-type:application/vnd.ms-excel;charset=utf-8");
header("Content-Disposition:attachment;filename=".basename($path_new));
readfile($path_new);
fclose($path_new);