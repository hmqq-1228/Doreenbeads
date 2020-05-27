<?php 
		$an_sql = "select an_id,an_starttime,an_endtime from ".TABLE_ANNOUNCEMENT." where an_starttime <= '".date('Y-m-d H:i:s',time())."' and an_endtime >= '".date('Y-m-d H:i:s',time())."' and an_status = 20 order by an_id DESC limit 1";
		$an_sql_query = $db->Execute($an_sql) ;
		if( $an_sql_query->RecordCount() > 0) {	
			$an_id = $an_sql_query->fields['an_id'];
			$an_starttime = $an_sql_query->fields['an_starttime'];
			$an_endtime = $an_sql_query->fields['an_endtime'];
			$an_desc_query = $db->Execute("select an_language,an_mobile_content from " . TABLE_ANNOUNCEMENT_DESCRIPTION . " where an_id = ".$an_id);
			while(!$an_desc_query->EOF){
		  		$an_desc_array[$an_desc_query->fields['an_language']] = stripslashes($an_desc_query->fields['an_mobile_content']);
				$an_desc_query->MoveNext();
			}
		}
		if (isset($an_desc_array[$_SESSION['languages_id']]) && $an_desc_array[$_SESSION['languages_id']] != ''){
		?>
			<div class="head-notice" id="holidaynote<?php echo $an_id ?>">
				<ins class="notice"></ins>
				<a href="<?php echo zen_href_link(FILENAME_ANNOUNCEMENT, 'AID='.$an_id)?>">
					<marquee behavior="scroll" scrolldelay="150">
						<span><?php echo $an_desc_array[$_SESSION['languages_id']];?></span>
					</marquee>
				</a>
				<ins class="close" onclick="noteclose();"></ins>
			</div>
	<?php 
		}
	?>