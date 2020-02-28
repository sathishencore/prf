<?php echo $this->Form->create("Login",array("url"=>"/Login/","id"=>"frmLogin"));?>
<div class="loginbg">
        	<div class="loginarea">
            	<div>	
                	<div class="feilds">
					<?php echo $this->Form->input("User.LoginName",array("label"=>false,"div"=>false,'placeholder'=>'Login ID ',"class"=>"login-textfeild"));?>						
			 		</div>			 		
			 	</div>
			 	<div class="errorContainer" id="invalid-UserLoginName">&nbsp;</div>
                <div>
                	<div class="feilds">
                	<?php echo $this->Form->password("User.Password",array("label"=>false,"class"=>"login-textfeild",'placeholder'=>'Password',"div"=>false));?>                		
                	</div>                	
                </div>
                <div class="errorContainer" id="invalid-UserPassword">&nbsp;</div>
                <div>
					<div class="feilds" style="margin-left:20px;">
						<?php
							echo $this->Form->submit("login",array("type"=>"image","src"=>$this->Html->url("/")."img/login-button.png","id"=>"Image1","onmouseout"=>"MM_swapImgRestore()","onmouseover"=>"MM_swapImage('Image1','','".$this->Html->url("/")."img/login-button-hover.png',1)","div"=>false));							 	
						?>
							
							&nbsp;&nbsp;
						<?php 
						echo $this->Html->link(
									    $this->Html->image("cancel-but.png", array("alt" => "Login","id"=>"Image2")),
									    "javascript:",
									    array('escape' => false,"onmouseout"=>"MM_swapImgRestore()","onmouseover"=>"MM_swapImage('Image2','','".$this->Html->url("/")."img/cancel-button-hover.png',1)","onclick"=>"$('#frmLogin').trigger('reset');")
						);?>
												
					</div>
			 	</div>
                <div class="feilds">
				  <a href="javascript:" class="forgotpass" id="forgotPassword" style="text-align:right;margin-top:10px;" onclick="">Forgot Password?</a>    
				</div>					
			</div>
</div>
<?php echo $this->Form->end();?>

<div id="dialog-form" style="display:none;" title="Forgot Password Dialog">
	<?php echo $this->Form->create("LoginFrm",array("url"=>"/login/forgotPassword","id"=>"forgotPasswordFrm"));?>
	<table>
	<tr>
	<td>	
	<label style="float:left">Enter your Email Address :</label>
	</td>
	<td>
	<?php echo $this->Form->input("Email",array("label"=>false,"div"=>false,"class"=>"textfield-cmn"));?>
	</td>
	<td>
	<?php echo $this->Form->submit("Send");?>
	</td>	
	</tr>
	<tr>
		<td></td>
		<td><div id="invalid-LoginFrmEmail" class="error"></div></td>
		<td></td>
	</tr>
	</table>
	<?php echo $this->Form->end() ?> 
</div>
<script>
jQuery.validator.setDefaults({errorPlacement:function(a,b){a.appendTo("#invalid-"+b.attr("id"))}});
$(document).ready(function(){	
	$("#UserLoginName").focus();
	$("#frmLogin").validate({
			rules: {
				"data[User][LoginName]": "required",
				"data[User][Password]":"required"								
			},
			messages:{
				"data[User][LoginName]": "* Enter valid username",
				"data[User][Password]":"* Enter valid password"
			}		
	});
	$("#forgotPasswordFrm").validate({
			rules:{
					"data[LoginFrm][Email]":{
						email:true,
						required:true
					}
			}
	});
	 $( "#dialog-form" ).dialog({
		 autoOpen: false,
		 height: 150,
		 width: 650,
		 modal: true
	});
	 $( "#forgotPassword").click(function() {
	 	$( "#dialog-form" ).dialog( "open" );
	 });
});
</script>