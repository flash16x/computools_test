<?php

$link = mysqli_connect('localhost', 'root', '', 'db')
or die("Ошибка " . mysqli_error($link));

$query = 'select * from `categories` order by `parent_id` asc';
$res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

$parents = [];
while ($row = $res->fetch_row()){
    $id = intval($row[0]); $pid = intval($row[1]);
    $parents[$pid][$id] = $row[2];
}

function build_result($pid, $array){
    $res = [];
    foreach ($array[$pid] as $id=>$name){
        if(isset($array[$id]))
            $res[$name] = build_result($id, $array);
        else
            $res[] = $name;
    }
    return $res;
}

$result = build_result(0, $parents);
var_dump($result);
