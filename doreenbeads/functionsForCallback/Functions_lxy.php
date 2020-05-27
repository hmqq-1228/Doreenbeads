<?php
include('conf.php');
class Functions{
    public $xml;
    public $lang;
    public $email;
    public $smarty;
    public $deliveryTime;
    public $orderNormalAll;
    public $expressMethods;
    public $days;
//		public $isSpecialExpress;
    public $address;
    public $traceNumbers;
    public $webSite;
    public $exprssInfo;
    public $expressAll;
    public $isDhls;
    public $isHmey;
//		public $testEmail;
//		public $testEmailArray;
    public $success = 0;
    public $email_subject;

    protected $__packageInfo;
    protected $__shortProductInfo;
    protected $__shortProductList;
    protected $__orderForShortInfo;
    protected $__orderForShortList;
    protected $__toSelf;

//		private $_isTest = 1;	//	1:mail to developer for test; 2:mail to sales for test; 0:mail to customer formally

    public function __construct($file, $type="flow") {
        global $toSaleArray, $toSelf;

        $this->dir = dirname(__FILE__);

        $this->writeLog('Begin to process __construct.');

        //	smarty to generate email template
        $this->smarty				= new Smarty();
        $this->smarty->caching		= false;
        $this->smarty->cache_dir	= DIR_WS_INCLUDES.'scache/';
        $this->smarty->template_dir = $this->dir."/erpTemplate/";
        $this->smarty->compile_dir	= $this->dir."/erpTemplate_c/";
        $this->smarty->config_dir	= DIR_WS_INCLUDES."libs/configs/";

        //	load simplexml from file or flow;
        if($type == 'file') {
            $this->xml = simplexml_load_file($file);
        } else {
            $this->xml = simplexml_load_string($file);
        }

        if(! $this->xml){
            $this->writeLog('Error process __construct. No XML received.');
            return $this->success = 0;
        }

        $this->__toSelf = $toSelf;
        //	get product
        $this->orderIdForLang = 0;
        $this->hasSpOrder = false;
        $this->orderNormalAll = $this->getOrderInfo(0);
        $this->__orderForShortInfo = $this->getOrderInfo(1,array('model'=>"ProductNo", "quantity"=>"Quantity"));
        $this->__shortProductInfo = $this->getShortProductInfo();
        //	get languge
        $lang_arr = $this->language((string)$this->xml->Email, $this->orderIdForLang);
        $this->lang = $lang_arr[0];		//	ex. 'english';
        $this->lang1 = $lang_arr[1];	//	ex. '1';
        if(count($this->__shortProductInfo) > 0) {
            $this->__shortProductList = $this->getProduct($this->__shortProductInfo);
        }
        if(count($this->__orderForShortInfo) > 0) {
            $this->__orderForShortList = $this->getProduct($this->__orderForShortInfo);
        }

        //	parse xml
        $this->exprssInfo = $this->getExpreeInfo();
        $this->email = (string)$this->xml->Email;
//			$this->deliveryTime = strtotime($this->getExpressDetail("deliveryTime"));
        $this->deliveryTime = $this->getExpressDetail("deliveryTime");
//			$this->orderNormalAll = $this->getOrderInfo(0);
        $this->expressMethods = $this->getExpressDetail("methods");
        $this->days = $this->getExpressDetail("days");
        $this->expressAll = $this->getExpressDetail("expressCode");
        $this->reportAmount = $this->getExpressDetail("reportAmount");
        $this->address = $this->getExpressDetail("address");
        $this->traceNumbers = $this->getExpressDetail("traceNumbers");
        $this->webSite = $this->getExpressDetail("webSites");
//			$this->__orderForShortInfo = $this->getOrderInfo(1,array('model'=>"ProductNo", "quantity"=>"Quantity"));
//			$this->__shortProductInfo = $this->getShortProductInfo();
//			if(count($this->__shortProductInfo) > 0) {
//				$this->__shortProductList = $this->getProduct($this->__shortProductInfo);
//			}
//			if(count($this->__orderForShortInfo) > 0) {
//				$this->__orderForShortList = $this->getProduct($this->__orderForShortInfo);
//			}

        $this->isDhls = $this->isSpecialExpress(array('ywxoz','ywfedex','ywlbip','dfhkdhl','hmdhlsh','ywdhl','hmhkdhl','kddhl','hmshdhl','zydhl','ywdhl-dh','dfspups','kdups','zyups','upssk','upskj','upsdh','zyfedex'), $this->expressAll);
        $this->isHmey = $this->isSpecialExpress(array("hmey",'bybpy'), $this->expressAll);
        //	没有跟踪号的几个运送方式
//			$this->isNoTraceNum = $this->isSpecialExpress(array('hkmail','trstm','trstma','ynkqy','sfhyzxb','sfhky'), $this->expressAll);
        $this->isNoTraceNum = $this->isSpecialExpress(array('hkmail','trstm','ynkqy','trstma','sfhky','sfhyzxb','jtau','est'), $this->expressAll);

        $this->__packageInfo = $this->getPackageInfo();

        $this->randNum = rand(1,1000).mt_rand();

        //	write to file if flow for backup
        if($type == 'flow'){
            $fileDir = $this->dir."/erpXml/".date("Ym");
            if(! is_dir($fileDir)) mkdir($fileDir);
            $fileName = $fileDir."/".$this->email.'_'.$this->randNum.".xml";
            file_put_contents($fileName, $file);
        }

        $this->email_subject = array(
            10 => array(
                1 => 'Glad to find your parcel has been delivered, we need your feedback.',
                2 => 'Super,dass Ihr Paket zugestellt wurde, wir benötigen Ihr Feedback',
                3 => 'Рад, что ваша посылка была доставлна, нам нужна ваша обратная связь. ',
                4 => 'Heureux de trouver votre colis a été livré, nous avons besoin de vos commentaires.',
                5 => 'Nos alegramos de encontrar su paquete ha sido entregado, necesitamos su realimentación.',
                6 => '商品のお届けについてお問い合わせ',
                7 => 'Felice di trovare che il vostro pacco è stato consegnato, abbiamo bisogno del vostro feedback. '
            )
        );

        $this->writeLog('End of process __construct.');
    }

    private function getPackageInfo(){
        $orders_info = array();
        $packages_info = array();
        $orders_info['customers_email_address'] = $this->email;

        if($orders_info['customers_email_address'] != ''){
            $get_customers_id_query = mysql_query('SELECT customers_id FROM ' . TABLE_CUSTOMERS . ' WHERE customers_email_address = "' . $orders_info['customers_email_address'] . '" limit 1');
            $query_results = mysql_fetch_array($get_customers_id_query);
            $orders_info['customers_id'] = $query_results['customers_id'];
        }
        $i = 0;
        foreach($this->xml->Packages->Package as $package) {
            $package_id = trim($package->PackageId);
            if($package_id != ''){
                $packages_info[$i]['package_id'] = $package_id;
            }
            foreach($package->TranceNumbers->TranceNumber as $traceNumber) {
                if ((string)trim($traceNumber)) {
                    $packages_info[$i]['traceNumber'][] = (string)$traceNumber;
                }
            }
            $packages_info[$i]['delivery_date'] = trim($package->DeliveryTime);
            $products_array = array();
            $j = 0;
            foreach($package->Details->Item as $item) {
                if((string)$item->OrderId != '' && (string)$item->OrderId != '/'){
                    $products_array[$j]['orders_id'] = (string)$item->OrderId;
                }
                $products_array[$j]['products_model'] = (string)$item->ProductNo;
                $products_array[$j]['products_quantity'] = (int)$item->Quantity;
                $j++;
            }
            $packages_info[$i]['products_info'] = $products_array;
            $i++;
        }
        $orders_info['packages_info'] = $packages_info;

        return $orders_info;
    }

    /**
     * get all normal orderid(the order have been shipped),the additional orderid not include
     * @param type $type
     * @return $orderInfo
     * $type,0 = normal;1 = complementary
     */
    private function getOrderInfo($type=0, $info = array()) {

        $orderInfo = array();
        $i = 0;
        foreach($this->xml->Packages->Package as $package) {
            foreach($package->Details->Item as $item) {
                if(intval($item->OrderId) > $this->orderIdForLang) $this->orderIdForLang = intval($item->OrderId);
                //Tianwen.Wan20160411->如果不是发送给自己，订单号中有S或T去掉该订单信息
                /*
                if($this->email != $this->__toSelf && (!(strpos((string)$item->OrderId, 'S') === false) || !(strpos((string)$item->OrderId, 'T') === false))) {
                    continue;
                }
                */
                if (count($info) == 0) {
                    if ($item->IsReissued == $type) {
                        $orderInfo[] = (string)$item->OrderId;
                        if((string)$item->OrderId == '' || (string)$item->OrderId == '/') $this->hasSpOrder = true;
                    }
                    $orderInfo = $this->removeSlashAndRepeatValue($orderInfo);
                } else {
                    if ($item->IsReissued == $type) {
                        if((string)$item->OrderId == '' || (string)$item->OrderId == '/'){
                            $this->hasSpOrder = true;
                        }else{
                            $orderInfo[$i]['orderId'] = (string)$item->OrderId;
                            foreach($info as $key => $value) {
                                $orderInfo[$i][$key] = (string)$item->$value;
                            }
                        }
                    }
                }
                $i++;
            }
        }

        sort($orderInfo);
        return $orderInfo;
    }

    //remove the "/" and keep the values in the $array unique
    private function removeSlashAndRepeatValue(&$array = array(), $sort = 1) {
        $array = array_unique($array);
        $array = array_filter($array);
        if (in_array("/", $array)) {
            unset($array[array_search("/", $array)]);
        }
        if ($sort) {
            sort($array);
        }
        return $array;
    }

    private function getShortProductInfo() {
        $shortProductInfo = array();

        $i = 0;
        foreach($this->xml->OrderInShorts->OrderInShort as $orderInShort) {
            if(intval($orderInShort->OrderId) > $this->orderIdForLang) $this->orderIdForLang = intval($orderInShort->OrderId);
            foreach($orderInShort->Products->Product as $product) {
                $shortProductInfo[$i]['quantity'] = (string)$product->Quantity;
                $shortProductInfo[$i]['model'] = (string)$product->ProductNo;
                $shortProductInfo[$i]['orderId'] = (string)$orderInShort->OrderId;
                $i++;
            }
        }

        return $shortProductInfo;
    }

    private function getProduct($productInfo = array()) {

        $product = array();
        for ($i = 0; $i < count($productInfo); $i++) {
            $sql = "SELECT p.products_model,pd.products_name,p.products_image FROM t_products p JOIN t_products_description pd ON p.products_id = pd.products_id 
					WHERE p.products_model = '".$productInfo[$i]['model']."' AND pd.language_id = ".$this->lang1." LIMIT 1";
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result,MYSQLI_ASSOC)) {
                $product[$i]['model'] = $row["products_model"];
                $product[$i]['name'] = $row["products_name"];
                $product[$i]['img'] = $row["products_image"];
                $product[$i]['image'] = '<img src='.HTTP_IMG_SERVER.'bmz_cache/'.get_img_size( $row["products_image"],130,130).' width="130px" height="130px" />';

                if (array_key_exists("quantity", $productInfo[$i])){
                    $product[$i]['quantity'] = $productInfo[$i]['quantity'];
                }
                if (array_key_exists("orderId", $productInfo[$i])){
                    ($productInfo[$i]['orderId'] && $productInfo[$i]['orderId'] != "/") ? $product[$i]['orderId'] = $productInfo[$i]['orderId'] : "";
                }
            }
        }

        return $product;
    }

    private function getExpreeInfo() {
        $expressBundle = array();
        $i = 0;
        foreach($this->xml->Packages->Package as $package) {
            $expressBundle[$i]['countryCode'] = (string)$package->Destination->CountryCode;
            $expressBundle[$i]['ExpressCode'] = (string)$package->TranceTypeCode;
            $expressBundle[$i]['isTraceAdd'] = (string)$package->IsTranceNumAdd;
            $expressBundle[$i]['boxCount'] = (string)$package->PackageCount;
            $expressBundle[$i]['isTraceModify'] = (string)$package->IsTranceNumModify;
            $expressBundle[$i]['deliveryTime'] = (string)$package->DeliveryTime;
            $expressBundle[$i]['reportAmount'] = (string)$package->ReportAmount;
            $expressBundle[$i]['destination']['a1'] = (string)$package->Destination->Address1;
            $expressBundle[$i]['destination']['a2'] = (string)$package->Destination->Address2;
            $expressBundle[$i]['destination']['city'] = (string)$package->Destination->City;
            $expressBundle[$i]['destination']['state'] = (string)$package->Destination->State;
            $expressBundle[$i]['destination']['postCode'] = (string)$package->Destination->Postcode;
            $expressBundle[$i]['destination']['phone'] = (string)$package->Destination->Phone;
            $expressBundle[$i]['destination']['fullname'] = (string)$package->Destination->Fullname;
            $expressBundle[$i]['destination']['country'] = (string)$package->Destination->Country;
            $expressBundle[$i]['destination']['company'] = (string)$package->Destination->Company;
            $j = 0;
            foreach($package->TranceNumbers->TranceNumber as $traceNumber) {
                if ((string)trim($traceNumber)) {
                    $expressBundle[$i]["traceNumber"][$j] = (string)$traceNumber;
                    $j++;
                }
            }
            foreach($package->Details->Item as $item) {
                $orderId = (string)trim($item->OrderId);
                if ($item->OrderId) {
                    //Tianwen.Wan20160411->如果不是发送给自己，订单号中有S或T去掉该订单信息，去掉该包裹信息
                    /*
                    if($this->email != $this->__toSelf && (!(strpos($orderId, 'S') === false) || !(strpos($orderId, 'T') === false))) {
                        unset($expressBundle[$i]);
                    }
                    */
                    //$expressBundle[$i]["traceNumber"][$j] = (string)$traceNumber;
                    //$j++;
                }
            }
            $i++;
        }
        $expressBundle = array_values($expressBundle);

        $_SESSION['languages_id'] = $this->lang1;

        require(DIR_WS_CLASSES . 'shipping.php');
        $shipping_modules = new shipping;
        $shipping_modules->get_all_shipping();
        $expressInfo = array();

        for($j = 0; $j < count($expressBundle); $j++) {
            $expressBundle[$j]['ExpressCode'] = strtolower($expressBundle[$j]['ExpressCode']);
            //	some shipping code
            if($expressBundle[$j]['ExpressCode'] == 'ywdhl-dh')
                $expressBundle[$j]['ExpressCode'] = 'ywdhl';
            else if($expressBundle[$j]['ExpressCode'] == 'airmail-sh' || $expressBundle[$j]['ExpressCode'] == 'zyairmail')
                $expressBundle[$j]['ExpressCode'] = 'airmail';
            else if($expressBundle[$j]['ExpressCode'] == 'ywfedex-bg')
                $expressBundle[$j]['ExpressCode'] = 'ywfedex';
            else if($expressBundle[$j]['ExpressCode'] == 'ywlbip-bg'){
                $expressBundle[$j]['ExpressCode'] = 'ywlbip';
            }

            $expressInfo[$j]['deliveryTime'] = $expressBundle[$j]['deliveryTime'];
            $expressInfo[$j]['boxCount'] = $expressBundle[$j]['boxCount'];
            $expressInfo[$j]['isTraceAdd'] = $expressBundle[$j]['isTraceAdd'];
            $expressInfo[$j]['isTraceModify'] = $expressBundle[$j]['isTraceModify'];
            $expressInfo[$j]['reportAmount'] = $expressBundle[$j]['reportAmount'];
            $expressInfo[$j]['traceNumber'] = $expressBundle[$j]['traceNumber'];
            $expressInfo[$j]['expressCode'] = $expressBundle[$j]['ExpressCode'];

            $expressInfo[$j]['destination']['a1'] = trim($expressBundle[$j]['destination']['a1']);
            $expressInfo[$j]['destination']['a2'] = trim($expressBundle[$j]['destination']['a2']);
            $expressInfo[$j]['destination']['city'] = trim($expressBundle[$j]['destination']['city']);
            $expressInfo[$j]['destination']['state'] = trim($expressBundle[$j]['destination']['state']);
            $expressInfo[$j]['destination']['postCode'] = trim($expressBundle[$j]['destination']['postCode']);
            $expressInfo[$j]['destination']['phone'] = trim($expressBundle[$j]['destination']['phone']);
            $expressInfo[$j]['destination']['fullname'] = trim($expressBundle[$j]['destination']['fullname']);
            $this->fullName = trim($expressInfo[$j]['destination']['fullname']);
            $expressInfo[$j]['destination']['country'] = trim($expressBundle[$j]['destination']['country']);
            $expressBundle[$j]['destination']['company'] = trim($expressBundle[$j]['destination']['company']);

            if(isset($shipping_modules->all_shipping_method[$expressBundle[$j]['ExpressCode']])){
                $shippingInfo = $shipping_modules->all_shipping_method[$expressBundle[$j]['ExpressCode']];
                $shipping_day = $shipping_modules->get_shipping_day($expressBundle[$j]['ExpressCode'], $expressBundle[$j]['countryCode']);
                $expressInfo[$j]['days'] = $shipping_day['day_low'] . '-' . $shipping_day['day_high'] . ' ' . $this->getTextDays($expressBundle[$j]['ExpressCode'], $shippingInfo);
                $expressInfo[$j]['expressType'] = $shippingInfo['title'];
                if ($shippingInfo['track_url'] != NULL) {
                    $expressInfo[$j]['webSite'] = trim($shippingInfo['track_url']);
                }
            }else{
                $expressInfo[$j]['expressType'] = $expressBundle[$j]['ExpressCode'];

                require_once(DIR_WS_CLASSES . 'shipping_virtual.php');
                $virtual_shipping_modules = new shipping_virtual();
                $virtual_shipping_modules->all_virtual_shipping();
                $all_virtual_shipping = $virtual_shipping_modules->get_all_virtual_shipping();

                if(isset($all_virtual_shipping[$expressBundle[$j]['ExpressCode']])){
                    $expressInfo[$j]['days'] = '7-15 ' . $this->getTextDays($expressBundle[$j]['ExpressCode'], array('time_unit' => 10));
                    $expressInfo[$j]['expressType'] = 'USPS';
                    $expressInfo[$j]['webSite'] = $shipping_modules->all_shipping_method['xxeub']['track_url'];
                }
            }
        }


        return $expressInfo;
    }

    private function getTextDays($shipping_method, $shippingInfo){
        $workdaysArr = array(1=>'workdays',2=>'Werktage',3=>'Рабочих дней',4=>'jours de travail',5=>'días laborales',6=>'営業日',7=>'giorni lavorativi');
        $daysArr = array(1=>'days',2=>'Tage',3=>'дней',4=>'jours',5=>'días',6=>'日',7=>'giorni');
        $text_days = '';
        if ($shippingInfo['time_unit'] == 20) {
            $text_days = $workdaysArr[$this->lang1];
        }else{
            $text_days = $daysArr[$this->lang1];
        }
        /*switch ($shipping_method){
            case 'upssk':
            case 'upskj':
            case 'bpost':
            case 'upsdh':
            //bof to russian method
            case 'sfhyzxb':
            case 'sfhky':
            case 'trstma':
            case 'ynkqy':
            case 'trstm':
            case 'eyoubao':
            case 'sptya':
            case 'chinapost':
            case 'airmail':
            case 'ywelsxb':
            //eof
            case 'etk':
            case 'bybpy':
            case 'cnegh':
                $text_days = $workdaysArr[$this->lang1];
                break;
            default:
                $text_days = $daysArr[$this->lang1];
                break;
        }*/
        return $text_days;
    }

    private function getExpressDetail($type="days") {
        switch ($type) {
            case "days":
                $days = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $days[] = $this->exprssInfo[$i]['days'];
                }
                //rsort($days);
                //return $days[0];
                return join("/", $days);
                break;
            case "methods":
                $methods = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $methods[] = $this->exprssInfo[$i]['expressType'];
                }
                $this->removeSlashAndRepeatValue($methods);
                return $methods;
                break;
            case "expressCode":
                $expressCode = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $expressCode[] = $this->exprssInfo[$i]['expressCode'];
                }
                $this->removeSlashAndRepeatValue($expressCode);
                return $expressCode;
                break;
            case "webSites":
                $webSites = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    if($this->exprssInfo[$i]['webSite']) {
                        $webSites[] = $this->exprssInfo[$i]['webSite'];
                    }
                }
                $this->removeSlashAndRepeatValue($webSites);
                return $webSites;
                break;
            case "deliveryTime":
                $deliveryTime = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $deliveryTime[] = $this->exprssInfo[$i]['deliveryTime'];
                }
                $this->removeSlashAndRepeatValue($deliveryTime);
                asort($deliveryTime);
                return $deliveryTime[count($deliveryTime)-1];
                break;
            case "traceNumbers":
                $traceNumbers = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $traceNumbers[] = $this->exprssInfo[$i]['traceNumber'];
                }
                $traceNumbers = $this->arrayFlatten($traceNumbers);
                $traceNumbers = $this->removeSlashAndRepeatValue($traceNumbers);
                return $traceNumbers;
                break;
            case "isTraceAdd":
                $isTraceAdd = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $isTraceAdd[] = $this->exprssInfo[$i]['isTraceAdd'];
                }
                return $isTraceAdd;
                break;
            case "isTraceModify":
                $isTraceModify = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $isTraceModify[] = $this->exprssInfo[$i]['isTraceModify'];
                }
                return $isTraceModify;
                break;
            case "address":
                $address = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $address[] = $this->exprssInfo[$i]['destination'];
                }
                $addressList = $this->assembleAddress($address);
                return $addressList;
                break;
            case "reportAmount":
                $reportAmount = '';
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    if($this->exprssInfo[$i]['reportAmount']!='' && $this->exprssInfo[$i]['reportAmount']!='/')
                        $reportAmount .= ($reportAmount=='' ? '' : '/').$this->exprssInfo[$i]['reportAmount'];
                }
                return $reportAmount;
                break;
            case "boxCount":
                $boxCount = array();
                for($i = 0; $i < count($this->exprssInfo); $i++) {
                    $boxCount[] = $this->exprssInfo[$i]['boxCount'];
                }
                return $boxCount;
                break;
            default:
                break;
        }

    }

    private function assembleAddress($addresses = array()) {
        $addressList = '';
        if(! $addresses) return $addressList;

        $a1 = $a2 = array();
        foreach($addresses as $address){
            if(in_array($address['a1'],$a1) && in_array($address['a2'], $a2)) continue;

            $a1[] = $address['a1'];
            $a2[] = $address['a2'];
            if($addressList != '') $addressList .= "<br />";

            ($address['fullname'] && $address['fullname'] != "/") ? $addressList .= $address['fullname']."<br />" : "";
            ($address['a1'] && $address['a1'] != "/") ? $addressList .= $address['a1']."<br />" : "";
            ($address['a2'] && $address['a2'] != "/") ? $addressList .= $address['a2']."<br />" : "";
            ($address['city'] && $address['city'] != "/") ? $addressList .= $address['city']."," : "";
            ($address['state'] && $address['state'] != "/") ? $addressList .= $address['state']."," : "";
            ($address['postCode'] && $address['postCode'] != "/") ? $addressList .= $address['postCode']."<br />" : "";
            ($address['phone'] && $address['phone'] != "/") ? $addressList .= $address['phone']."<br />" : "";
            ($address['country'] && $address['country'] != "/") ? $addressList .= $address['country']."<br />" : "";
        }
        return $addressList;
    }

    private function arrayFlatten($array) {
        $flat = array();

        foreach ($array as $value) {
            if (is_array($value))
                $flat = array_merge($flat, $this->arrayFlatten($value));
            else
                $flat[] = $value;
        }
        return $flat;
    }

    private function language($email, $orderIdForLang) {
        if($orderIdForLang > 0){
            $sql = 'SELECT l.code as code FROM t_languages l JOIN ' . TABLE_ORDERS . ' o WHERE o.orders_id = "'.$orderIdForLang.'" AND o.language_id = l.languages_id LIMIT 1';
        }else{
            $sql = 'SELECT l.code as code FROM t_languages l JOIN t_customers c WHERE c.customers_email_address = "'.$email.'" AND c.lang_preference = l.languages_id LIMIT 1';
        }
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
            $code = $row['code'];
        }
        switch (true) {
            case $code == 'de':
                return array('german',2);
                break;
            case $code == 'ru':
                return array('russian',3);
                break;
            case $code == 'fr':
                return array('french',4);
                break;
            case $code == 'es':
                return array('spanish',5);
                break;
            case $code == 'jp':
                return array('japanese',6);
                break;
            case $code == 'it':
                return array('italian',7);
                break;
            default:
                return array('english',1);
                break;
        }
    }

    private function getFirstName() {
        if($this->lang1 == 6) $field = 'customers_lastname';
        else $field = 'customers_firstname';

        $sql = 'SELECT '.$field.' FROM t_customers WHERE customers_email_address = "'.$this->email.'" LIMIT 1';
        $result = mysql_query($sql);
        while ($rows = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $firstName = $rows[$field];
        }
        return $firstName;
    }

    private function isSpecialExpress(array $arr1, array $arr2) {
        $intersect = array_intersect($arr1, $arr2);
        if (count($intersect) > 0) {
            return true;
        }
        return false;
    }

    public function my_date_long($raw_date) {
        if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;
        $time_months = array(
            array('January','February','March','April','May','June','July','August','September','October','November','December'),
            array('Januar','Februar','März','April','Mai','Juni','Juli','Augg
ust','September','Oktober','November','Dezember'),
            array('Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь'
            ,'Ноябрь','Декабрь'),
            array('janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'),
            array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
            array('1','2','3','4','5','6','7','8','9','10','11','12'),
            array('gennaio','febbraio','marzo','aprile','maggio','giugno','luglio','agosto','settembre','ottombre','novembre','dicembre')
        );

        $year = (int)substr($raw_date, 0, 4);
        $month = (int)substr($raw_date, 5, 2);
        $day = (int)substr($raw_date, 8, 2);
        $monthNum = $month - 1;
        $languageId = $this->lang1 - 1;
        if($this->lang1 == 6) $longtime = $year.'.'.$time_months[$languageId][$monthNum].'.'.$day;
        else $longtime = $day ." ".$time_months[$languageId][$monthNum].",".$year;
        return $longtime;
    }

    protected function chkHasShippedOrder($p_orderNormal){

        return false;	// xiaoyong.lv 20140523

        $sql = 'SELECT orders_status FROM ' . TABLE_ORDERS . ' WHERE orders_id = "'.$p_orderNormal.'" LIMIT 1';
        $result = mysql_query($sql);
        $orders_status = 0;
        while ($rows = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $orders_status = $rows['orders_status'];
        }
        if(in_array($orders_status , explode(',', MODULE_ORDER_SHIPPED_DELIVERED_STATUS_ID_GROUP ))) return true;
        return false;
    }
    //判断是否是虚拟海外仓运输方式-- By zrs
    public function checkIsVirtualShiiping($p_orderNormal){

        require_once(DIR_WS_CLASSES . 'shipping_virtual.php');
        $virtual_shipping_modules = new shipping_virtual();
        $virtual_shipping_modules->all_virtual_shipping();
        $all_virtual_shipping = $virtual_shipping_modules->get_all_virtual_shipping();
        $sql = 'SELECT shipping_module_code FROM t_orders WHERE orders_id = "'.$p_orderNormal.'" LIMIT 1';
        $result = mysql_query($sql);
        $shipping_module_code = 0;
        while ($rows = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $shipping_module_code = $rows['shipping_module_code'];
        }
        if(isset($all_virtual_shipping[$shipping_module_code])){
            return false;
        }else{
            return true;
        }
    }

    public function checkForEmail() {
        if(! $this->xml){
            $this->writeLog('The xml is null. return false.');
            return $this->success = 0;		//	return
        }

        $this->writeLog('Begin to process checkForEmail.');

//			@include('email/'.$this->lang.'/message.php');
        if(file_exists($this->dir."/erpTemplate/".$this->lang.'/message.php'))
            include($this->dir."/erpTemplate/".$this->lang.'/message.php');
        if($this->lang1 == 6) $firstName = $this->getFirstName();
        else $firstName = $this->fullName;

        $orderNormalAll_bak = $this->orderNormalAll;
        //$hasSpOrder = false;
        $spOrderAll = array();
        foreach($this->orderNormalAll as $i=>$orderNormal){
            if($this->chkHasShippedOrder($orderNormal)){
                unset($this->orderNormalAll[$i]);
            }
            /*Tianwen.Wan20160415->邮件：经过确认和协商后，邮件统一发给客户；此次自动标志发货程序优化的简单说明见附件 日期：20160404
            if(!(stripos($orderNormal, 'sp') === false)){
                $this->hasSpOrder = true;
                $spOrderAll[] = $this->orderNormalAll[$i];
                unset($this->orderNormalAll[$i]);
            }else if(!(strpos($orderNormal, 'S') === false) || !(strpos($orderNormal, 'T') === false)){
                $this->hasSpOrder = true;
                $spOrderAll[] = $this->orderNormalAll[$i];
                unset($this->orderNormalAll[$i]);
            }
            */
        }

        /*Tianwen.Wan20160415->邮件：经过确认和协商后，邮件统一发给客户；此次自动标志发货程序优化的简单说明见附件 日期：20160404
        foreach($this->__orderForShortInfo as $i=>$orderNormal){
            if(!(stripos($orderNormal['orderId'], 'sp') === false)){
                $this->hasSpOrder = true;
                $spOrderAll[] = $orderNormal['orderId'];
                unset($this->__orderForShortInfo[$i]);
            }else if(!(strpos($orderNormal['orderId'], 'S') === false) || !(strpos($orderNormal['orderId'], 'T') === false)){
                $this->hasSpOrder = true;
                $spOrderAll[] = $orderNormal['orderId'];
                unset($this->__orderForShortInfo[$i]);
            }
        }
        */
        $countOrderNormalAll = count($this->orderNormalAll);
        foreach($this->xml->Packages->Package as $package) {
            foreach($package->Details->Item as $item) {
                $orderId = (string)$item->OrderId;
                $this->smarty->assign("isVirtual",$this->checkIsVirtualShiiping($orderId));
            }
        }
        if($this->isSpecialExpress(array('gnkd'), $this->expressAll) && $countOrderNormalAll > 0){
            /**
             * 1. 国内快递
             */
            $this->smarty->assign("firstName", $firstName);
            $this->smarty->assign("orderNormalAll", join(", ", $this->orderNormalAll));
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("isDhls", $this->isDhls);
            $this->smarty->assign("isHmey", $this->isHmey);
            $this->smarty->assign("address", $this->address);
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("isSfhyzxb", $this->isSpecialExpress(array("sfhyzxb","sfhky"), $this->expressAll));
            $this->smarty->assign("shortProductCount", count($this->__shortProductInfo));
            $this->smarty->assign("orderForShortCount", count($this->__orderForShortInfo));
            if(count($this->__shortProductInfo) > 0) {
                $this->smarty->assign("shortProduct", $this->__shortProductList);
            }
            if(count($this->__orderForShortInfo) > 0) {
                $this->smarty->assign("orderForShort", $this->__orderForShortList);
            }
            $this->smarty->assign("seller_name", STORE_NAME);

            if($this->lang == 'russian') $html = $this->smarty->fetch("russian/gnkd.html");
            else $html = $this->smarty->fetch("english/gnkd.html");
            if(count($this->__shortProductInfo) > 0) {
                $this->_saveMailTpl($firstName, sprintf($backorderTitle, join(",", $this->orderNormalAll)), $html, 'gnkd');
            }else{
                $this->_saveMailTpl($firstName, sprintf($orderNormalTitle, join(",", $this->orderNormalAll)), $html, 'gnkd');
            }

        }else if(count($this->traceNumbers) == 0 && $this->isNoTraceNum && $countOrderNormalAll > 0) {
            /**
             * 2. 没有跟踪号的几个运送方式
             */
            $this->smarty->assign("firstName", $firstName);
            $this->smarty->assign("orderNormalAll", join(", ", $this->orderNormalAll));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("address", $this->address);
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("shortProductCount", count($this->__shortProductInfo));
            $this->smarty->assign("orderForShortCount", count($this->__orderForShortInfo));
            if(count($this->__shortProductInfo) > 0) {
                $this->smarty->assign("shortProduct", $this->__shortProductList);
            }
            if(count($this->__orderForShortInfo) > 0) {
                $this->smarty->assign("orderForShort", $this->__orderForShortList);
            }
            $this->smarty->assign("seller_name", STORE_NAME);

            //	属于哪种
            $ishkmail = $this->isSpecialExpress(array('hkmail'), $this->expressAll);	//	香港小包
            $istrstm = $this->isSpecialExpress(array('trstm'), $this->expressAll);		//	中俄物流汽运
            $istrstma = $this->isSpecialExpress(array('trstma','ynkqy'), $this->expressAll);	//	优尼克空运和汽运
            $issfhky  = $this->isSpecialExpress(array('sfhky'), $this->expressAll);	//	优尼客快递
            $issfhyzxb  = $this->isSpecialExpress(array('sfhyzxb'), $this->expressAll);	//	绥芬河邮政小包
            $isjtau  = $this->isSpecialExpress(array('jtau'), $this->expressAll);	//	捷特澳大利亚专线
            $isest  = $this->isSpecialExpress(array('est'), $this->expressAll);	//	俄速通
            $this->smarty->assign('ishkmail', $ishkmail);
            $this->smarty->assign('istrstm', $istrstm);
            $this->smarty->assign('istrstma', $istrstma);
            $this->smarty->assign('issfhky', $issfhky);
            $this->smarty->assign('issfhyzxb', $issfhyzxb);
            $this->smarty->assign('isjtau', $isjtau);
            $this->smarty->assign('isest', $isest);

            if($this->lang == 'russian') $html = $this->smarty->fetch("russian/noTrace.html");
            else $html = $this->smarty->fetch("english/noTrace.html");
            if(count($this->__shortProductInfo) > 0) {
                $this->_saveMailTpl($firstName, sprintf($backorderTitle, join(",", $this->orderNormalAll)), $html, 'noTrace');
            }else{
                $this->_saveMailTpl($firstName, sprintf($traceEmptyTitle, join(",", $this->orderNormalAll)), $html, 'noTrace');
            }

        }else if($countOrderNormalAll > 0 && array_sum($this->getExpressDetail('isTraceModify')) <= 0) {
            /*
            * 3. 正常模板
            */
            $this->smarty->assign("firstName", $firstName);
            $this->smarty->assign("orderNormalAll", join(", ", $this->orderNormalAll));
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("isDhls", $this->isDhls);
            $this->smarty->assign("isHmey", $this->isHmey);
            $this->smarty->assign("address", $this->address);
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("isSfhyzxb", $this->isSpecialExpress(array("sfhyzxb"), $this->expressAll));
            $this->smarty->assign('issfhky', $this->isSpecialExpress(array('sfhky'), $this->expressAll));	//	优尼客快递
            $this->smarty->assign('isjtau', $this->isSpecialExpress(array('jtau'), $this->expressAll));
            $this->smarty->assign("shortProductCount", count($this->__shortProductInfo));
            $this->smarty->assign("orderForShortCount", count($this->__orderForShortInfo));
            if(count($this->__shortProductInfo) > 0) {
                $this->smarty->assign("shortProduct", $this->__shortProductList);
            }
            if(count($this->__orderForShortInfo) > 0) {
                $this->smarty->assign("orderForShort", $this->__orderForShortList);
            }
            $this->smarty->assign("seller_name", STORE_NAME);

            $html = $this->smarty->fetch($this->lang."/normal.html");
            if(count($this->__shortProductInfo) > 0) {
                $this->_saveMailTpl($firstName, sprintf($backorderTitle, join(",", $this->orderNormalAll)), $html, 'normal');
            }else{
                $this->_saveMailTpl($firstName, sprintf($orderNormalTitle, join(",", $this->orderNormalAll)), $html, 'normal');
            }

        }else if(count($orderNormalAll_bak) == 0 && count($this->__orderForShortInfo) > 0) {
            /*
            * 4.缺货补发
            */
            $this->smarty->assign("firstName", $firstName);
            $this->smarty->assign("orderForShort", $this->__orderForShortList);
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("isDhls", $this->isDhls);
            $this->smarty->assign("isHmey", $this->isHmey);
            $this->smarty->assign("address", $this->address);
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("shortProductCount", count($this->__shortProductInfo));
            if(count($this->__shortProductInfo) > 0) {
                $this->smarty->assign("shortProduct", $this->__shortProductList);
            }
            $this->smarty->assign("seller_name", STORE_NAME);

            $html = $this->smarty->fetch($this->lang."/orderForShort.html");
            $this->_saveMailTpl($firstName, $msgOrderForShortTitle, $html, 'orderForShort');
        }else if(count($orderNormalAll_bak) == 0 && array_sum($this->getExpressDetail('isTraceModify')) <= 0 && ! $this->hasSpOrder) {
            /*
            * ?
            */
            $this->smarty->assign("firstName", $firstName);
            $this->smarty->assign("orderNormalAll", '');
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("isDhls", $this->isDhls);
            $this->smarty->assign("isHmey", $this->isHmey);
            $this->smarty->assign("address", $this->address);
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("isSfhyzxb", $this->isSpecialExpress(array("sfhyzxb","sfhky"), $this->expressAll));
            $this->smarty->assign('isjtau', $this->isSpecialExpress(array('jtau'), $this->expressAll));
            $this->smarty->assign("shortProductCount", count($this->__shortProductInfo));
            $this->smarty->assign("orderForShortCount", count($this->__orderForShortInfo));
            if(count($this->__shortProductInfo) > 0) {
                $this->smarty->assign("shortProduct", $this->__shortProductList);
            }
            if(count($this->__orderForShortInfo) > 0) {
                $this->smarty->assign("orderForShort", $this->__orderForShortList);
            }
            $this->smarty->assign("seller_name", STORE_NAME);

            $html = $this->smarty->fetch($this->lang."/normal.html");
            if(count($this->__shortProductInfo) > 0) {
                $this->_saveMailTpl($firstName, sprintf($backorderTitle, ''), $html, 'normal2');
            }else{
                $this->_saveMailTpl($firstName, sprintf($orderNormalTitle, ''), $html, 'normal2');
            }
        }

        if($this->hasSpOrder) {
            /*
            * ?
            */
            $this->smarty->assign("firstName", $firstName);
            $this->smarty->assign("orderNormalAll", $spOrderAll ? join(",", $spOrderAll) : '');
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("isDhls", $this->isDhls);
            $this->smarty->assign("isHmey", $this->isHmey);
            $this->smarty->assign("address", $this->address);
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("isSfhyzxb", $this->isSpecialExpress(array("sfhyzxb","sfhky"), $this->expressAll));
            $this->smarty->assign('isjtau', $this->isSpecialExpress(array('jtau'), $this->expressAll));
            $this->smarty->assign("shortProductCount", count($this->__shortProductInfo));
            $this->smarty->assign("orderForShortCount", count($this->__orderForShortInfo));
            if(count($this->__shortProductInfo) > 0) {
                $this->smarty->assign("shortProduct", $this->__shortProductList);
            }
            if(count($this->__orderForShortInfo) > 0) {
                $this->smarty->assign("orderForShort", $this->__orderForShortList);
            }
            $this->smarty->assign("seller_name", STORE_NAME);

            $html = $this->smarty->fetch($this->lang."/normal.html");
            if(count($this->__shortProductInfo) > 0) {
                $this->_saveMailTpl($firstName, sprintf($backorderTitle, $spOrderAll ? join(",", $spOrderAll) : ''), $html, 'normal2');
            }else{
                $this->_saveMailTpl($firstName, sprintf($orderNormalTitle, $spOrderAll ? join(",", $spOrderAll) : ''), $html, 'normal2');
            }
        }

        /**
         * 5. 修改跟踪号
         */
        if(array_sum($this->getExpressDetail('isTraceModify')) > 0) {
            $this->smarty->assign("firstName", $firstName);
            $orderIds = array();
            foreach($this->xml->Packages->Package as $package) {
                if((string)$package->IsTranceNumModify == '1'){
                    foreach($package->Details->Item as $item) {
                        if ($item->IsReissued == 0) {
                            $orderId = (string)$item->OrderId;
                            if($orderId == '/') continue;
                            $orderIds[$orderId] = $orderId;
                        }
                    }
                }
            }
//				$this->smarty->assign("orderNormalAll", join("<br />", $this->orderNormalAll));
            $this->smarty->assign("orderNormalAll", join(", ", $orderIds));
            $this->smarty->assign("boxCount", array_sum($this->getExpressDetail("boxCount")));
            $this->smarty->assign("expressMethods", join("/", $this->expressMethods));
            $this->smarty->assign("deliveryTime", $this->my_date_long($this->deliveryTime));
            $this->smarty->assign("days", $this->days);
            $this->smarty->assign("traceNumbers", join("<br />", $this->traceNumbers));
            $this->smarty->assign("traceNumbersCount", count($this->traceNumbers));
            $this->smarty->assign("webSite", join(",", $this->webSite));
            $this->smarty->assign("webSiteCount", count($this->webSite));
            $this->smarty->assign("reportAmount", $this->reportAmount);
            $this->smarty->assign("seller_name", STORE_NAME);

            $html = $this->smarty->fetch($this->lang."/traceModify.html");
            $this->_saveMailTpl($firstName, sprintf($traceNumModifyTitle, join(",", $orderIds)), $html, 'traceModify');
        }

        //	修改订单跟踪号，xiaoyong.lv 20140507
        if(! $html) $html = '';
        $this->_updateShipNum($html);
        return $this->success = 1;

        $this->writeLog('End of process checkForEmail.');
    }

    /**
     * save email template as file and write to db
     * @param	string		email to name
     * @param	string		email subject
     * @param	string		email text
     * @param	string		type
     * @return	bool
     */
    private function _saveMailTpl($toname='', $subject='', &$content='', $type=''){
        global $isTest, $toTest, $toSaleArray;

        if($content == '') return false;

        $dt = date("Ym");
        $fileName = $dt."/".$this->email.'_'.$type.'_'.$this->randNum.'.html';
        $fileDir = $this->dir."/email_orig/".$dt;
        if(! is_dir($fileDir)) mkdir($fileDir);
        $file = $this->dir."/email_orig/".$fileName;
        if(file_exists($file)) unlink($file);
        file_put_contents($file, $content);

        if($isTest == 1) $to = $toTest;
        else if($isTest == 2) $to = $toSaleArray[$this->lang1];
        else{
            if($type == 'normal2') $to = $this->__toSelf;
            else $to = $this->email;
        }
        if($to == '' || preg_match('/^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/',$to) <= 0) return false;
        $sql = "INSERT INTO t_email_erp (email_to, email_toname, email_subject, email_file, email_added) VALUES ('".$to."', '".$toname."', '".$subject."', '".$fileName."', now())";
        mysql_query($sql);

        $this->writeLog('Save email template to file: '.$fileName);

        return true;
    }

    /**
     * update order track num
     * return void
     */
    private function _updateShipNum(&$p_html){
        foreach($this->xml->Packages->Package as $package) {
            $shipNums = $orderIds = $shippingNumArray = array();
            $shipDeliveryTime = (string)$package->DeliveryTime;
            foreach($package->TranceNumbers->TranceNumber as $traceNumber) {
                $traceNumber = (string)trim($traceNumber);
                if ($traceNumber) {
                    $shipNums[] = $traceNumber;
                    $shippingNumArray[] = array('shipping_num' => $traceNumber, 'shipping_datetime' => $shipDeliveryTime);
                }
            }
            foreach($package->Details->Item as $item) {
//					if ($item->IsReissued == 0) {
                $orderId = (string)$item->OrderId;
                if($orderId == '/') continue;
                if($this->chkHasShippedOrder($orderId)) continue;
                //Tianwen.Wan20160411->如果不是发送给自己，修改跟踪号时不要拼接T订单进去
                //if($this->email != $this->__toSelf && (!(strpos($orderId, 'S') === false) || !(strpos($orderId, 'T') === false))) {
                //	continue;
                //}
                $orderIds[$orderId] = $orderId;
//					}
            }

//				if(count($shipNums) == 0 || count($orderIds) == 0) continue;
            if(count($orderIds) == 0) continue;

            $p1 = join(',', $shipNums);
            $p2 = '';
            $html = str_replace('"', '\"', $p_html);
            foreach($orderIds as $v){
                $check_order_have_shipped_sql = 'SELECT orders_status_history_id FROM ' . TABLE_ORDERS_STATUS_HISTORY . ' WHERE orders_id = "' . $v . '" AND orders_status_id = 3';
                $check_order_have_shipped_query = mysql_query($check_order_have_shipped_sql);
                if(mysql_num_rows($check_order_have_shipped_query)){
                    $order_status = 4;
                }else{
                    $order_status = 3;
                }
                $sql = 'insert into ' . TABLE_ORDERS_STATUS_HISTORY . ' (orders_id,orders_status_id,date_added,customer_notified,comments) values ("'.$v.'", ' . $order_status . ', now(), 1, "'.$html.'")';
                mysql_query($sql);

                $shippingNumJson = "";
                $shippingNumJson = addslashes(json_encode($shippingNumArray));
                if($package->IsTranceNumModify > 0){
                    $sql = 'update ' . TABLE_ORDERS . ' set shipping_num = "'.$p1.'", shipping_num_json = "'.$shippingNumJson.'", orders_status= ' . $order_status . ' where orders_id = "' . $v . '"';
                }else{
                    $shippingNumSql = 'select orders_id, shipping_num_json from ' . TABLE_ORDERS . ' where orders_id = ' . $v;
                    $shippingNumResult = mysql_query($shippingNumSql);
                    $shippingNumInfo = mysql_fetch_array($shippingNumResult, MYSQL_ASSOC);
                    if(!empty($shippingNumInfo['shipping_num_json'])) {
                        $shippingNumArrayOld = json_decode($shippingNumInfo['shipping_num_json'], true);
                        $shippingNumArrayNew = array_merge($shippingNumArrayOld, $shippingNumArray);
                        $shippingNumJson = addslashes(json_encode($shippingNumArrayNew));
                    }
                    $sql = 'update ' . TABLE_ORDERS . ' set shipping_num = concat_ws(",", shipping_num, "'.$p1.'"), shipping_num_json = "'.$shippingNumJson.'", orders_status= ' . $order_status . ' where orders_id = "' . $v . '"';
                }
                mysql_query($sql);
            }

            if(sizeof($this->__packageInfo) > 0){
                $action = 'insert';
                $customers_id = $this->__packageInfo['customers_id'];
                $customers_email = $this->__packageInfo['customers_email_address'];

                foreach ($this->__packageInfo['packages_info'] as $packages_info){
                    $package_id = $packages_info['package_id'];
                    $trace_num = ',' . implode(',', $packages_info['traceNumber']) . ',';
                    $delivery_date = $packages_info['delivery_date'];
                    if($package_id){
                        $check_package_info_is_upload_query = mysql_query('select zop_id from ' . TABLE_ORDERS_PACKING_SLIP . ' where package_id = "' . $package_id . '"');
                        if(mysql_num_rows($check_package_info_is_upload_query) > 0){
                            $action = 'update';
                        }

                        foreach ($packages_info['products_info'] as $prducts_info){
                            $orders_id = $prducts_info['orders_id'];
                            if(!isset($orders_id) || $orders_id == 0 || $orders_id == ''){
                                break;
                            }
                            $products_model = $prducts_info['products_model'];
                            $products_quantity = $prducts_info['products_quantity'];

                            if($action == 'insert'){
                                $sql = 'INSERT INTO ' . TABLE_ORDERS_PACKING_SLIP . ' (orders_id , customers_id , customers_email, trance_number , package_id ,products_model , products_quantity , delivery_date) VALUES ("' . $orders_id . '" , "' . $customers_id . '" , "' . $customers_email . '" , "' . $trace_num . '", "' . $package_id . '" , "' . $products_model . '", "' . $products_quantity . '", "' . $delivery_date .'")';
                            }else{
                                $sql = 'update ' . TABLE_ORDERS_PACKING_SLIP . ' SET  trance_number = "' . $trace_num . '" , delivery_date = "' . $delivery_date .  '" WHERE package_id = "' . $package_id . '" and products_model = "' . $products_model . '" and orders_id = "' . $orders_id . '"';
                            }
                            mysql_query($sql);
                        }
                    }

                }
            }


            $this->writeLog('Update shipping no.: '.$sql);
        }

        return;
    }

    /*
     * 订单状态变更
     */
    public function orders_status_update() {
        $orders_id = zen_db_input(trim($this->xml->BusinessId));
        $orders_status = zen_db_input(trim($this->xml->BusinessDatas->Status));
        $orders_delivered_datetime = zen_db_input(trim($this->xml->BusinessTime));

        $check_order_sql = 'select orders_id , orders_status , customers_name , customers_email_address , language_id from ' . TABLE_ORDERS . ' where orders_id = ' . $orders_id . ' limit 1';
        $check_order_result = mysql_query($check_order_sql);
        $check_num = mysql_num_rows($check_order_result);

        if($check_num > 0){
            $orders_info = mysql_fetch_array($check_order_result,MYSQL_ASSOC);
            $customers_name = $orders_info['customers_name'];
            $this->email = $orders_info['customers_email_address'];
            $language_id = $orders_info['language_id'];
            $lang_arr = $this->language((string)$this->email, $this->$language_id);
            $this->lang = $lang_arr[0];
            $this->lang1 = $lang_arr[1];

            $update_sql = 'update ' . TABLE_ORDERS . ' SET orders_status = ' . $orders_status . ' , last_modified = "' . $orders_delivered_datetime . '" where orders_id = ' . $orders_id;
            mysql_query($update_sql);

            $this->smarty->assign('customers_name' , $customers_name);
            $this->smarty->assign('orders_id' , $orders_id);

            $html = $this->smarty->fetch($this->lang."/delivered.html");
            $this->_saveMailTpl($customers_name , $this->email_subject[$orders_id][$this->lang1], $html, 'delivered');

            $html = str_replace('"', '\"', $html);
            $insert_order_history_sql = 'insert into ' . TABLE_ORDERS_STATUS_HISTORY . ' (orders_id,orders_status_id,date_added,customer_notified,comments) values ("' . $orders_id . '", ' . $orders_status . ', "' . $orders_delivered_datetime . '" , 1, "' . $html . '")';;
            mysql_query($insert_order_history_sql);

            $insert_delived_sql = 'insert into ' . TABLE_ORDERS_PACKAGE_CONFIRMED_DELIVERED . ' ( orders_id , package_status , date_delivered_system , date_created) values ( "' . $orders_id . '" , 20 , "' . $orders_delivered_datetime . '" , now())';
            mysql_query($insert_delived_sql);
        }else{
            return 0;
        }

        write_file("log/orders_status_update/", "orders_status_update_" . date("Ymd") . ".txt", var_export($this->xml, true));
        return $this->success = 1;
    }

    /**
     * write to log file
     * @return null
     */
    protected function writeLog($p_str=''){
        $logFile = $this->dir.'/log/function-'.date("Ym").".log";
        error_log(date("Y-m-d H:i:s")." : ".$p_str."\n", 3, $logFile);
    }

}
?>