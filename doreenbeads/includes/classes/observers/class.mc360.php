<?php

class mc360 extends base {
    var $system = "zc";
    var $version = "1.0";
    
    var $debug = false;

    var $valid_files = false;
    var $valid_cfg = false;
    var $install_dir = 'mc360/';
    var $cfg_file = 'mc360.ini.php';
    var $apikey = '';
    var $key_valid = false;
    var $store_id = '';
    
    function mc360() {
        global $zco_notifier;
        $zco_notifier->attach($this, array('NOTIFY_MODULE_START_META_TAGS'));
        $zco_notifier->attach($this, array('NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES'));

        require_once(DIR_WS_INCLUDES.$this->install_dir.'class.iniparser.php');
        require_once(DIR_WS_CLASSES.'Mailchimp.php');

        $this->cfg_file = DIR_WS_INCLUDES.$this->install_dir.$this->cfg_file;
        $this->validate_files();
        if ($this->valid_files){
            $cfg = new iniParser($this->cfg_file);
            $this->apikey = $cfg->get("user_settings","apikey");
            $this->store_id = $cfg->get("do_not_edit","store_id");
            $this->key_valid = $cfg->get("do_not_edit","key_valid");
        }
        $this->validate_cfg();
    }
    
    function complain($msg){
            echo '<div style="position:absolute;left:0;top:0;width:100%;font-size:24px;text-align:center;background:#CCCCCC;color:#660000">MC360 Module: '.$msg.'</div><br/>';
    }
    
    function validate_files(){
        $this->valid_files = false;
        if (!file_exists($this->cfg_file)){
            $this->complain('<strong>'.$this->cfg_file.'</strong> must EXIST and be writable');
        }elseif (!is_writable($this->cfg_file)){
            $this->complain('<strong>'.$this->cfg_file.'</strong> must BE WRITABLE');
        } else {
            $this->valid_files = true;
        }
    }
    
    function validate_cfg(){
        $this->valid_cfg = false;
        if (!$this->valid_files){
            return;
        }elseif (!$this->apikey){
            $this->complain('You have not entered your API key. Please read the installation instructions.');
            return;
        }
        
        if (!$this->key_valid){
            $GLOBALS["mc_api_key"] = $this->apikey;
            $api = new MCAPI('notused','notused');
            $res = $api->ping();
            if ($api->errorMessage!=''){
                $this->complain('Server said: "'.$api->errorMessage.'". Your API key is likely invalid. Please read the installation instructions.');
                return;
            } else {
                $cfg = new iniParser($this->cfg_file);
                $this->key_valid = true;
                $cfg->setValue("do_not_edit","key_valid", $this->key_valid);
                
                if (!$this->store_id){
                    $this->store_id = md5(uniqid(rand(), true));
                    $cfg->setValue("do_not_edit","store_id",$this->store_id);
                }
                $cfg->save();
            }
        }
        
        if (!$this->store_id){
            $this->complain('Your Store ID has not been set. This is not good. Contact support.');
        } else {
            $this->valid_cfg = true;
        }
    }

    function update(&$callingClass, $notifier, $paramsArray) {
        if (!$this->valid_cfg){
            return;
        }

        global $order, $insert_id, $db;

        if ($notifier == 'NOTIFY_MODULE_START_META_TAGS'){
            $thirty_days = time()+60*60*24*30;
            if (isset($_REQUEST['mc_cid'])){
                setcookie('mailchimp_campaign_id',trim($_REQUEST['mc_cid']), $thirty_days, '/');
            }
            if (isset($_REQUEST['mc_eid'])){
                setcookie('mailchimp_email_id',trim($_REQUEST['mc_eid']), $thirty_days, '/');
            }
            return;
        } 
        if ($notifier == 'NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES'){           
            $orderId = $_SESSION['order_number_created']; // just to make it obvious.

            if ($this->debug){
                $fp = fopen('/tmp/zc/test.txt','a+');
                fwrite($fp, "------------[New Order $orderId]-----------------\n");
                fwrite($fp, '$order ='."\n");
                fwrite($fp, print_r($order, true) );
                fwrite($fp, '$_SESSION ='."\n");
                fwrite($fp, print_r($_SESSION, true) );
                fclose($fp);
            }

            if (!isset($_COOKIE['mailchimp_campaign_id']) || !isset($_COOKIE['mailchimp_email_id'])){
                return;
            }
            
            if ($this->debug){
                $fp = fopen('/tmp/zc/ids.txt','a+');
                fwrite($fp, date('Y-m-d H:i:s').' current ids:'."\n");
                fwrite($fp, date('Y-m-d H:i:s').' eid ='.$_COOKIE['mailchimp_email_id']."\n");
                fwrite($fp, date('Y-m-d H:i:s').' cid ='.$_COOKIE['mailchimp_campaign_id']."\n");
                fclose($fp);
            }

            $response = customers_for_mailchimp_order_event($_SESSION['customer_email'], $orderId, 30);
            //write_file( '/', 'test.txt', json_encode($response) ."\n\n" );
       }
  }//update
}//mc360 class

?>
