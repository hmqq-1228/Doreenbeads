<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: invoice.php 6251 2007-04-22 19:21:48Z wilt $
//

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  $customers_id = (int)$_GET['cID'];
  $oID = (int)$_GET['oID'];
  include(DIR_WS_LANGUAGES . $_SESSION['language'].'/invoice.php');
  
  if (!zen_not_null($oID) || !zen_not_null($customers_id)) {
  	echo TEXT_CAN_NOT_SEE; exit;
  }
  
  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);

if (isset($_GET['action']) && $_GET['action'] == 'download'){
    if (zen_not_null($oID)){
      $store_address = split('<br />', nl2br(STORE_NAME_ADDRESS));
      $store_address_part1 = trim($store_address[0]);
      $store_address_part2 = trim($store_address[1]);
    if($_SESSION['customer_id'] == 168493){
      $billing_address =  'Nina Heyd <br>Vain Luxuries<br>Ehrengutstr. 4<br>80469 München<br>';
    }else{
        $billing_address = zen_address_format($order->customer['format_id'], $order->billing, 1, '', '<br>');
    }
      $delivery_address = zen_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>');
      
      $billing_address_array = split('<br>', $billing_address);
      $billing_address_size = count($billing_address_array);
      $delivery_address_array = split('<br>', $delivery_address);
      $delivery_address_size = count($delivery_address_array);
      
      require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel = PHPExcel_IOFactory::load(DIR_FS_CATALOG ."file/invoice_template_admin.xls");
    $objPHPExcel->setActiveSheetIndex(0);
    
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setWrapText(true);
//    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Verdana');
//    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
//    foreach ($objPHPExcel->getActiveSheet()->getMergeCells() as $keys => $vals){
//      if ($vals != 'A1:E1' && $vals != 'A4:B4' && $vals != 'A13:G13' && $vals != 'A14:G14' && $vals != 'A18:G18'){
//        $objPHPExcel->getActiveSheet()->unmergeCells($vals);
//      }     
//    }
    
    $objPHPExcel->getActiveSheet()->setCellValue('A1', TEXT_INVOICE);
    //$objPHPExcel->getActiveSheet()->setCellValue('A2', $store_address_part1);
    //$objPHPExcel->getActiveSheet()->setCellValue('A3', $store_address_part2);
    //$objPHPExcel->getActiveSheet()->setCellValue('A5', ENTRY_SOLD_TO);
    $objPHPExcel->getActiveSheet()->setCellValue('B5', ENTRY_SHIP_TO);
    
      $addr_X_coordinate = ($billing_address_size > $delivery_address_size ? $billing_address_size + 6 : $delivery_address_size + 6);
    if ($addr_X_coordinate > 10){
      $objPHPExcel->getActiveSheet()->insertNewRowBefore(10, ($addr_X_coordinate - 10));
    }else{
      $objPHPExcel->getActiveSheet()->removeRow(10, (10 - $addr_X_coordinate));
    }
    
    for ($i = 0; $i < $billing_address_size; $i++){
      $objPHPExcel->getActiveSheet()->setCellValue('A' . (6 + $i), $billing_address_array[$i]);
    }

      for ($i = 0; $i < $delivery_address_size; $i++){
      $objPHPExcel->getActiveSheet()->setCellValue('B' . (6 + $i), $delivery_address_array[$i]);
    }
    
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($addr_X_coordinate + 1), 'Telephone Number: ' . $order->customer['telephone']);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($addr_X_coordinate + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getRowDimension('A' . ($addr_X_coordinate + 2))->setRowHeight(30);
    
    $invoice_number_X_coordinate = $addr_X_coordinate + 5;
    
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $invoice_number_X_coordinate, ENTRY_ORDER_ID . $oID);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($invoice_number_X_coordinate + 1), ENTRY_DATE_PURCHASED);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . ($invoice_number_X_coordinate + 1), zen_date_long($order->info['date_purchased']));    
    
    $payment = preg_replace('/(<a.*>.*<\/a>)|&nbsp;/i', '', $order->info['payment_method']);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($invoice_number_X_coordinate + 2), ENTRY_PAYMENT_METHOD);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . ($invoice_number_X_coordinate + 2), strip_tags($payment));
    
    $objPHPExcel->getActiveSheet()->getStyle('A' . $invoice_number_X_coordinate)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($invoice_number_X_coordinate + 1) . ':A' . ($invoice_number_X_coordinate + 2))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getRowDimension('A' . ($invoice_number_X_coordinate + 2))->setRowHeight(35);
    
    //bof products area
    $products_X_coordinate = $invoice_number_X_coordinate + 4;
    
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $products_X_coordinate, TEXT_PRODUCTS);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $products_X_coordinate, TABLE_HEADING_PRODUCTS_MODEL);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $products_X_coordinate, TABLE_HEADING_PRICE_EXCLUDING_TAX);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $products_X_coordinate, TABLE_HEADING_TOTAL_EXCLUDING_TAX);    
    
      if (sizeof($order->products) > 4){
      $objPHPExcel->getActiveSheet()->insertNewRowBefore(($products_X_coordinate + 1), (sizeof($order->products) - 4));
    }else{
      $objPHPExcel->getActiveSheet()->removeRow(($products_X_coordinate + 1), (4 - sizeof($order->products)));
    }
    
    for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
      $qty = $order->products[$i]['qty'];
      $name = $order->products[$i]['name'];
      if($order->products[$i]['customized_id'] > 0) {
        $name .= "\n" . TEXT_CUSTOMIZED_PRODUCTS;
      }
      $model = $order->products[$i]['model'];
      $product_each_price = $currencies->format_cl ( zen_add_tax ( $order->products[$i] ['final_price'], zen_get_tax_rate ( $order->products[$i] ['tax'] ) ),true, $order->info['currency'], $order->info['currency_value'] );
      $price = str_replace('&euro;','€',$currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']));
      $total = str_replace('&euro;','€',$currencies->format(zen_add_tax($product_each_price, $order->products[$i]['tax']) * $order->products[$i]['qty'], false, $order->info['currency'], $order->info['currency_value']));     
      
      $objPHPExcel->getActiveSheet()->setCellValue('A' . ($products_X_coordinate + $i), $qty . 'x');
      $objPHPExcel->getActiveSheet()->setCellValue('B' . ($products_X_coordinate + $i), $name);
      $objPHPExcel->getActiveSheet()->setCellValue('C' . ($products_X_coordinate + $i), $model);
      $objPHPExcel->getActiveSheet()->setCellValue('D' . ($products_X_coordinate + $i), $price);
      $objPHPExcel->getActiveSheet()->setCellValue('E' . ($products_X_coordinate + $i), $total);
      
      $objPHPExcel->getActiveSheet()->getRowDimension($products_X_coordinate + $i)->setRowHeight(50);
    }
    
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($products_X_coordinate) . ':A' . ($products_X_coordinate + sizeof($order->products)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('D' . ($products_X_coordinate) . ':E' . ($products_X_coordinate +  sizeof($order->products)))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $products_X_coordinate . ':E' . ($products_X_coordinate + sizeof($order->products)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($products_X_coordinate) . ':E' . ($products_X_coordinate + sizeof($order->products)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $products_X_coordinate . ':C' . ($products_X_coordinate + sizeof($order->products)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //eof products area
    
    //bof subtotal area
    $subtotal_X_coordinate = $products_X_coordinate + $n;
      for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
        $order->totals[$i]['title'] = preg_replace('/(&nbsp;|\[\?\])/i', '', strip_tags($order->totals[$i]['title']));
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($subtotal_X_coordinate + $i) . ':D' . ($subtotal_X_coordinate + $i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($subtotal_X_coordinate + $i), strip_tags($order->totals[$i]['title']));
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($subtotal_X_coordinate + $i), strip_tags(str_replace('&euro;','€',$order->totals[$i]['text'])));
        if (preg_match('/(total[^\s]|promotion)/i', $order->totals[$i]['title'])){
          $objPHPExcel->getActiveSheet()->getStyle('B' . ($subtotal_X_coordinate + $i))->getFont()->setBold(true);
        }else {
          $objPHPExcel->getActiveSheet()->getStyle('B' . ($subtotal_X_coordinate + $i))->getFont()->setBold(false);
        }
        $objPHPExcel->getActiveSheet()->getRowDimension($subtotal_X_coordinate + $i)->setRowHeight(25);
      }
      
      $objPHPExcel->getActiveSheet()->getStyle('B' . $subtotal_X_coordinate . ':E' . ($subtotal_X_coordinate + sizeof($order->totals) - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      
      //eof subtotal area
      
    $objPHPExcel->getActiveSheet()->getStyle('A' . $addr_X_coordinate . ':G' . ($subtotal_X_coordinate + sizeof($order->totals) - 1))->getFont()->setName('Verdana');
    $objPHPExcel->getActiveSheet()->getStyle('A' . $addr_X_coordinate . ':G' . ($subtotal_X_coordinate + sizeof($order->totals) - 1))->getFont()->setSize(12);
      
      $filename = TEXT_DOWNLOAD_INVOICE_FILENAME . '_' . $oID . '.xls';
      header ( "Content-type: application/vnd.ms-excel; charset=UTF-8" );
      if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) { 
        header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');
      }else{
         header('Content-Disposition: attachment; filename=' . $filename);
       }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
       $objWriter->save ($filename);
       readfile($filename);
       unlink($filename);
       die();
    }
  }

if (isset($_GET['action']) && $_GET['action'] == 'downloadPDF'){
    if (zen_not_null($oID)){

      if($_SESSION['customer_id'] == 168493){
        $billing_address =  'Nina Heyd <br>Vain Luxuries<br>Ehrengutstr. 4<br>80469 München<br>';
      }else{
          $billing_address = zen_address_format($order->customer['format_id'], $order->billing, 1, '', '<br>');
      }
        $delivery_address = zen_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>');
        
        $orders_language = 1;
        $language_query = $db->Execute('SELECT language_id FROM '.TABLE_ORDERS.' WHERE orders_id = ' .$oID .' LIMIT 1');
        if ($language_query->RecordCount()>0) {
          $orders_language = $language_query->fields['language_id'];
        }
        
        $billing_address_array = split('<br>', $billing_address);
        $billing_address_size = count($billing_address_array);
        $delivery_address_array = split('<br>', $delivery_address);
        $delivery_address_size = count($delivery_address_array);

        require_once(DIR_FS_CATALOG  . DIR_WS_CLASSES . 'class.tcpdf.php');

        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        class TOC_TCPDF extends TCPDF {

        /**
         * Overwrite Header() method.
         * @public
         */
        public function Header() {
          if ($this->tocpage) {
            // *** replace the following parent::Header() with your code for TOC page
            parent::Header();
          } else {
            // *** replace the following parent::Header() with your code for normal pages
            $headerdata = $this->getHeaderData();
            $headerfont = $this->getHeaderFont();
            //$this->Image('images/logo_invoice.jpg', '155', '6', 40, 10);
            $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
            $this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
            $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
            $this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
            $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
            $this->SetY((2.835 / $this->k) + max($imgy, $this->y));
            if ($this->rtl) {
              $this->SetX($this->original_rMargin);
            } else {
              $this->SetX($this->original_lMargin);
            }
            $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
          }
        }
      } // end of class

      // create new PDF document
      $pdf = new TOC_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        // set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor(PDF_AUTHOR);
      $pdf->SetTitle(PDF_HEADER_TITLE);
      $pdf->SetSubject('Doreenbeads Invoice');
      //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

      // set default header data
      //$pdf->SetHeaderData('', '', 'Doreenbeads '.TEXT_INVOICE, PDF_HEADER_STRING);

      // set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // add a page
      $pdf->AddPage();

      // set cell padding
      $pdf->setCellPaddings(1, 1, 1, 1);

      // set cell margins
      $pdf->setCellMargins(1, 1, 1, 1);

      // set color for background
      $pdf->SetFillColor(255, 255, 255);

      if ($orders_language == 3 || $orders_language == 6 ) {
        $font = 'stsongstdlight';
      }else{
        $font = PDF_FONT_NAME_MAIN;
      }
      $pdf->SetFont($font, '', 10);

      // Multicell test
      $pdf->MultiCell(100, 5, ENTRY_SOLD_TO ."<br/>". $billing_address, 0, 'L', 1, 0, '', '', true, 0, true);
      $pdf->MultiCell(55, 5, ENTRY_SHIP_TO . "<br/>" .$delivery_address, 0, '', 0, 1, '', '', true, 0, true);

      $pdf->Ln(4);

      // Vertical alignment
      $pdf->MultiCell(180, 5, 'Telephone Number: ' . $order->customer['telephone']."\n");

      $pdf->Ln(4);

      $payment = preg_replace('/(<a.*>.*<\/a>)|&nbsp;/i', '', $order->info['payment_method']);
      $text_pay = '<b>'.ENTRY_ORDER_ID . $oID."<br/>".ENTRY_DATE_PURCHASED .'</b>'. zen_date_long($order->info['date_purchased']) . "<br/><b>" . ENTRY_PAYMENT_METHOD . strip_tags($payment).'</b>';

      $pdf->MultiCell(180, 15, $text_pay, 0, 'J', 1, 1, '', '', true, 0, true);

      $pdf->Ln(4);

      $products_table = '<table border="0" width="100%" cellspacing="0" cellpadding="2" style="font-size:11px;">';

      $products_table .= '<tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" colspan="2" width="50%"><b>'.TABLE_HEADING_PRODUCTS.'</b></td>
                <td class="dataTableHeadingContent" align="right" width="15%"><b>'.TABLE_HEADING_PRODUCTS_MODEL.'</b></td>
                <td class="dataTableHeadingContent" align="right" width="10%"><b>'.TABLE_HEADING_WEIGHT.'</b></td>
                <td class="dataTableHeadingContent" align="right" width="10%"><b>'.TABLE_HEADING_PRICE_INCLUDING_TAX.'</b></td>
                <td class="dataTableHeadingContent" align="right" width="10%"><b>'.TABLE_HEADING_TOTAL_INCLUDING_TAX.'</b></td>
              </tr>';

        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
            $products_table .= '<tr class="dataTableRow">
              <td colspan="2" class="dataTableContent" valign="top">' . $order->products[$i]['qty'] .'&nbsp;x&nbsp;&nbsp;'. $order->products[$i]['name'];

            if($order->products[$i]['customized_id'] > 0) {
              $products_table .= "<br/><font color='red'>" . TEXT_CUSTOMIZED_PRODUCTS . "</font>";
            }
            if (isset($order->products[$i]['attributes']) && (($k = sizeof($order->products[$i]['attributes'])) > 0)) {
              for ($j = 0; $j < $k; $j++) {
                  $products_table .= '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value']));
                  if ($order->products[$i]['attributes'][$j]['price'] != '0') $products_table .= ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
                  if ($order->products[$i]['attributes'][$j]['product_attribute_is_free'] == '1' and $order->products[$i]['product_is_free'] == '1') $products_table .= TEXT_INFO_ATTRIBUTE_FREE;
                  $products_table .= '</i></small></nobr>';
              }
            }

            $products_table .= '</td>
                <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['model'] . '</td>';
          $product_each_price = $currencies->format_cl ( zen_add_tax ( $order->products[$i] ['final_price'], zen_get_tax_rate ( $order->products[$i] ['tax'] ) ),true, $order->info['currency'], $order->info['currency_value'] );
            $products_table .= '<td class="dataTableContent" valign="top" align ="right">' . $order->products[$i]['weight'] . '</td>
                <td class="dataTableContent" align="right" valign="top"><b>' .$currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</b></td>
                        <td class="dataTableContent" align="right" valign="top"><b>' .
                          $currencies->format(zen_add_tax($product_each_price, $order->products[$i]['tax']) * $order->products[$i]['qty'], false, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</b></td>';
            $products_table .= '</tr>';
        }

      $products_table .= '<tr><td width="35%"></td><td align="right" width="30%"><table style="font-size:11px;" border="0" cellspacing="0" cellpadding="2">';

        for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
          $order->totals[$i]['title'] = preg_replace('/\[\?\]/i', '<span class="noPrint">[?]</span>', $order->totals[$i]['title']);
          $products_table .= '<tr>
                    <td width="65%" align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text"><b>' . $order->totals[$i]['title'] . '</b></td>
                    <td width="35%" align="left" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '</td>
                  </tr>';
        }

          
          $products_table .= '</table></td><td align="right" width="35%"><table style="font-size:11px;"  border="0" cellspacing="0" cellpadding="2">';

        for ($i = 0, $n = sizeof($order->weight_total); $i < $n; $i++) {
          $products_table .= '<tr>
                    <td width="60%" align="right" >' . $order->weight_total[$i]['title'] . '</td>
                    <td width="40%" align="left" >' . $order->weight_total[$i]['text'] . '</td>
                  </tr>';
        }

          $products_table .= '</table></td></tr></table>';

          $pdf->writeHTML($products_table, true, false, true, false, '');

      $pdf->Ln(2);

      // move pointer to last page
      $pdf->lastPage();

      // ---------------------------------------------------------

      //Close and output PDF document
      //$pdf->Output('example_005.pdf', 'I');

        $filename = TEXT_DOWNLOAD_INVOICE_FILENAME . '_' . $oID . '.pdf';
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment;filename=".$filename);
        header('Cache-Control: max-age=0');
        echo $pdf->output($filename, 'S');
    }
}

  // prepare order-status pulldown list
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status = $db->Execute("select orders_status_id, orders_status_name
                                 from " . TABLE_ORDERS_STATUS . "
                                 where language_id = '" . (int)$_SESSION['languages_id'] . "'");
  while (!$orders_status->EOF) {
    $orders_statuses[] = array('id' => $orders_status->fields['orders_status_id'],
                               'text' => $orders_status->fields['orders_status_name'] . ' [' . $orders_status->fields['orders_status_id'] . ']');
    $orders_status_array[$orders_status->fields['orders_status_id']] = $orders_status->fields['orders_status_name'];
    $orders_status->MoveNext();
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" type="text/javascript"><!--
function couponpopupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">

<!-- body_text //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">

<?php
      $order_check = $db->Execute("select cc_cvv, customers_name, customers_company, customers_street_address,
                                    customers_suburb, customers_city, customers_postcode,
                                    customers_state, customers_country, customers_telephone,
                                    customers_email_address, customers_address_format_id, delivery_name,
                                    delivery_company, delivery_street_address, delivery_suburb,
                                    delivery_city, delivery_postcode, delivery_state, delivery_country,
                                    delivery_address_format_id, billing_name, billing_company,
                                    billing_street_address, billing_suburb, billing_city, billing_postcode,
                                    billing_state, billing_country, billing_address_format_id,
                                    payment_method, cc_type, cc_owner, cc_number, cc_expires, currency,
                                    currency_value, date_purchased, orders_status, last_modified
                             from " . TABLE_ORDERS . "
                             where orders_id = '" . (int)$oID . "'");
  $show_customer = 'false';
  if ($order_check->fields['billing_name'] != $order_check->fields['delivery_name']) {
    $show_customer = 'true';
  }
  if ($order_check->fields['billing_street_address'] != $order_check->fields['delivery_street_address']) {
    $show_customer = 'true';
  }
  if ($show_customer == 'true') {
?>
      <tr>
        <td class="main"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
      </tr>
      <tr>
        <td class="main"><?php echo zen_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>'); ?></td>
      </tr>
<?php } ?>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_SOLD_TO; ?></b></td>
          </tr>
          <tr>
            <td class="main"><?php echo zen_address_format($order->customer['format_id'], $order->billing, 1, '', '<br>'); ?></td>
          </tr>
          <tr>
            <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
          </tr>
          <tr>
            <td class="main">Telephone Number: <?php echo $order->customer['telephone']; ?></td>
          </tr>
        </table></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_SHIP_TO; ?></b></td>
          </tr>
          <tr>
            <td class="main"><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>'); ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
    <td class="main"><b><?php echo ENTRY_ORDER_ID . $oID; ?></b></td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main"><strong><?php echo ENTRY_DATE_PURCHASED; ?></strong></td>
        <td class="main"><?php echo zen_date_long($order->info['date_purchased']); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
        <td class="main"><?php echo $order->info['payment_method']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
        <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_WEIGHT; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
      </tr>
<?php
    for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
      echo '      <tr class="dataTableRow">' . "\n" .
           '        <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '        <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];

      if (isset($order->products[$i]['attributes']) && (($k = sizeof($order->products[$i]['attributes'])) > 0)) {
        for ($j = 0; $j < $k; $j++) {
          echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value']));
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          if ($order->products[$i]['attributes'][$j]['product_attribute_is_free'] == '1' and $order->products[$i]['product_is_free'] == '1') echo TEXT_INFO_ATTRIBUTE_FREE;
          echo '</i></small></nobr>';
        }
      }

      echo '        </td>' . "\n" .
           '        <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n";
      $product_each_price = $currencies->format_cl ( zen_add_tax ( $order->products[$i] ['final_price'], zen_get_tax_rate ( $order->products[$i] ['tax'] ) ),true, $order->info['currency'], $order->info['currency_value'] );
      echo '        <td class="dataTableContent" align="right" valign="top">' . zen_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '        <td class="dataTableContent" align ="right">' . $order->products[$i]['weight'] * $order->products[$i]['qty']. '</td>' . "\n".
      	   '        <td class="dataTableContent" align="right" valign="top"><b>' .
                      $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) .
                      ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format($order->products[$i]['onetime_charges'], true, $order->info['currency'], $order->info['currency_value']) : '') .
                    '</b></td>' . "\n" .
           
           '        <td class="dataTableContent" align="right" valign="top"><b>' .
                      $currencies->format(zen_add_tax($product_each_price, $order->products[$i]['tax']) * $order->products[$i]['qty'], false, $order->info['currency'], $order->info['currency_value']) .
                      ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format($order->products[$i]['onetime_charges'], true, $order->info['currency'], $order->info['currency_value']) : '') .
                    '</b></td>' . "\n" ;
      echo '      </tr>' . "\n";
    }
?>
      <tr>
        <td align="right" colspan="5"><table border="0" cellspacing="0" cellpadding="2">
<?php
  for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
    echo '          <tr>' . "\n" .
         '            <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title'] . '</td>' . "\n" ;
	if ($order->totals[$i]['class'] == 'ot_total' && $i < sizeof($order->totals) -1){
		$order->info['currency'] == 'USD' ? $ordertatal = '' :$ordertatal = '(us$ '.number_format($order->info['total'],2,'.',',').')';
		echo '<td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '<br>'.$ordertatal.'</td></tr>' . "\n";
	}else{
      echo    '            <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '</td>' . "\n" ;
	}
     echo    '          </tr>' . "\n";
  }
?>
        </table></td>
        <td colspan="4">
        <table border="0" cellspacing="0" cellpadding="2">
<?php
  for ($i = 0, $n = sizeof($order->weight_total); $i < $n; $i++) {
    echo '          <tr>' . "\n" .
         '            <td align="right" >' . $order->weight_total[$i]['title'] . '</td>' . "\n" .
         '            <td align="right" >' . $order->weight_total[$i]['text'] . '</td>' . "\n" .
         '          </tr>' . "\n";
  }
?>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>  <tr class="noPrint">
      <td align="right">
        <input type="button" value="<?php echo TEXT_DOWNLOAD_INVOICE_PDF; ?>" style="color:#00f; font-weight:bold; text-decoration:none;cursor:pointer;" onclick="window.location.href='invoice.php?action=downloadPDF&oID=<?php echo $oID;?>&cID=<?php echo $customers_id?>'" />
      </td>
    </tr>
    <tr class="noPrint">
      <td align="right">
        <input type="button" value="<?php echo TEXT_DOWNLOAD_INVOICE;?>" style="color:#00f; font-weight:bold; text-decoration:none;cursor:pointer;" onclick="window.location.href='invoice.php?action=download&oID=<?php echo $oID;?>&cID=<?php echo $customers_id?>'" />
      </td>
    </tr>
    <tr class="noPrint">
      <td align="right">
        <input id="btnPrint" type="button" value="<?php echo 'Print';?>" onclick="javascript:window.print();" style="color:#00f; font-weight:bold; text-decoration:none;cursor:pointer!important;" />
      </td>
    </tr>
</table>
<!-- body_text_eof //-->

<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
