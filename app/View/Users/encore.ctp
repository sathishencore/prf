<div class="titlebg">
	<div class="titletxt" id="toggle1" style="cursor: pointer;">
		<?php echo $title_for_layout;?>
	</div>
	<div class="show" id="toggle">&nbsp;</div>
</div>
<?php 
if(isset($this->params['pass'][0])){
			$id=$this->params['pass'][0];
		}else{
			$id='';
		}
		echo $this->Form->create("EncoreContacts",array("url"=>"/Users/encore/$id"));
		?>
<div class="bodyconrarea">
	<div class="content" id="encoreContacts" <?php if(!$id){?>
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
											<td width="50%">
												<table width="94%" border="0" cellspacing="0"
													cellpadding="4" align="center" class="textfield-cmntxt">
													<tr>
														<td>Contact Name<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.ContactName",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Contact Title<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.ContactTitle",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Department<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.Department",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Email<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.Email",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Work Phone<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.WorkPhone",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Extension #</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.ExtensionNo",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Cell Phone<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.CellPhone",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
												</table>
											</td>
											<td width="50%">
												<table width="94%" border="0" cellspacing="0" R
													cellpadding="4" align="center" class="textfield-cmntxt">
													<tr>
														<td>Fax</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.Fax",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Address1</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.AddressLine1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Address2</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.AddressLine2",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>City<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.City",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>State<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.State",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Postal Code<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.PostalCode",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
													<tr>
														<td>Country<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("EncoreContacts.Country",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
														</td>
													</tr>
												</table>
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
<?php echo $this->element("encoreContacts");?>
<script>

$("#EncoreContactsWorkPhone,#EncoreContactsCellPhone,#EncoreContactsFax").mask("+1 (888) 888-8888");

$("#toggle,#toggle1").bind("click",function(){
	
	$("#encoreContacts").toggle();
	$("#toggle").toggleClass("show hide");		
});	
$("#toggleshow").bind("click",function(){
	
	$("#searchClient").toggle();
	$("#toggleshow").toggleClass("show hide");		
});	

$("#EncoreContactsEncoreForm").validate({
	rules: {
		"data[EncoreContacts][ContactName]": {
			required:true
		},
		"data[EncoreContacts][ContactTitle]": {
			required:true
		},
		"data[EncoreContacts][Email]": {
			required:function(element) {
		        if(jQuery.trim($("#EncoreContactsWorkPhone").val())!='' || jQuery.trim($("#EncoreContactsCellPhone").val())!=''){
			        return false;
		        }else{
			        return true;
		        } 
		     },
			email:true
		},
		"data[EncoreContacts][WorkPhone]": {
			required:function(element) {
		        if(jQuery.trim($("#EncoreContactsEmail").val())!='' || jQuery.trim($("#EncoreContactsCellPhone").val())!=''){
			        return false;
		        }else{
			        return true;
		        } 
		     },
		},
		"data[EncoreContacts][CellPhone]": {
			required:function(element) {
				 if(jQuery.trim($("#EncoreContactsEmail").val())!='' || jQuery.trim($("#EncoreContactsWorkPhone").val())!=''){
				        return false;
			        }else{
				        return true;
			        } 
		     },
		},
		"data[EncoreContacts][City]": {
			required:true
		},
		"data[EncoreContacts][State]": {
			required:true
		},
		"data[EncoreContacts][PostalCode]": {
			required:true
		},
		"data[EncoreContacts][Country]": {
			required:true
		},
		"data[EncoreContacts][Department]": {
			required:true
		},
	}
});
jQuery.extend(jQuery.validator.messages, {
    	
});
</script>
