<?php
/*
chimp_robbie wei
*/
    //the Username & Password you use to login to your MailChimp account
    $mc_username = 'Hongsheng.Xie';
    $mc_password = 'luo_lai_wei8';
    
    //Id = ee40659380- supplies.com 
    //Id = 5d19fe5d10- knitting.com
    // A List Id to run examples against. use lists() to view all
    
    
    //API Key - see http://admin.mailchimp.com/account/api
    //c4ad76808c144b90c2be437a8aed7200-us1     61c6fac504acc985a276c82670fe9c3b-us4  c4ad76808c144b90c2be437a8aed7200-us1
    //$apikey = 'c4ad76808c144b90c2be437a8aed7200-us1';
    $apikey = '79a29579bdbfb9139a9a19cf1cfa8679-us14'; // debug
    
    $grouping_id = 41;
    $grouplimit = 3000;
    
    // A List Id to run examples against. use lists() to view all
    // Also, login to MC account, go to List, then List Tools, and look for the List ID entry
    //$listIdArray=array('045febd92d','6862e2fa77','73ac255537','a240693acc');
    $listIdArray=array('451ff75e60','4c35e4ca22','22a2b2b4a9','cc70bff1e7');//debug
    //if(isset($_SESSION['register_languages_id']) && $_SESSION['register_languages_id'] != ''){
    	//$lang_MC = $_SESSION['register_languages_id'];
    //}else{
    	$lang_MC = $_SESSION['languages_id'];
    //}
    $listId = $listIdArray[$lang_MC-1]==''?'045febd92d':$listIdArray[$lang_MC-1];
    
    // A Campaign Id to run examples against. use campaigns() to view all
    $campaignId = 'YOUR MAILCHIMP CAMPAIGN ID - see campaigns() method';

    //some email addresses used in the examples:
    $my_email = 'INVALID@example.org';
    $boss_man_email = 'INVALID@example.com';

    //just used in xml-rpc examples
    $apiUrl = 'http://api.mailchimp.com/3.0/';
    
?>