<?php

echo <<<HTML
<html>
<body>
<pre>
HTML;
for( $i=20; $i > 0 ; $i--)
{
mt_srand();
$number = mt_rand();
$temp = hash("sha512",$number);
echo substr($temp, 0, 150);
echo "<br />";
echo time();
}

 ?>
