<?php
mt_srand();
$number = mt_rand();
echo hash("sha512",$number);

 ?>
