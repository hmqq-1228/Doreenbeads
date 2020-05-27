<?php
    $count = intval(file_get_contents('count.log'));
    file_put_contents('count.log', $count+1);

    /*$filename = "2015-catalog.zip";
    
    $filepath = $_SERVER['DOCUMENT_ROOT'].$filename;*/
    header("Location: http://catalog.8seasons.com/E-Catalog.zip");
    
    /*if(!file_exists($filepath)){ 
        echo "it is not found"; 
        exit; 
    } 

    Header( "Content-type:  application/force-download "); 
    Header( "Accept-Ranges:  bytes "); 
    Header( "Accept-Length: " .filesize($filepath));
    Header( "Content-Disposition: attachment; filename=".$filename); 
    readfile("$filename"); */

?>