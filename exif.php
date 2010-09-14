<?php
echo "test1.jpg:<br />\n";
$exif = exif_read_data('images/2010.09.04.13.05.59.jpg', 'IFD0');
echo $exif===false ? "No header data found.<br />\n" : "Image contains
headers<br />\n";

$exif = exif_read_data('images/2010.09.04.13.05.59.jpg' , 0, true);
echo "test2.jpg:<br />\n";
foreach ($exif as $key => $section) {
        foreach ($section as $name => $val) {
                    if(is_array($val))
                    {
                        foreach ($val as $arval => $newval)
                        {
                            echo "$key.$name.$arval: $newval<br />\n";
                        }
                    }
                    else
                        echo "$key.$name: $val<br />\n";
                }
}

echo "hi<br />";
$lat = convertLatLong($exif[GPS][GPSLatitude][0], $exif[GPS][GPSLatitude][1], $exif[GPS][GPSLatitude][2]);
$long = convertLatLong($exif[GPS][GPSLongitude][0], $exif[GPS][GPSLongitude][1], $exif[GPS][GPSLongitude][2]);
$long=$long*-1;


echo <<<HTML
<a href="http://maps.google.com/maps?q=$lat,+$long">maps</a>
HTML;


function convertLatLong($degree, $min, $sec)
{
    //N 27/1 38/1 5777/100 E 97/1 23/1 5664/100
    $min = ($min);

    echo "Min: $min, Sec: $sec<br />";
    $seconds = (($min)*60)+($sec);
    echo "Seconds: $seconds<br />";
    $fracSec = $seconds/3600;
    echo "Frac Seconds: $fracSec<br />";
    $lat = ($degree+$fracSec);
    echo "Lat/Long: $lat<br />";

    return $lat;
}
?>
