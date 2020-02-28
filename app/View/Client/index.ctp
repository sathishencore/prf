<?php
$timezone_list=Configure::read("TIMEZONE");
if(isset($this->params['pass'][0])){
	$id=$this->params['pass'][0];
}else{
	$id='';
}
if($editAction) {
	?>
<div class="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;">
		<?php echo $title_for_layout;?>
	</div>
	<?php if($title_for_layout=='Update Client') {
	?>
	<div class="hide" id="toggleCreateshow">&nbsp;</div>
	<?php } else { ?>
	<div class="show" id="toggleCreateshow">&nbsp;</div>
	<?php } ?>
</div>
<?php
echo $this->Form->create("Client",array("url"=>"/Client/index/$id"));
?>
<div class="bodyconrarea">
	<div class="content" id="createUserSection" <?php if(!$id){?>
		style="display: none;" <?php }?>>
		<div class="content-mid">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
							align="center">
							<tr>
								<td width="50%">
									<table width="94%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td width="34%">Client Name<span class="errorMandatory">*</span>
											</td>
											<td width="8%">:</td>
											<td width="58%"><?php echo $this->Form->input("Client.Name",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										
										<tr>
											<td>Address 1<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.AddressLine1",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td>Address 2</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.AddressLine2",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td>City<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.City",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td width="34%">State<span class="errorMandatory">*</span>
											</td>
											<td width="8%">:</td>
											<td width="51%"><?php echo $this->Form->input("Client.State",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td width="34%">Postal Code<span class="errorMandatory">*</span>
											</td>
											<td width="8%">:</td>
											<td width="51%"><?php echo $this->Form->input("Client.PostalCode",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td>Country<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.Country",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
									</table>
								</td>
								<td width="50%" style="padding-left: 50PX;">
									<table width="94%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td>Client Code<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											$attributes=array("label"=>false,"class"=>"textfield-cmn","div"=>false);
											if($id>0){
                                         			$attributes['disabled']="disabled";
                                         		}
                                         		?> <?php echo $this->Form->input("Client.ClientCode",$attributes);?>
											</td>
										</tr>
										<tr>
											<td>Email
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.Email",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										
										<tr>
											<td>Phone<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.Phone",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td>Fax</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Client.Fax",array("label"=>false,"class"=>"textfield-cmn"));?>
											</td>
										</tr>
										<tr>
											<td>Timezone</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Client.TimezoneID",$timezone_list,array("empty"=>"---Select---"));?>
											</td>
										</tr>
										<tr>
											<td>Notes</td>
											<td>:</td>
											<td><?php echo $this->Form->textarea("Client.Notes",array("label"=>false,"style"=>"width:270px",));?>
											</td>
										</tr>
										<?php if(!empty($id)) { ?>
										<tr>
											<td>Status</td>
											<td>:</td>
											<?php $status=array("Active"=>"Active","Inactive"=>"Inactive")?>
											<td><?php echo $this->Form->select("Client.Status",$status,array("id"=>"Status","empty"=>false,"style"=>"width:250px;"));?>
											</td>
										</tr>
										<?php }?>
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<?php if(!empty($id)) { 
								echo $this->element("ClientContactForEdit");
}?>
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
			&nbsp;
			<?php if(!empty($id) && $delete == 0){ 
			echo $this->Html->link(
						    $this->Html->image("delete-but.png", array("alt" => "Delete","class"=>"Delete")),
						    "/Client/delete/$id",
						    array('escape' => false)
						);}?>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>
<?php }?>
<?php echo $this->element("searchClient");?>
<script>
$("#ClientPhone,#ClientFax").mask("+1 (888) 888-8888");
$(document).ready(function(){
	$("#searchbox").chosen();
	$("#UserNamelist").chosen();	
	$("#toggleshow").bind("click",function(){
		$("#searchClient").toggle();
		$("#toggleshow").toggleClass("show hide");		
	});
	$("#toggleCreateshow,#toggleCreateshow1").bind("click",function(){
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
				"data[Client][AddressLine1]":"required",
				"data[Client][City]":{
					required:true
				},
				"data[Client][State]":"required",
				"data[Client][PostalCode]":"required",
				"data[Client][Country]":"required",
				"data[Client][Phone]":"required"								
			},
			messages : {
				"data[Client][ClientCode]" : {
					required: "*required.",
					remote : "Client Id already exists"
				}
			}		
	});
});
function checkval(){
	$("#searchForm").submit();
}

$(".Delete").click( function(){
	var x = confirm("Do you want to delete this record ?");
			if(x)
				return true;
			else
				return false;
});

function clientIndex(){
	window.location.href = "<?php echo $this->Html->url("/")?>";
}

</script>
