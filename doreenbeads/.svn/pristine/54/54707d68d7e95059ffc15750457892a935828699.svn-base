<?php
    $solrXml = simplexml_load_file("solrConfig.xml");
//    var_dump($solrXml->config);
    $solrXml->config->switch = 4;
//    $solrXml->config->addChild('switch','3');
    $newXml = $solrXml->asXML();
    $fp = fopen("solrConfig.xml","w+");
    var_dump(fwrite($fp,$newXml));
?>
