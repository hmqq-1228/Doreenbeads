<?php
$solrConfig = simplexml_load_file("solrConfig.xml");
switch (true) {
   case  $solrConfig->config->switch = 1:
       $coreNow = 2;
       break;
   case $solrConfig->config->switch = 2:
       $coreNow = 1;
       break;
}
$shell = "/usr/bin/rmindex".$coreNow.".sh";
//$shell = "/usr/bin/rmindex1.sh";
echo $shell;
system($shell);
//system("rm -rf /tmp/ss",$array);
?>
