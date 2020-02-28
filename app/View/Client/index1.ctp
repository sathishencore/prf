<div class="titlebg">
	 <div class="titletxt"><?php echo $title_for_layout;?></div>
	 <div class="show" id="toggleCreateshow">&nbsp;</div>
</div>
<?php
$timezone_list=Configure::read("TIMEZONE");
if(isset($this->params['pass'][0])){
	$id=$this->params['pass'][0];
}else{
	$id='';
} 
echo $this->Form->create("Client",array("url"=>"/Client/index/$id"));?>
<div class="bodyconrarea">			
         	<div class="content" id="createUserSection">
            	<div class="content-mid">					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top" width="100%">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                <td width="50%">
                                	<table width="94%" border="0" cellspacing="0" cellpadding="4" align="center" class="textfield-cmntxt">
									<tr>	
										<td width="34%">Client Name</td>
										<td width="8%">:</td>
										<td width="58%">
										<?php echo $this->Form->input("Client.Name",array("label"=>false,"class"=>"textfield-cmn"));?>
										<div class="errorMandatory">*</div>
										</td>
									</tr>
									<tr>
										<td>Client ID</td>
										<td>:</td>
										<td>
										<?php 
                                         		$attributes=array("label"=>false,"class"=>"textfield-cmn","div"=>false);
                                         		if($id>0){
                                         			$attributes['disabled']="disabled";
                                         		}
                                         	?>
										<?php echo $this->Form->input("Client.ClientCode",$attributes);?>
										<div class="errorMandatory">*</div>
										</td>
									</tr>
									<tr>
										<td>Account Manager</td>
										<td>:</td>
										<td>
										<?php echo $this->Form->select("Client.AccountManagerID",$accountManagerList,array("empty"=>"-----Select-----"));?>
										<div class="errorMandatory">*</div>
										</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>:</td>
										<td>
										<?php echo $this->Form->input("Client.Email",array("label"=>false,"class"=>"textfield-cmn"));?>
										<div class="errorMandatory">*</div>
										</td>
									</tr>
									<tr>
										<td>Address 1</td>
										<td>:</td>
										<td>
										<?php echo $this->Form->input("Client.Line1",array("label"=>false,"class"=>"textfield-cmn"));?>
										<div class="errorMandatory">*</div>
										</td>
									</tr>
									<tr>
										<td>Address 2</td>
										<td>:</td>
										<td>
										<?php echo $this->Form->input("Client.Line2",array("label"=>false,"class"=>"textfield-cmn"));?>
										</td>
									</tr>
								</table>
								</td>
                                	<td width="50%" style="padding-left:50PX;">
                                	 <table width="94%" border="0" cellspacing="0" cellpadding="4" align="center" class="textfield-cmntxt">
                                	 		<tr>
												<td>City</td>
												<td>:</td>
												<td>
												<?php echo $this->Form->input("Client.City",array("label"=>false,"class"=>"textfield-cmn"));?>
												<div class="errorMandatory">*</div>
												</td>
											</tr>                                	 		
											<tr>
												<td width="34%">State</td>
												<td width="8%">:</td>
												<td width="51%">
												<?php echo $this->Form->input("Client.State",array("label"=>false,"class"=>"textfield-cmn"));?>
												<div class="errorMandatory">*</div>
												</td>
											</tr>
											<tr>
												<td>Country</td>
												<td>:</td>
												<td>
												<?php echo $this->Form->input("Client.Country",array("label"=>false,"class"=>"textfield-cmn"));?>
												<div class="errorMandatory">*</div>
												</td>
											</tr>
											<tr>
												<td>Phone</td>
												<td>:</td>
												<td>
												<?php echo $this->Form->input("Client.Phone",array("label"=>false,"class"=>"textfield-cmn"));?>
												<div class="errorMandatory">*</div>
												</td>
											</tr>
											<tr>
												<td>Fax</td>
												<td>:</td>
												<td>
												<?php echo $this->Form->input("Client.Fax",array("label"=>false,"class"=>"textfield-cmn"));?>
												</td>
											</tr>
											<tr>
												<td>Timezone</td>
												<td>:</td>
												<td>
												<?php echo $this->Form->select("Client.Timezone",$timezone_list);?>
												</td>
											</tr>
											<tr>
												<td colspan="3">&nbsp;											
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
						    "/Client/index/",
						    array('escape' => false)
						);?>
		          </div>  
            </div>	
         </div>
         <?php echo $this->Form->end();?>
         <?php echo $this->element("searchClient");?>
<script>
$(document).ready(function(){
	$("#searchbox").chosen();
	$("#UserNamelist").chosen();	
	$("#toggleshow").bind("click",function(){
		$("#searchClient").toggle();
		$("#toggleshow").toggleClass("show hide");		
	});
	$("#toggleCreateshow").bind("click",function(){
		$("#createUserSection").toggle();
		$("#toggleCreateshow").toggleClass("show hide");		
	});	
	$("#ClientIndexForm").validate({
			rules: {
				"data[Client][Name]": {
					required:true
				},
				"data[Client][ClientCode]":{
						required:true,						
						remote:{
							url: "<?php echo Router::reverse($this->params)."/";?>../Client/checkcode",
							type: "get",
							 data: {
								 ClientCode: function() {
								 	return $( "#ClientClientCode" ).val();
								 }
							 }
						}
				},
				"data[Client][AccountManagerID]":"required",				
				"data[Client][Email]":{
					required:true,
					email:true
				},
				"data[Client][Line1]":"required",
				"data[Client][City]":{
					required:true
				},
				"data[Client][State]":"required",
				"data[Client][Country]":"required",
				"data[Client][Phone]":"required"								
			},
			messages : {
				"data[Client][ClientCode]" : {
					required: "This field is required.",
					remote : "Client Id already exists"
				}
			}		
	});
});
function checkval(){
	$("#searchForm").submit();
}
</script>        