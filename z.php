<?php
include"simple_html_dom.php";
#$searchs = $_GET['search'];
#$i = $_GET['i'];
$url = "https://www.google.com/search?q=$searchs&start=$i&ie=utf-8&oe=utf-8";

$option = array(
            'http' => array(
                'method' => 'GET',
                'header' => $ua,
            )
    );
    $context = stream_context_create($option);
    $k = new simple_html_dom();
    $k -> load_file($url, false, $context);

#save("log.txt",$simple_html_dom);

