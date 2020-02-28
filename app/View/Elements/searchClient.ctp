<?php
$timezone=Configure::read("TIMEZONE");
?>
<div class="titlebg">
	<div class="titletxt">Search</div>
	<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchClient" style="min-height: 200px;">
		<div class="content-mid" id="basicSearch">
			<?php echo $this->Form->create("ClientFrm",array("url"=>array("controller"=>"Client","action"=>"index")));?>
			<table>
				<tr>
					<td>Search by Client Name : &nbsp;</td>
					<td><?php 
					$searchVal = $this->Session->read("Client.ID");
					echo $this->Form->select("searchbox",$clientNamelist,array("id"=>"searchbox","style"=>"width:250px","onchange"=>"checkval(this.value);","empty"=>"All","value"=>$searchVal));?>
					</td>
					<td>Client Location Country: &nbsp;</td>
					<td><?php 
					$cl = array();
					foreach($clientlocation as $key=>$value) {
						$cl_country[$key] = $key; 
						foreach($value as $k=>$v){
							$com = $k.",".$v; 
							$cl_city[$com] = $com; 
						}
					}
					$country = array_keys($cl_country);
					foreach($country as $k=>$v) {
						$country_only[$v] = $v; 
					}
					echo $this->Form->select("searchboxcountry",$country_only,array("style"=>"width:220px;","class"=>"searchbox","empty"=>"---Select---"));?>
					</td>
					
					<td>Client Location City: &nbsp;</td>
					<td><?php 
					echo $this->Form->select("searchboxcity","",array("class"=>"searchbox","style"=>"width:250px","empty"=>"---Select---"));
					echo $this->Form->input("cityval", array("type" => "hidden","id"=>"cityval"));?>
					</td>
					</tr><tr>
					<td>Status : &nbsp;</td>
					
					<td>
					<?php $status = array("Active"=>'Active',"Inactive"=>'Inactive');?>
					<?php echo $this->Form->select("Status",$status,array("class"=>"searchbox","id"=>"status","style"=>"width:250px;height:25px;","empty"=>"All"));?>
					</td>
					<td><?php echo $this->Form->submit("Search");?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end();?>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="displayResults">
			<table class="tablesorter" id="tableHolder" cellspacing="0">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Name</th>
						<th>City</th>
						<th>State</th>
						<th>Country</th>
						<th>Phone</th>
						<th>Fax</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($clientList)>0){
								$i=1;
								foreach($clientList as $ckey=>$cval){
						?>
					<tr>
						<td><?php echo $i?></td>
						<td class="client_view"
							data-val="<?php echo $cval['Client']['ID']?>"><a
							href="javascript:"><?php echo $cval['Client']['Name']?> </a></td>
						<td><?php echo $cval['Client']['City']?></td>
						<td><?php echo $cval['Client']['State']?></td>
						<td><?php echo $cval['Client']['Country']?></td>
						<td><?php echo $cval['Client']['Phone']?></td>
						<td><?php echo $cval['Client']['Fax']?></td>
						<td class="headerRight">
								<form id="frm<?php echo $cval['Client']['ID']?>" action="<?php echo $this->Html->url("/Project/index/");?>" method="post">
									<input type="hidden" name="data[ProjectFrm][ClientId]" value="<?php echo $cval['Client']['ID']?>">
									<input type="hidden" name="data[Project][ClientID]" value="<?php echo $cval['Client']['ID']?>">
									<input type="hidden" name="data[ProjectFrm][ClientCountry]" value="<?php echo $cval['Client']['Country']?>">
									<input type="hidden" name="data[ProjectFrm][ClientCity]" id="ProjectFrmClientCity" value="<?php echo $Clcity;?>">
									<input type="hidden" name="data[ProjectFrm][fromclientfrm]" id="fromclientfrm" value="<?php echo $cval['Client']['City'].','.$cval['Client']['State'];?>">
								</form>
								<?php
									if($editAction){
								echo $this->Html->link("edit",array('controller' => 'Client', 'action' => 'index', (int)$cval['Client']['ID']));?>
								| <a href="javascript:" class="" data-val="<?php echo $cval['Client']['ID']?>" onclick="$('#frm<?php echo $cval['Client']['ID']?>').submit();">Projects</a>
							<?php }else{?> 
						   <a href="javascript:" class="client_view" data-val="<?php echo $cval['Client']['ID']?>">View</a>
						   | <a href="javascript:" class="" data-val="<?php echo $cval['Client']['ID']?>" onclick="$('#frm<?php echo $cval['Client']['ID']?>').submit();">Projects</a> <?php }?> 	
						   
						</td>
					</tr>

					<?php
					$i++;
								}
						 }else{
						?>
				</tbody>
				<tr>
					<td colspan="10" class="headerRight">No Records found</td>
				</tr>
				<?php }
				/*if($this->Paginator->numbers()){
				 ?>
						<tr>
							<td colspan="10" style="text-align:right" class="headerRight">
							&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="10" style="text-align:right" class="headerRight">
								<?php
									echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
								 	echo "&nbsp;";
									echo $this->Paginator->numbers();
								 	echo "&nbsp;";
									echo $this->Paginator->next(' Next »', null, null, array('class' => 'disabled'));
								?>
							</td>
						</tr>
						<?php
						} */
						?>

			</table>
		</div>
		<!-- VIEW  -->
		<div id="dialog-modal" title="Client Details">
			<h1
				style="font-size: 100%; margin-left: 6px; margin-bottom: 1%; margin-top: auto; color: orange;">
				<label id="clientname" style="font-size: 130%;"></label> Details
			</h1>
			<table cellspacing="5" cellpadding="5" style="margin-left: 7%">
				<tr>
					<td style="font-weight: bold;">Address1</td>
					<td>:</td>
					<td><label id="add1"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Address2</td>
					<td>:</td>
					<td><label id="add2"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">City</td>
					<td>:</td>
					<td><label id="city"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">State</td>
					<td>:</td>
					<td><label id="state"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Country</td>
					<td>:</td>
					<td><label id="country"></label></td>
				</tr>
					<tr>
					<td style="font-weight: bold;">Postal Code</td>
					<td>:</td>
					<td><label id="postal"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Phone</td>
					<td>:</td>
					<td><label id="phone"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Fax</td>
					<td>:</td>
					<td><label id="fax"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Email</td>
					<td>:</td>
					<td><label id="email"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">TimeZone</td>
					<td>:</td>
					<td><label id="timezone"></label></td>
				</tr>
				<tr>
					<td colspan="3"><?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"closePopup()"));?></td>
				</tr>
			</table>

		</div>
<!-- VIEW  -->
<!-- ADD CONTACT -->

<div id="add_client_contact" title="Add New Contact"><?php 
echo $this->Form->create("ClientContacts",array("url"=>"/Client/addclientcontact"));
?>
	<h1
		style="font-size: 110%; margin-left: 6px; margin-bottom: 1%; margin-top: auto; color: orange;">
		Client : <label id="addclientname" style="font-size: 110%;"></label>
		
	</h1><?php echo $this->Form->hidden("ClientContacts.ClientID",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
	<?php echo $this->Form->hidden("ClientContacts.ID",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
	<table cellspacing="5" cellpadding="5" style="margin-left: 7%">
	<tr>
			<td style="font-weight: bold;">Contact Name<span
				class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.ContactName",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
			<td style="font-weight: bold;">Contact Title<span
				class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.ContactTitle",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Department<span
				class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.Department",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
				<td style="font-weight: bold;">Email<span class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.Email",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Work Phone<span
				class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.WorkPhone",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
			<td style="font-weight: bold;">Extension #</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.ExtensionNo",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Cell Phone<span
				class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.CellPhone",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
			<td style="font-weight: bold;">Fax
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.Fax",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Address1
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.AddressLine1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
			<td style="font-weight: bold;">Address2</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.AddressLine2",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">City<span class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.City",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
			<td style="font-weight: bold;">State<span class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.State",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Postal Code<span class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.PostalCode",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
			<td style="font-weight: bold;">Country<span class="errorMandatory">*</span>
			</td>
			<td>:</td>
			<td><?php echo $this->Form->input("ClientContacts.Country",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
			</td>
		</tr>
	</table>
	<div class="buttonalign" style="margin-left: 36%;">
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
<?php echo $this->Form->end();?>
</div>

<!-- ADD CONTACT  -->
<script>

$("#ClientContactsWorkPhone,#ClientContactsCellPhone,#ClientContactsFax").mask("+1 (888) 888-8888");

$('#dialog-modal').hide();
$('#add_client_contact').hide();
$(document).ready(function(){
	
	$('#tableHolder').tablesorter({ headers: { 7: { sorter: false  } }});	
	if($("#ClientFrmSearchboxcountry").val()!=""){
		var Country = $("#ClientFrmSearchboxcountry").val();
		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Client/loadCityclient");?>",
			 data: {Country:Country }
			 }).done(function( msg ) {
				 //alert(msg);
			     $("#ClientFrmSearchboxcity").html('');
				 $("#ClientFrmSearchboxcity").html(msg);
				 $("#ClientFrmSearchboxcity").val($("#cityval").val());
				// $("#ClientFrmSearchboxcity").trigger("liszt:updated");
				$(".searchbox").chosen();
		 });
	 }
	 else {
	 	$(".searchbox").chosen();
	 }
});

$('.client_view').click( function() {
	var id=$(this).attr("data-val");
	$.get( "<?php echo $this->Html->url("/")?>Client/ClientView?id="+id ,  function ( data ) {
		var client_data = jQuery.parseJSON(data);
		$('#clientname').text(client_data.Client.Name);
		$('#add1').text(client_data.Client.AddressLine1);
		$('#add2').text(client_data.Client.AddressLine2);
		$('#city').text(client_data.Client.City);
		$('#state').text(client_data.Client.State);
		$('#country').text(client_data.Client.Country);
		$('#postal').text(client_data.Client.PostalCode);
		$('#phone').text(client_data.Client.Phone);
		$('#fax').text(client_data.Client.Fax);
		$('#email').text(client_data.Client.Email);
		$('#timezone').text(client_data.timezones.Timezone);
		 $(function() {
			 $( "#dialog-modal" ).dialog({
			 width:400,
			 modal: true
			 });
			 });
	});
});

$('.client_contact').click( function() {
	$('#ClientContactsContactName,#ClientContactsContactTitle,#ClientContactsEmail,#ClientContactsDepartment,#ClientContactsExtensionNo,#ClientContactsWorkPhone,#ClientContactsCellPhone,#ClientContactsFax,#ClientContactsAddressLine1,#ClientContactsAddressLine2,#ClientContactsCity,#ClientContactsState,#ClientContactsPostalCode,#ClientContactsCountry').val('');
	var id=$(this).attr("data-val");
	$.get( "<?php echo $this->Html->url("/")?>Client/ClientView?id="+id ,  function ( data ) {
		var client_data = jQuery.parseJSON(data);
		$('#addclientname').text(client_data.Client.Name);
		$('#ClientContactsClientName').val(client_data.Client.Name);
		$('#ClientContactsClientID').val(client_data.Client.ID);
		$('#ClientContactsAddressLine1').val(client_data.Client.AddressLine1);
		$('#ClientContactsAddressLine2').val(client_data.Client.AddressLine2);
		$('#ClientContactsCity').val(client_data.Client.City);
		$('#ClientContactsState').val(client_data.Client.State);
		$('#ClientContactsCountry').val(client_data.Client.Country);
		$('#ClientContactsPostalCode').val(client_data.Client.PostalCode);
		 $(function() {
			 $( "#add_client_contact" ).dialog({
			 width:850,
			 title : 'Add New Client Contact',
			 modal: true
			 });
			 });
	});
});


$('#ClientFrmSearchboxcountry').change(function(){
	 var Country = $("#ClientFrmSearchboxcountry").val();
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/loadCityclient");?>",
		 data: {Country:Country }
		 }).done(function( msg ) {
			 //alert(msg);
		     $("#ClientFrmSearchboxcity").html('');
			 $("#ClientFrmSearchboxcity").html(msg);
			 $("#ClientFrmSearchboxcity").trigger("liszt:updated");
	 });
 });
 
 $('#ClientFrmSearchboxcity').change(function(){
 	$("#cityval").val($("#ClientFrmSearchboxcity").val());
 });
 
$("#ClientContactsIndexForm").validate({
	rules: {
		"data[ClientContacts][ContactName]": {
			required:true
		},
		"data[ClientContacts][ContactTitle]": {
			required:true
		},
		"data[ClientContacts][Email]": {
			required:function(element) {
		        if(jQuery.trim($("#ClientContactsWorkPhone").val())!='' || jQuery.trim($("#ClientContactsCellPhone").val())!=''){
			        return false;
		        }else{
			        return true;
		        } 
		     },
			email:true
		},
		"data[ClientContacts][WorkPhone]": {
			required:function(element) {
		        if(jQuery.trim($("#ClientContactsEmail").val())!='' || jQuery.trim($("#ClientContactsCellPhone").val())!=''){
			        return false;
		        }else{
			        return true;
		        } 
		     },
		},
		"data[ClientContacts][CellPhone]": {
			required:function(element) {
				 if(jQuery.trim($("#ClientContactsEmail").val())!='' || jQuery.trim($("#ClientContactsWorkPhone").val())!=''){
				        return false;
			        }else{
				        return true;
			        } 
		     },
		},
		"data[ClientContacts][City]": {
			required:true
		},
		"data[ClientContacts][State]": {
			required:true
		},
		"data[ClientContacts][PostalCode]": {
			required:true
		},
		"data[ClientContacts][Country]": {
			required:true
		},
		"data[ClientContacts][Department]": {
			required:true
		},
	}
});
jQuery.extend(jQuery.validator.messages, {
    required: "*required",	
});

if ($('#searchbox').val() != '' ) {
	//$('#ClientFrmIndexForm').submit();
}

function closePopup(){
	$('.ui-front').remove();
	return false;
}
</script>
	</div>
</div>
