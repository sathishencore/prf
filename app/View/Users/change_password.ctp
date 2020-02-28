<div class="titlebg" id="titlebg">
	<div class="titletxt"><?php echo $title_for_layout;?></div> 	
</div> 	

<div class="bodyconrarea">			
         	<div class="content">
            	<div class="content-mid">
            	<?php echo $this->Form->create("User",array("url"=>"/Users/changePassword"));?>
            			<table width="50%" border="0" cellspacing="10" cellpadding="0" align="center">                      		
                        	<tr>
                        		<td>
                        			Enter your new password
                        		</td>
                        		<td>:</td>
                        		<td width="60%">
                        			<?php echo $this->Form->input("newPassword",array("label"=>false,"class"=>"textfield-cmn","div"=>false,"type"=>"password"));?>
                        		</td>
                        	</tr>
                        	<tr>
                        		<td>
                        			Confirm your new password
                        		</td>
                        		<td>:</td>
                        		<td valign="top">
                        			<?php echo $this->Form->input("confirmPassword",array("label"=>false,"class"=>"textfield-cmn","div"=>false,"type"=>"password"));?>
                        		</td>
                        	</tr>
                        	<tr>
                        		<td>&nbsp;</td>
                        		<td>&nbsp;</td>
                        		<td>
                        		<?php
									echo $this->Form->submit("login",array("type"=>"image","src"=>$this->Html->url("/")."img/save-but.png","div"=>false));							 	
								?>
								&nbsp;			
								<?php 
									echo $this->Html->link(
									    $this->Html->image("cancel-inner-but.png", array("alt" => "Cancel")),
									    "/Users",
									    array('escape' => false)
									);
								?>
                        		</td>
                        	</tr>
                        </table>	
                   <?php echo $this->Form->end();?>     
            	</div>
            </div>
</div>          
<script>
$(document).ready(function(){
	$("#UserChangePasswordForm").validate({
		rules: {
			"data[User][newPassword]":{ 
                required: true,
                minlength: 6
	          }, 
	        "data[User][confirmPassword]": { 
	            required: true, equalTo: "#UserNewPassword",
	            minlength: 6
	        }
		}
	});
});
</script>