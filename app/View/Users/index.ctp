<div class="titlebg" id="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;"> <?php echo $title_for_layout;?></div>
 	<div class="show" id="toggleCreateshow">&nbsp;</div>
</div> 		
 		<?php 
		if(isset($this->params['pass'][0])){
			$id=$this->params['pass'][0];
		}else{
			$id='';
		} 
		echo $this->Form->create("User",array("url"=>"/Users/index/$id"));
		?>
		<div class="bodyconrarea">
         	<div class="content" id="createUserSection" <?php if(!$id){?> style="display: none;"<?php }?>>
            	<div class="content-mid">					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top" width="100%"> 
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td width="50%">
                                	<table width="94%" border="0" cellspacing="0" cellpadding="4" align="center" class="textfield-cmntxt">
									<tr>
                                        <td width="34%">User Name<span class="errorMandatory">*</span></td>
                                         <td width="8%">:</td>
                                         <td width="58%">
                                         	<?php 
                                         		$attributes=array("label"=>false,"class"=>"textfield-cmn","div"=>false);
                                         		if($id>0){
                                         			$attributes['disabled']="disabled";
                                         		}
                                         	?>
											<?php echo $this->Form->input("User.LoginName",$attributes);?>
										</td>								
									</tr>
									<tr>
										<td>First Name<span class="errorMandatory">*</span></td>
										<td>:</td>
										<td>									
											<?php echo $this->Form->input("User.FirstName",array("label"=>false,"class"=>"textfield-cmn","div"=>false));?>
										</td>
									 </tr>
									 <tr>
										<td>LastName<span class="errorMandatory">*</span></td>
										<td>:</td>													
										<td>
										<?php echo $this->Form->input("User.LastName",array("label"=>false,"class"=>"textfield-cmn","div"=>false));?>
										</td>								
									</tr>	
									<tr>
                                        <td width="34%">Email<span class="errorMandatory">*</span></td>
                                         <td width="8%">:</td>
                                         <td width="51%">
											<?php echo $this->Form->input("User.Email",array("label"=>false,"class"=>"textfield-cmn","div"=>false));?>
										</td>								
									</tr>								
                                    </table>
                                    </td>
                                	<td width="50%" style="padding-left:50PX;">
                                    <table width="94%" border="0" cellspacing="0" cellpadding="4" align="center" class="textfield-cmntxt">					<tr>
				<td>Location<span class="errorMandatory">*</span></td>
				<td>:</td>
				<td>
<?php echo $this->Form->select("User.TimezoneID",array("5"=>"US","79"=>"India"),array("empty"=>"---Select---"));?>
<?php //$timezone ?>
										</td>
									 </tr>				
									<tr>
                                        <td width="34%">Phone</td>
                                         <td width="8%">:</td>
                                         <td width="51%">
											<?php echo $this->Form->input("User.Mobile",array("label"=>false,"class"=>"textfield-cmn","div"=>false));?>																	
										</td>								
									</tr>
									
									 <tr>
										<td>Role Id<span class="errorMandatory">*</span></td>
										<td>:</td>													
										<td>
										<?php echo $this->Form->select("User.RoleId",$roleList,array("empty"=>"---Select---"));?>
										</td>								
									</tr>	
									<tr>
                                        <td width="34%">&nbsp;</td>
                                         <td width="8%">&nbsp;</td>
                                         <td width="51%" style="height:52px;">
											&nbsp;
										</td>								
									</tr>								
                                    </table>
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                    </table>                    
                </div>
                <div class="buttonalign">		          
			          <?php
						echo $this->Form->submit("login",array("type"=>"image","src"=>$this->Html->url("/")."img/save-but.png","div"=>false));							 	
						?>
					&nbsp;			
					<?php 
						echo $this->Html->link(
						    $this->Html->image("cancel-inner-but.png", array("alt" => "Cancel")),
						    "/Users/index/",
						    array('escape' => false)
						);?>
		          </div>  
            </div>	
         </div>
         <?php echo $this->Form->end();?>
         <?php echo $this->element("searchUser");?>
<script>
var tzone="";
var check_tzone;
$('#UserTimezoneID').on('change', function() {
	 // alert( this.value ); // or $(this).val()
	 tzone = $('#UserTimezoneID').val();
	  //alert(tzone);

	  if(tzone=="79") {
			//alert("is 79");
			$("#UserMobile").mask("+91 88888 88888");
		}
		if(tzone!="79") {
			//alert("else");
		$("#UserMobile").mask("+1 (888) 888/8888");
		}
		if(tzone==""){
			alert( "Please select the Location" );
		}
	});
$( "#UserMobile" ).focus(function() {
	check_tzone =  $('#UserTimezoneID').val();
	//alert(check_tzone);
	if(check_tzone=="") {
		alert( "Please select the Location" );	
	}
  	
});
$(document).ready(function(){
	$("#searchUser").tabs({"active":<?php echo $show?>});
	$("#UserNamelist").chosen();	
	$("#toggleshow").bind("click",function(){
		$("#searchUser").toggle();
		$("#toggleshow").toggleClass("show hide");		
	});
	$("#toggleCreateshow,#toggleCreateshow1").bind("click",function(){
		$("#createUserSection").toggle();
		$("#toggleCreateshow").toggleClass("show hide");		
	});		
	$("#UserIndexForm").validate({
			rules: {
				"data[User][LoginName]":{
					required:true,
					 remote: {
						 url: "<?php echo $this->Html->url("/Users/checkName"); ?>",
						 type: "get",
						 data: {
							 UserLoginName: function() {
							 	return $( "#UserLoginName" ).val();
							 }
						 }
					}
				},
				"data[User][FirstName]": {
					required:true
				},
				"data[User][LastName]":"required",								
				"data[User][LastName]":"required",
				"data[User][TimezoneID]":"required",
				"data[User][RoleId]":"required",
				"data[User][Email]":{
					required:true,
					email:true,
					remote:{
						url: "<?php echo $this->Html->url("/Users/checkEmail") ?>",
						type: "get",
						data: {
							 UserEmail: function() {
							 	return $("#UserEmail").val();
							 },
							 UserId:<?php echo ($id>0)?$id:"0";?>
						}
					}
				}								
			},
			messages : {
				"data[User][LoginName]" : {
					required: "This field is required.",
					remote : "Username already exists."
				},
				"data[User][Email]":{
					remote : " Email address already exists. "
				}
			}		
	});
});
function checkval(){
	$("#UserFrmIndexForm").submit();
}
</script>        
