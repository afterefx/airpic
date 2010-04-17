<?php
include_once 'includes/display.php';

$content.=<<<HTML
    <div id="gallery">
HTML;

for($index=($page-1)*$imagesPerPage; $index < ($page * $imagesPerPage); NULL)
{
    $content.=<<<HTML
        <div id="row">
HTML;


    for($countRow=0; $countRow < 3; $countRow++)
    {
        $content.=<<<HTML
        <div id="pic"> 
            <a href="$fullDir$fullArray[$index]">
            <span class="frame-outer " style="display:inline;"><span><span><span><span>
            <img src="$thumbDir$thumbArray[$index]" height="20%"/>
            </span></span></span></span></span>
            </a> 
        </div> 
HTML;
        $index++;
    }


    $content.=<<<HTML
</div>
HTML;
}

$content.=<<<HTML
</div>
HTML;

displayPage($content, $page, $fullCount, $imagesPerPage);
 
?>
