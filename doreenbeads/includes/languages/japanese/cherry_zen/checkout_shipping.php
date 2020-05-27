<?php

/**

 * @package languageDefines

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: checkout_shipping.php 4042 2006-07-30 23:05:39Z drbyte $

 */
define ( 'NAVBAR_TITLE_1', 'チェックアウト' );

define ( 'NAVBAR_TITLE_2', '運送方法' );

define ( 'HEADING_TITLE', '3のステップ1 - 配達情報' );

define ( 'TABLE_HEADING_SHIPPING_ADDRESS', '配送先' );
// jessa 2010-02-09 修改常量
define ( 'TEXT_CHOOSE_SHIPPING_DESTINATION', '小包を出荷したい正しいアドレスを選んでください。<br />ご希望のアドレスがここにリストされていない場合、"<strong><I>別のアドレスを追加　</I></strong>" ボタンをクリックして新しいアドレスを追加します。 またはリストされたアドレスを編集します。 または "<strong><I>アドレス帳の管理</I></strong>" をクリックしてほかの変更をします。' );

define ( 'TEXT_CHOOSE_SHIPPING_DESTINATION_1', '小包を出荷したい正しいアドレスを選んでください。<br /> ご希望のアドレスがここにリストされていない場合、 リストされたアドレスを<strong><I>編集</I></strong> し、 または "<strong><I>アドレス帳の管理</I></strong>" をクリックしてほかの変更をします' );
// eof jessa 2010-02-09

define ( 'TITLE_SHIPPING_ADDRESS', '配送先情報：' );

// jessa 2010-02-09 在没有选择地址是的提示信息
define ( 'TEXT_CHOOSE_SHIPPING_ADDRESS', 'この注文で使用する優先な配送先を選んでください。' );
// eof jessa 2010-02-09

define ( 'TABLE_HEADING_SHIPPING_METHOD', '配送方法：' );

define ( 'TEXT_CHOOSE_SHIPPING_METHOD', 'この注文で使用する優先な配送先を選んでください。' );

define ( 'TEXT_ABOUT_CPF_OR_CNPJ', '<h2 style="color:red" >CPFまたはCNPJについて：</h2> 我々の経験によると、包みの上でCPFまたはCNPJですっきりさせることは、包み（ブラジルに送られる）が非常に通関しやすいです。よろしければ、CPFやCNPJ番号を電子メールまたはメッセージで我々に送信します。我々は小包に添付します。' );

// define('TEXT_CHOOSE_SHIPPING_METHOD', 'Please select the preferred shipping method to use on this order.');

define ( 'TITLE_PLEASE_SELECT', 'お選びください' );

define ( 'TEXT_ENTER_SHIPPING_INFORMATION', 'これは現在の注文で使用できるの唯一の運送式です。' );

define ( 'TITLE_NO_SHIPPING_AVAILABLE', 'この時点には使用できません。' );

define ( 'TEXT_NO_SHIPPING_AVAILABLE', '<span class="alert">申し訳ございませんが、この時点でお住まいの地域に出荷できません。</span><br />ほかのアレンジメントについては、お問い合わせください。' );

// define('TABLE_HEADING_COMMENTS', 'If you have Special Instructions for custom tax or other comments,<br />please let us know, we will do it as you told us');
define ( 'TABLE_HEADING_COMMENTS', '特別なインストラクションまたはオーダーコメント：' );
define ( 'TABLE_BODY_COMMENTS1', '1> 税関税や他のコメントについての特別なインストラクションは、我々はお客様が我々に言ったようにそれをいたします。' );
define ( 'TABLE_BODY_COMMENTS2', '2> 小包に請求書が必要な場合は、<a href="mailto:service_jp@8seasons.com"> <font style="color:#0000FF">service_jp@8seasons.com</font></a>に請求書例を送ってください' );
define ( 'TABLE_BODY_COMMENTS3', '3><b><span lang=EN-US style="color:red">包装サービスを利用したい場合、こちらに <a href="http://www.8seasons.com/download/Packing%20list.xls">パッキングリスト</a>(.xlsx) をダウンロードしてから、記入してください。&nbsp;</span></b>' );
define ( 'TABLE_HEADING_COMMENTS_1', '例えば、我々は税関申告書にご希望の小包の価値を申告します。 ' );

// define('TABLE_HEADING_COMMENTS_2', 'or input the RCD Discount Number you got from us, We will refund to you after you checkout successfully');

define ( 'TABLE_HEADING_COMMENTS_2', '' );

define ( 'TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'ステップ2に続けます' );

define ( 'TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- お支払い方法を選んでください。' );

// when free shipping for orders over $XX.00 is active

define ( 'FREE_SHIPPING_TITLE', '送料無料' );

define ( 'FREE_SHIPPING_DESCRIPTION', '%s以上のお買い上げで送料無料' );

?>