<div class="titlebg" id="titlebg">
<div class="titletxt">ENCORE CONTACTS LIST</div>
<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchClient" style="min-height: 200px;">
		<div class="content-mid" id="basicSearch"></div>
		<div class="displayResults" style="max-height: 300px; overflow: auto;">
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
						<th>Status</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($Encore_Contact)>0){
								foreach($Encore_Contact as $ckey=>$cval){?>
					<tr>
						<td><?php echo $cval['EncoreContacts']['ContactName']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['ContactTitle']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['Email']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['WorkPhone']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['CellPhone']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['Fax']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['AddressLine1']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['AddressLine2']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['City']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['State']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['PostalCode']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['Country']?>
						</td>
						<td><?php echo $cval['EncoreContacts']['StatusFlag']?>
						</td>
						<td class="headerRight"><?php echo $this->Html->link("edit",array('controller' => 'Users', 'action' => 'encore', (int)$cval['EncoreContacts']['ID']));?> |
						
						<?php
						if($cval['EncoreContacts']['StatusFlag']=='Active'){
								$disp_text='Inactivate';
								}else{
								$disp_text='Activate';
							}
						 	echo $this->Html->link($disp_text,false,array("class"=>"setStatus","title"=>"$disp_text","data-val"=>$cval['EncoreContacts']['ID'],"data-nam"=>$cval['EncoreContacts']['ContactName'],"data-mail"=>$cval['EncoreContacts']['Email']));?>
						</td>
					</tr>
					<?php }

					 }else{
						?>
				</tbody>
				<tr>
					<td colspan="13" class="headerRight">No Contacts found. Please
						click the "Add Contact" button to add a contact.</td>
				</tr>
				<?php }
				?>
			</table>
		</div>
	</div>
</div>
<div id="dialog-modal-assign" title="Alert">&nbsp;</div>
<div id="dialog-modal-deactive" title="Alert">&nbsp;
<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
		Account Manager Deactivated Successfully</h1></div>
<div id="dialog-modal-active" title="Alert">&nbsp;
<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
		Account Manager Activated Successfully</h1></div>
<script type="text/javascript">
function Delete(){
	var x = confirm("Do you want to delete this record ?");
			if(x)
				return true;
			else
				return false;
}
function Inactivate(){
	var x = confirm("Do you want to inactivate this contact ?");
			if(x)
				return true;
			else
				return false;
}
function Activate(){
	var x = confirm("Do you want to activate this contact ?");
			if(x)
				return true;
			else
				return false;
}
</script>
<script>
var arr_ids = [];
var arr_names = [];
var arr;
$(document).ready(function(){
$('table').tablesorter({ headers: { 13: { sorter: false  } }});
//$('table').tablesorter({ headers: { sorter: true  } });
	$('#dialog-modal-deactive').hide();
	$('#dialog-modal-active').hide();
	$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Users/getAccmanager");?>",
		 data: { userId:"5" },
		dataType: "json",
		 success: function (result1) {
			
			 arr  = result1;
			 for(x in result1) {
				 //console.log(x.split(","));
				 //console.log(result1[x]);
				 arr_ids.push(x);
				 arr_names.push(result1[x])
			 }
			 console.log(arr_ids);
			 console.log(arr_names);
   	 }
 });
	 
	$(".setStatus").click(function(){				
		var x=confirm("Do you want to "+$(this).attr("title")+" this manager ?");
		
      
		if(x){
			if($(this).attr("title")=='Inactivate'){
			
				 $.ajax({
					 type: "POST",
					 url: "<?php echo $this->Html->url("/Users/checkAccmanager");?>",
					 data: { userId:$(this).attr("data-val"),userName:$(this).attr("data-nam"),userMail:$(this).attr("data-mail") },
					 dataType: "json",
					 success: function (result) {
				//	alert(result);
					 if($.isNumeric(result))  {
						 $(function() {
	     						
							 $( "#dialog-modal-deactive" ).dialog({
								 width:380,
								 height:120,
							 	 modal: true
							 });
						});
					setTimeout(function(){location.reload();},2000);
					
					 }
					 else {
					 var users = ""; 
		              var ops = "";
		             users +="<form name='req_form' id='req_form' action='<?php echo $this->Html->url('/Users/assignAcc');?>' onSubmit='return ((validateform()));'  ><label id='projectname' style='font-size: 110%;margin-left:4%;color: #be5e00;'><br>The following Projects are currently assigned to the Inactivated Account Manager. Please assign them to another Account Manager. </label></h1>";
		                users +="<table cellspacing='7' cellpadding='7' style='margin-left: 5%;margin-top:4%;'>";
		                users += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Project</td><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Select Account Manager</td></tr>";
						//alert(arr_ids.length);
						remove_name = result[0].EncoreContacts['ContactName'];
						//var rid = arr_ids;
						//var rname = arr_names;
					
					for(x in arr) {
						if(arr[x]!=result[0].EncoreContacts['ContactName']) {
						ops += "<option  value='"+x+"'  >"+arr[x]+"</option>";
						}
					 }
					//users += "<tr><td style='font-weight: bold;font-size:14px;'>Project&nbsp;Name</td>";
		                 // users += "<td>:</td>";
		                 var f;
		                          for (var i = 0; i < result.length; i++) { 
		                  
		                  users += "<tr><td><input type='text' style='width:290px;' title='"+result[i].Project['Name']+"' value='"+result[i].Project['Name']+"' name='pro_name"+i+"'  readonly ></td>";  
		                  users += "<td><select name='sel_acc"+i+"' class='sel_acc'><option value='0'>---Select---</option>"+ops+"</select></td>";
		                  users += "<td><input type='hidden' value='"+result[i].Project['ID']+"' name='pro_id"+i+"' ></td>"; 
		                  users += "<td><input type='hidden' value='"+result[i].EncoreContacts['ID']+"' name='enc_id' ></td>";
		                  users += "<td><input type='hidden' value='"+result[0].EncoreContacts['ContactName']+"' name='enc_name' ></td>";
		                  users += "<td><input type='hidden' value='"+result[0].EncoreContacts['Email']+"' name='enc_mail' ></td>";
		                  users += "</tr>";
		                  f = i+1; 
		                  
		                 }
		                         users +="<tr><td colspan='4'><input type='hidden' name='hh' value='"+f+"'><input type='submit' style='float:right;' name='req' id='req' value='Assign'  ></td></tr></table></form>";
		                         
            // alert(result.length);
		                         $('#dialog-modal-assign').html(users); 
		                         
		                         $(function() {
		     						
									 $( "#dialog-modal-assign" ).dialog({
										 width:800,
										 height:450,
									 	 modal: true
									 });
								});
									
					 }
				}
       
            });

				
					
			}
			if($(this).attr("title")=='Activate'){
				
				 $.ajax({
					 type: "POST",
					 url: "<?php echo $this->Html->url("/Users/activateEncoreContact");?>",
					 data: { userId:$(this).attr("data-val"),userName:$(this).attr("data-nam"),userMail:$(this).attr("data-mail") },
					// dataType: "json",
					 success: function (result) {
			//		 alert(result);
			//alert(result);
         // alert(result.length);
						 $(function() {
	     						
							 $( "#dialog-modal-active" ).dialog({
								 width:350,
								 height:120,
							 	 modal: true
							 });
						});
			setTimeout(function(){location.reload();},2000);	
			
				}
    
         });

				
					
			}
			
			return false;
		}else{
			return false;
		}
	});		

	
	
});

function validateform() {
	
	var xx = document.getElementsByClassName("sel_acc");
	//alert(xx[0].value);
	for (var i = 0; i < xx.length; i++) {
		
	 if(xx[i].value=="0") {
		var err = "yes";
	}
	}
	if(err=="yes") {
		alert("Please enter all the details");
		return false;
	}
	return true;
}
</script>
