<?php
 
$imageFile = 'path/to/image';
 
/* Set the width fixed at 200px; */
$width = 200;
 
/* Get the image info */
$info = getimagesize($imageFile);
 
/* Calculate aspect ratio by dividing height by width */
$aspectRatio = $info[1] / $info[0];
 
/* Keep the width fix at 100px, 
   but change the height according to the aspect ratio */
$newHeight = (int)($aspectRatio * $width) . "px";
 
/* Use the 'newHeight' in the CSS height property below. */
$width .= "px";
 
echo "<img style=\"width: $width; height: $newHeight;\" 
       src=\"$imageFile\" />";