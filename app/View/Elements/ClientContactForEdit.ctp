<tr>
	<td colspan="2">
		<div class="titletxt" id="" >
			Client Contacts</div>
		<?php $id=$this->params['pass'][0]; 
		echo $this->Html->link(
				$this->Html->image("addcontact.png", array("alt" => "Cancel","style"=>"float:right;margin-right:3%;margin-top:-2%;margin-bottom:1%;","class"=>"client_contact","data-val"=>$id)),
				"javascript:",
				array('escape' => false)
						);?>

		<div class="displayResults" style="max-height: 200px;overflow: auto;">
			<table class="tablesorter" id="ClentContactsTable" cellspacing="0">
				<thead>
					<tr>
						<th>Contact Name</th>
						<th>Contact Title</th>
						<th>Email</th>
						<th>Work Phone</th>
						<th>Cell Phone</th>
						<th>Fax</th>
						<th>Address1</th>
						<th>Address2</th>
						<th>City</th>
						<th>State</th>
						<th>Postal Code</th>
						<th>Country</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($Client_Contact)>0){
								foreach($Client_Contact as $ckey=>$cval){?>
					<tr>
						<td><?php echo $cval['ClientContacts']['ContactName']?>
						</td>
						<td><?php echo $cval['ClientContacts']['ContactTitle']?>
						</td>
						<td><?php echo $cval['ClientContacts']['Email']?>
						</td>
						<td><?php echo $cval['ClientContacts']['WorkPhone']?>
						</td>
						<td><?php echo $cval['ClientContacts']['CellPhone']?>
						</td>
						<td><?php echo $cval['ClientContacts']['Fax']?>
						</td>
						<td><?php echo $cval['ClientContacts']['AddressLine1']?>
						</td>
						<td><?php echo $cval['ClientContacts']['AddressLine2']?>
						</td>
						<td><?php echo $cval['ClientContacts']['City']?>
						</td>
						<td><?php echo $cval['ClientContacts']['State']?>
						</td>
						<td><?php echo $cval['ClientContacts']['PostalCode']?>
						</td>
						<td><?php echo $cval['ClientContacts']['Country']?>
						</td>
						<td class="headerRight"><a href='javascript:'
							class='edit_client_contact'
							data-val="<?php echo $cval['ClientContacts']['ID']?>">edit</a> |
							<a onclick = "return Delete()"
							href='<?php echo $this->Html->url("/")?>Client/deleteClientContact?deleteid=<?php echo $cval['ClientContacts']['ID']?>'>delete</a>
						</td>
					</tr>
					<?php }
						
					 }else{
						?>
				</tbody>
				<tr>
					<td colspan="13" class="headerRight">No Contacts found. Please click the "Add Contact" button to add a contact.
					</td>
				</tr>
				<?php }
				?>
			</table>
		</div>
		</td></tr>

<script type="text/javascript">

$(document).ready(function(){
	$('#ClentContactsTable').tablesorter({ headers: { 12: { sorter: false  } }});	
});

$('.edit_client_contact').click( function() {
	 var id=$(this).attr("data-val");
	 $.get( "<?php echo $this->Html->url("/")?>Client/ClientContactDetails/?editid="+id ,  function ( data ) {
			var contacts_data = jQuery.parseJSON(data);

			$('#addclientname').text(contacts_data.Client.Name);
			$('#ClientContactsClientName').val(contacts_data.Client.Name);
			$('#ClientContactsClientID').val(contacts_data.Client.ID);
			
			//alert(contacts_data.ClientContacts.ClientName);
			$('#addclientname').text(contacts_data.ClientContacts.ClientName);
			$('#ClientContactsClientName').val(contacts_data.ClientContacts.ClientName);
			$('#ClientContactsClientID').val(contacts_data.ClientContacts.ClientID);
			$('#ClientContactsID').val(contacts_data.ClientContacts.ID);
			$('#ClientContactsContactName').val(contacts_data.ClientContacts.ContactName);
			$('#ClientContactsContactTitle').val(contacts_data.ClientContacts.ContactTitle);
			$('#ClientContactsEmail').val(contacts_data.ClientContacts.Email);
			$('#ClientContactsWorkPhone').val(contacts_data.ClientContacts.WorkPhone);
			$('#ClientContactsCellPhone').val(contacts_data.ClientContacts.CellPhone);
			$('#ClientContactsFax').val(contacts_data.ClientContacts.Fax);
			$('#ClientContactsAddressLine1').val(contacts_data.ClientContacts.AddressLine1);
			$('#ClientContactsAddressLine2').val(contacts_data.ClientContacts.AddressLine2);
			$('#ClientContactsCity').val(contacts_data.ClientContacts.City);
			$('#ClientContactsState').val(contacts_data.ClientContacts.State);
			$('#ClientContactsPostalCode').val(contacts_data.ClientContacts.PostalCode);
			$('#ClientContactsCountry').val(contacts_data.ClientContacts.Country);
			$('#ClientContactsDepartment').val(contacts_data.ClientContacts.Department);
			$('#ClientContactsExtensionNo').val(contacts_data.ClientContacts.ExtensionNo);
			//$('#ClientContactsIndexForm').val();
	 });
	 $(function() {
		 $( "#add_client_contact" ).dialog({
		 width:850,
		 title : 'Edit Client Contact',
		 modal: true
		 });
		 });
});	

function Delete(){
	var x = confirm("Do you want to delete this record ?");
			if(x)
				return true;
			else
				return false;
}
											
</script>
