<?php

echo<<<HTML
<html>
<body>
HTML;

if(isset($_POST['text']))
{
    $time = $_POST['text'];
    echo hash("sha512", $time);
}
else
{
    echo <<<HTML

    <pre>
HTML;
    for( $i=20; $i > 0 ; $i--)
    {
        mt_srand();
        $number = mt_rand();
        $temp = hash("sha512",$number);
        echo substr($temp, 0, 150);
        echo "<br />";
        echo time() . " ";
    }
}
 ?>

<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="text" name="text" />
    <input type="submit" value="Send" />
</form>
</body></html>


