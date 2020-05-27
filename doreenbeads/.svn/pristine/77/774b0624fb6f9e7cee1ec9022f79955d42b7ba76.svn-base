<?php

function call_payment($url, $data, $type='HML') {

	echo $url;

//	$data = 'IN=' . $data;
	 $data = 'IN=' . urlencode($data);
	echo $data;
	// create a new cURL resource
	$ch = curl_init();

	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_HEADER, false);
	if ($type=='CL') {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Content-Length: '.strlen($data) ));
	} else {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'Content-Length: '.strlen($data) ));
	}

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	//curl_setopt($ch, CURLOPT_URL, $url.'?IN='.urlencode($data));
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true); 
//	http://davidwalsh.name/php-ssl-curl-error 
	curl_setopt($ch,CURLOPT_CAINFO,'./mozilla.pem');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));

	// grab URL and pass it to the browser
	$result=curl_exec($ch);

    if ( curl_errno($ch) ) {
        $result = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
    } else {
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch($returnCode){
            case 404:
                $result = 'ERROR -> 404 Not Found';
                break;
            default:
                break;
        }
    }
    
	//echo "result = " . var_dump($result) . "<br>";
	// close cURL resource, and free up system resources
	curl_close($ch);
	return $result;
}

function call_payment2($dest, $data, $type='HML'){

	$link = $dest . '?IN=' . urlencode($data);
	$url  = parse_url($link);

	//var_dump($url);
	// open UNIX socket
	$fp = fsockopen("ssl://" . $url['host'], 443, $errno, $errstr);

	// check for errors
	if (!$fp)
	{
		echo "$errstr ($errno)<br/>\n";
		echo $fp;
		exit;
	}

	// put the http header

//	fputs($fp, "GET " . $url['path'] . "?IN=" . urlencode($data) . " HTTP/1.1\r\n");
	fputs($fp, "POST " . $url['path'] . " HTTP/1.1\r\n"); 
	fputs($fp, "Host: " . $url['host'] . "\r\n");
	if ($type=='CL') {
		fputs($fp, "Content-Type:application/x-www-form-urlencoded; charset=utf-8\r\n");
	} else {
		fputs($fp, "Content-Type: text/xml; charset=utf-8\r\n");
	}
	fputs($fp, "Content-length: ".strlen($data)."\r\n"); 
	fputs($fp, "Connection: close\r\n\r\n");
	fwrite($fp, $data.'\r\n\r\n');
	$results = '';
	while (!feof($fp))
	{
		$results .= fgets($fp);
		//echo "results : " . $results;
	}
	fclose($fp);
	return parse_xml_response($results);
	//return $results;
}

function parse_xml_response($str)
{
	$start = strpos($str, '<XML>');
	$end = strpos($str, '</XML>');
	return substr($str, $start);
}
?>