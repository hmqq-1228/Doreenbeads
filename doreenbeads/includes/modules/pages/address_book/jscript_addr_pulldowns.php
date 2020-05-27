<?php
/**
 * jscript_addr_pulldowns
 *
 * handles pulldown menu dependencies for state/country selection
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_addr_pulldowns.php 4830 2006-10-24 21:58:27Z drbyte $
 */
?>
<script language="javascript" type="text/javascript"><!--

function update_zone(theForm) {
  // if there is no zone_id field to update, or if it is hidden from display, then exit performing no updates
  if (!theForm || !theForm.elements["zone_id"]) return;
  //if (theForm.zone_id.type == "hidden") return;

  // set initial values
  var SelectedCountry = theForm.zone_country_id.options[theForm.zone_country_id.selectedIndex].value;
  var SelectedZone = theForm.elements["zone_id"].value;

  // reset the array of pulldown options so it can be repopulated
  var NumState = theForm.zone_id.options.length;
  while(NumState > 0) {
    NumState = NumState - 1;
    theForm.zone_id.options[NumState] = null;
  }
  // build dynamic list of countries/zones for pulldown
<?php echo zen_js_zone_list('SelectedCountry', 'theForm', 'zone_id');?>

  // if we had a value before reset, set it again
  if (SelectedZone != "") theForm.elements["zone_id"].value = SelectedZone;

}

  function hideStateField(theForm) {
    theForm.state.disabled = true;
    theForm.state.className = 'hiddenField';
    theForm.zone_id.disabled = false;
    theForm.state.setAttribute('className', 'hiddenField');
    theForm.zone_id.className = 'inputLabel visibleField';
    theForm.zone_id.setAttribute('className', 'visibleField');
    
    //document.getElementById("stateLabel").className = 'hiddenField';
    //document.getElementById("stateLabel").setAttribute('className', 'hiddenField');
    //document.getElementById("stText").className = 'hiddenField';
    //document.getElementById("stText").setAttribute('className', 'hiddenField');
    //document.getElementById("stBreak").className = 'hiddenField';
    //document.getElementById("stBreak").setAttribute('className', 'hiddenField');
  }

  function showStateField(theForm) {
    theForm.state.disabled = false;
    theForm.zone_id.className = 'hiddenField';
    theForm.zone_id.disabled = true;
    theForm.state.className = 'inputLabel visibleField';
   
    theForm.state.setAttribute('className', 'visibleField');
    theForm.state.type = '';
    
    //document.getElementById("stateLabel").className = 'inputLabel visibleField';
   // document.getElementById("stateLabel").setAttribute('className', 'inputLabel visibleField');
    //document.getElementById("stText").className = 'alert visibleField';
   // document.getElementById("stText").setAttribute('className', 'alert visibleField');
   // document.getElementById("stBreak").className = 'clearBoth visibleField';
   // document.getElementById("stBreak").setAttribute('className', 'clearBoth visibleField');
  }
//-->
  function country_select_choose(cName,fun){
		$j(document).ready(function(){
			$j('.choose_single').click(function(){
					var ifshow=$j('.country_select_drop').css('display');
					//var ifshow = $j(this).parent('a').next('div.country_select_drop').css('display');
					//alert(ifshow);
					current=$j("#cSelectId").val();
					if(ifshow=="none"){
						$j('.country_select_drop').show();
						$j(this).removeClass('choose_single_focus');
						$j(this).addClass('choose_single_click');
						$j('.country_select_drop .choose_search input').val('');
						$j('.country_select_drop ul .country_list_item').css('display','block');
						$j('.country_select_drop .choose_search input').focus();
						cNum=$j('#cSelectId').val();
						if($j("#country_list_"+cNum).hasClass('country_list_item_selected')&&!$j("#cSelectId").hasClass('selectNeedList')){
							
							}else{
								$j("#cSelectId").removeClass('selectNeedList');
								$j('#edit_address_book #country_list_'+cNum).addClass('country_list_item_selected');
								$j('#add_new_address #country_list_'+cNum).addClass('country_list_item_selected');
								boxTop1=$j("#country_list_1").position().top;
								boxTop2=$j("#country_list_"+cNum).position().top;
								selfHeight=$j("#country_list_"+cNum).height()+8+7;
								boxTop=boxTop2-boxTop1-220+selfHeight;
								$j('.country_select_drop ul').scrollTop((boxTop));
								}
						}else{
							//$j('.country_select_drop').hide();
							//$j(this).removeClass('choose_single_click');
							//$j(this).addClass('choose_single_focus');
							}
				})

			$j('.country_list_item').hover(function(){
				$j(this).addClass('country_list_item_hover');
				$j('.country_list_item').removeClass('country_list_item_selected');
				},function(){
					$j(this).removeClass('country_list_item_hover');
					})	

			$j('.country_list_item').click(function(){	
				var num = $j('.country_select_drop').index($j(this).parent().parent());
				var cListId=$j(this).attr('clistid');
				var cText=$j(this).text();
				var cId=$j(this).attr('id');
				var zip_code_rule = $j.trim($j(this).attr('zip_code_rule'));
				var zip_code_example = $j.trim($j(this).attr('zip_code_example'));
				cIdArr=cId.split('_');
				getCId=cIdArr[2];
				$j('.choose_single span').text(cText);
				$j('#'+cName).val(cListId);
				$j('#cSelectId').val(getCId);
				$j('#edit_address_book #select_coutry_zip_code_info').attr('zip_code_rule',zip_code_rule);
				$j('#edit_address_book #select_coutry_zip_code_info').attr('zip_code_example',zip_code_example);

				$j('#add_new_address #select_coutry_zip_code_info').attr('zip_code_rule',zip_code_rule);
				$j('#add_new_address #select_coutry_zip_code_info').attr('zip_code_example',zip_code_example);
				$j(this).addClass('country_list_item_selected');
				$j('.country_select_drop').hide();
				if(num == 0){
					$j('#add_new_address #'+cName).val(cListId);
				}else if(num == 1){
					$j('#edit_address_book #'+cName).val(cListId);
				}
				$j('.choose_single').removeClass('choose_single_click');
				$j('.choose_single').addClass('choose_single_focus');
				$j('.choose_single').focus();
				//alert($j("li").index(this));
				if(fun){
					formEle=document.getElementsByName(fun);
					update_zone_c(formEle[num]);
					}
				})	

			$j('.choose_single').blur(function(){
				$j(this).removeClass('choose_single_focus');
				})

			$j('.choose_search input').keyup(function(){
			    inputVal=$j(this).val();
			    inputVals=inputVal.replace(/^\s*|\s*$/g, "");
				if(inputVals!=''){
						$j('.country_select_drop ul').scrollTop(0);
						$j("#cSelectId").addClass('selectNeedList');
						$j(".country_select_drop ul .country_list_item").each(function(){
							cTextVal=$j(this).text();
							re = new RegExp("^"+inputVals,'i');  
							re2= new RegExp("\\s+"+inputVals,'i')
							if(cTextVal.match(re)||cTextVal.match(re2)){
										$j(this).css('display','block');
									}else{
										$j(this).css('display','none');
										}
							});
					}else{
						$j('.country_select_drop ul .country_list_item').css('display','block');
						}
				})
					
			})

			
	}


	function update_zone_c(theForm) {
	  if (!theForm || !theForm.elements["zone_id"]) return;
	  
	  var SelectedCountry = theForm.zone_country_id.value;
	  var SelectedZone = theForm.elements["zone_id"].value;
	  var NumState = theForm.zone_id.options.length;
	  while(NumState > 0) {
	    NumState = NumState - 1;
	    theForm.zone_id.options[NumState] = null;
	  }
	<?php echo zen_js_zone_list('SelectedCountry', 'theForm', 'zone_id');?>

	  if (SelectedZone != "") theForm.elements["zone_id"].value = SelectedZone;
	}
</script>