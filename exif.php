<?php
echo "test1.jpg:<br />\n";
$exif = exif_read_data('images/2010.08.08.10.28.35.jpg', 'IFD0');
echo $exif===false ? "No header data found.<br />\n" : "Image contains
headers<br />\n";

$exif = exif_read_data('images/2010.08.08.10.28.35.jpg' , 0, true);
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
?>
