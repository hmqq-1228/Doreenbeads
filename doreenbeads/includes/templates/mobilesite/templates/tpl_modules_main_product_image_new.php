		<?php require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE));?>
		<dd>
         <div class="bigimgshow">
         <?php 
			echo $img_310_text[0];
         	if ($discount_amount > 0) {
				echo '<div class="discountoff">' .($_SESSION['languages_id']==4?('-'.($discount_amount).'%'):('-'.$discount_amount . '%<br>')). '</div>';
			}
		  ?>
         </div>
         <div class="smallimgshow">	   		
           <div class="detailimglist">
			   <ul class="deimglist">
			   <?php 
			   		for ($i=0, $n=sizeof($img_80_text); $i<$n; $i++) {
			   			if($i==0){
			   				$first_li_style = 'class="arrownow"';
			   			}else{
			   				$first_li_style = '';
			   			}
			   	?>
				 <li <?php echo $first_li_style;?>>
				   <span></span>
				   <?php echo $img_310_text[$i];?>
				   <div><?php echo $img_80_text[$i];?></div>
				   
				 </li>
				<?php } ?>
			   </ul>
           </div>
         </div>
    </dd>
    
   <div class="imglightbox" id="imglightbox">
	   <p style="height:20px;"><span class="closeimgbtn1">&nbsp;&nbsp;</span></p>
	   <div class="imglightboxcont">
	      <span class="pre"><img src="includes/templates/cherry_zen/images/prebtnc.gif" width="60" height="80" /> </span>
	      <span class="next"><img src="includes/templates/cherry_zen/images/nextbtn.gif" width="60" height="80" /> </span>
	      <div class="lightboximg"><?php echo $img_500_text[0];?></div>
	  </div>
	  <div class="detailimglist detailimglistup">
	      <ul class="deimglist">
				 <?php for ($i=0, $n=sizeof($img_80_text); $i<$n; $i++) {?>
				 <li <?php if($i==0) echo 'class="arrownow"';?>>
				   <span></span>
				   <?php echo $img_500_text[$i];?>
				   <div><?php echo $img_80_text[$i];?></div>
				 </li>
				<?php } ?>	
			   </ul>
	  </div>
  </div>