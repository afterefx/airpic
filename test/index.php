<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Gallery | Infinite Scroll</title>
<link rel="stylesheet" href="style.css" />
</head>

<body onload="setInterval('scroll();', 250);">

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
                    <span class="frame-outer " style="display:inline;">
                    <span><span><span><span>
                    <img src="$thumbDir$fullArray[$index]" height="20%"/> </span></span></span></span></span></a></div> 
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


<div id="container">
    <a href="img/Achievements.jpg"><img src="thumb/Achievements.jpg" /></a>
    <a href="img/Bw.jpg"><img src="thumb/Bw.jpg" /></a>
    <a href="img/Camera.jpg"><img src="thumb/Camera.jpg" /></a><br />
    <a href="img/Cat-Dog.jpg"><img src="thumb/Cat-Dog.jpg" /></a>
    <a href="img/CREATIV.jpg"><img src="thumb/CREATIV.jpg" /></a>
    <a href="img/creativ2.jpg"><img src="thumb/creativ2.jpg" /></a><br />
    <a href="img/Earth.jpg"><img src="thumb/Earth.jpg" /></a>
    <a href="img/Endless.jpg"><img src="thumb/Endless.jpg" /></a>
    <a href="img/EndlesSlights.jpg"><img src="thumb/EndlesSlights.jpg" /></a>
    <p>9 Images Displayed | <a href="#header">top</a></p>
    <br />
    <hr />
</div>
</body>
</html>
<script>
var contentHeight = 800;
var pageHeight = document.documentElement.clientHeight;
var scrollPosition;
var n = 10;
var xmlhttp;
function putImages(){
    if (xmlhttp.readyState==4) 
    {
        if(xmlhttp.responseText){
            var resp = xmlhttp.responseText.replace("\r\n", ""); 
            var files = resp.split(";");
            var j = 0;
            for(i=0; i<files.length; i++){
                if(files[i] != ""){
                    document.getElementById("container").innerHTML += '<a href="img/'+files[i]+'"><img src="thumb/'+files[i]+'" /></a>'; j++;
                    if(j == 3 || j == 6)
                        document.getElementById("container").innerHTML += '<br />';
                    else if(j == 9){
                        document.getElementById("container").innerHTML += '<p>'+(n-1)+" Images Displayed | <a href='#header'>top</a></p><br /><hr />";
                    j = 0;
                    }
                }
            }
        }
    }
}
    
    
function scroll()
{
    
    if(navigator.appName == "Microsoft Internet Explorer")
        scrollPosition = document.documentElement.scrollTop;
    else
        scrollPosition = window.pageYOffset;        
    if((contentHeight - pageHeight - scrollPosition) < 500){
        if(window.XMLHttpRequest)
            xmlhttp = new XMLHttpRequest();
        else
            if(window.ActiveXObject)
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            else
                alert ("Bummer!  Your browser does not support XMLHTTP!");          

            var url="getImages.php?n="+n;

            xmlhttp.open("GET",url,true);
            xmlhttp.send();
            n += 9;
            xmlhttp.onreadystatechange=putImages;       
            contentHeight += 800;        
    }
}

</script>


