<div class="titlebg" id="titlebg">
<div class="titletxt">Search</div>
<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
<div class="content" id="searchUser" style="min-height: 200px;">
<?php $sts=array(); ?>
<!--<ul>
	<li><a href="#basicSearch">Basic Search</a></li>
	<li><a href="#advSearch">Advanced Search</a></li>
</ul>
<div class="content-mid" id="basicSearch"><label style="float: left;">Search
by Role : &nbsp;</label> <?php echo $this->Form->create("UserFrm",array("url"=>array("controller"=>"Users","action"=>"index")));?>
<?php echo $this->Form->select("searchbox",$roleList,array("id"=>"searchbox","style"=>"width:250px;","onchange"=>"checkval(this.value);","empty"=>"All"));?>
<?php echo $this->Form->select("statusbox",$statusList,array("id"=>"statusbox","style"=>"width:250px;","onchange"=>"checkval(this.value);","empty"=>"All"));?>
<?php echo $this->Form->end();?>

<div class="clear">&nbsp;</div>
</div>-->
<div class="content-mid" id="advSearch">
<form action="" method="post" id="searchAdvForm">
<table>
	<tr>
		<td>Username</td>
		<td>:</td>
		<td><?php echo $this->Form->select("UserNamelist",$UserNamelist,array("id"=>"UserNamelist","style"=>"width:250px;","empty"=>"All"));?>
		</td>
		<td>Email</td>
		<td>:</td>
		<td><?php echo $this->Form->input("Email",array("div"=>false,"label"=>false));?>
		</td><td>&nbsp;</td>
		<td>Role</td>
		<td>:</td>
		<td><?php echo $this->Form->select("searchbox1",$roleList,array("id"=>"searchbox","style"=>"width:250px;","empty"=>"All"));?>
		</td>
		
	</tr>
	<tr>
	<td>Status</td>
		<td>:</td>
		<td><?php 
		$sts = array('active' => 'Active', 'inactive' => 'Inactive');
		echo $this->Form->select("statusbox1",$sts,array("id"=>"statusbox","style"=>"width:250px;","empty"=>"All",'default' => 'active'));
		//$sts = ['all' => 'All', 'active' => 'Active', 'inactive' => 'Inactive'];
		//echo $this->Form->select('statusbox1', ['all' => 'All', 'active' => 'Active', 'inactive' => 'Inactive'], ['default' => 'active']); 
		?>
		</td>
		<td>&nbsp;</td>
		<td><?php echo $this->Form->submit("Search")?></td>
		<td><?php echo $this->Form->submit("Clear",array("type"=>"button","id"=>"clearBtn","onclick"=>"window.location.href=''"))?>
		</td>
	</tr>
</table>
</form>
<div class="clear">&nbsp;</div>
</div>
<div class="displayResults" style="">
<table class="tablesorter" cellspacing="0">
	<thead>
		<tr>
			<th>Login Name</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Role</th>
			<th>Location</th>
			<th>Status</th>
			<th class="headerRight">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($UserList)>0){
		$i=1;
		foreach($UserList as $ckey=>$cval){

			?>
		<tr>
			<td><?php echo $cval['User']['LoginName']?></td>
			<td><?php echo $cval['User']['FirstName']?></td>
			<td><?php echo $cval['User']['LastName']?></td>
			<td><?php echo $cval['User']['Email']?></td>
			<td><?php echo $cval['User']['Mobile']?></td>
			<td><?php echo $roleList[$cval['User']['RoleId']]?></td>
			<td><?php if( (!empty($cval['User']['TimezoneID'])) && ($cval['User']['TimezoneID']=='79') ) {
echo "India";
}
else {
echo "US";
}
//(!empty($cval['User']['TimezoneID']))?$timezone[$cval['User']['TimezoneID']]:"-"
?>
			</td>
			<td><?php echo $cval['User']['StatusFlag'];?></td>
			<td class="headerRight"><?php echo $this->Html->link("reset password",array('controller' => 'Users', 'action' => 'resetpassword', (int)$cval['User']['ID']));?>
			| <?php echo $this->Html->link("edit",array('controller' => 'Users', 'action' => 'index', (int)$cval['User']['ID']));?>
			 <?php // echo $this->Html->link("delete",array('controller' => 'Users', 'action' => 'delete', (int)$cval['User']['ID']),array(),"Do you want to delete this record ?");?>
			<?php
			$Full_Name = $cval['User']['FirstName'].$cval['User']['LastName'];
			if( ($cval['User']['RoleId']==5) || ($cval['User']['RoleId']==1) || ($cval['User']['RoleId']==10) ) {
				if($cval['User']['StatusFlag']=='Active'){
					$disp_text='Inactivate';
				}else{
					$disp_text='Activate';
				} 
				?> | <?php echo $this->Html->link($disp_text,false,array("class"=>"setStatus","title"=>"$disp_text","degn"=>$cval['User']['RoleId'],"data-val"=>$cval['User']['ID'],"data-nam"=>$Full_Name,"data-mail"=>$cval['User']['Email']));?>
				<?php
			}
			?>
			</td>
		</tr>
		<?php
		$i++;
		}
	}else{
		?>
	</tbody>
	<tr>
		<td colspan="9" style="text-align: center" class="headerRight">No
		Records found</td>
	</tr>

	<?php }
	?>
</table>
</div>
</div>
</div>
<div id="dialog-modal" title="Alert">
		<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;"></h1>
		<!-- <label id="projectname" style="font-size: 130%;"></label> Details</h1>
			<table cellspacing="5" cellpadding="5" style="margin-left: 7%">
				<tr>
					<td style="font-weight: bold;">Client Name</td>
					<td>:</td>
					<td><label id="clientname"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Start Date</td>
					<td>:</td>
					<td><label id="startdate"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">End Date</td>
					<td>:</td>
					<td><label id="enddate"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Client Project Owner</td>
					<td>:</td>
					<td><label id="clientcontact"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Client Project Manager</td>
					<td>:</td>
					<td><label id="pm"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Billing Type</td>
					<td>:</td>
					<td><label id="billing"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Status</td>
					<td>:</td>
					<td><label id="status"></label></td>
				</tr>
				<tr>
					<td colspan="3"><?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"closePopup()"));?></td>
				</tr>Please assign the position to another recruiter, as we have open/potential positions
			</table> -->

		</div>
		<div id="dialog-modal-deactive-rec" title="Alert">
		
		<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
<br>
		Recruiter Deactivated Successfully</h1>
		</div>
		<div id="dialog-modal-active-rec" title="Alert">
		
		<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
<br>
		Recruiter Activated Successfully</h1>
		</div>
		<div id="dialog-modal-assign-rec" title="Alert">&nbsp;</div>
		
		<div id="dialog-modal-assign-acc" title="Alert">&nbsp;</div>
<div id="dialog-modal-deactive-acc" title="Alert">&nbsp;
<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
		Account Manager Deactivated Successfully</h1></div>
<div id="dialog-modal-active-acc" title="Alert">&nbsp;
<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
		Account Manager Activated Successfully</h1></div>
		
		<div id="dialog-modal-deactive-pl" title="Alert">&nbsp;
<h1 style="font-size: 100%;margin-left: 11px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
		Project Lead Deactivated Successfully</h1></div>
<div id="dialog-modal-active-pl" title="Alert">&nbsp;
<h1 style="font-size: 100%;margin-left: 12px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
		Project Lead Activated Successfully</h1></div>
<script>
var arr_ids = [];
var arr_names = [];
var arr_ids_acc = [];
var arr_names_acc = [];
$(document).ready(function(){
var arr;	
var arr1;	
//$('table').tablesorter({ headers: { sorter: true  } });
$('table').tablesorter({ headers: { 8: { sorter: false  } }});
	$('#dialog-modal-rec').hide();
	$('#dialog-modal-success-rec').hide();
	$('#dialog-modal-deactive-rec').hide();
	$('#dialog-modal-active-rec').hide();

	$('#dialog-modal-deactive-acc').hide();
	$('#dialog-modal-active-acc').hide();
	
	$('#dialog-modal-deactive-pl').hide();
	$('#dialog-modal-active-pl').hide();
	$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Users/getRecruiters");?>",
		 data: { userId:"5" },
		 dataType: "json",
		 success: function (result1) {
			// alert(result1);
			  arr = result1;
			$.each(result1, function( index, value ) {
			//	alert( index + ": " + value );
				arr_ids.push(index);
				arr_names.push(value);
				});

		 }
  });

	$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Users/getAccmanager");?>",
		 data: { userId:"5" },
		dataType: "json",
		 success: function (result12) {
			
			 arr1  = result12;
			 for(x in result12) {
				 //console.log(x.split(","));
				 //console.log(result1[x]);
				 arr_ids_acc.push(x);
				 arr_names_acc.push(result12[x])
			 }
			 //console.log(arr_ids);
			// console.log(arr_names);
			//	for(x in arr1) {
		//alert(arr1[x]);
	 //}
  	 }
});
	
	$(".setStatus").click(function(){		
	if($(this).attr("degn")=='5'){	
		//alert("Recruiter");	
		var x=confirm("Do you want to "+$(this).attr("title")+" this Recruiter ?");
		
		if(x){
			if($(this).attr("title")=='Inactivate'){
				 $.ajax({
					 type: "POST",
					 url: "<?php echo $this->Html->url("/Users/checkRecruiter");?>",
					 data: { userId:$(this).attr("data-val") },
					 dataType: "json",
					 success: function (result) {
					// alert(result);
					 if($.isNumeric(result))  {
						 $(function() {
	     						
							 $( "#dialog-modal-deactive-rec" ).dialog({
								 width:320,
								 height:120,
							 	 modal: true
							 });
						});
					setTimeout(function(){location.reload();},2000);
					
					 }
            // alert(result.length);
            else{
              var users = ""; 
              var ops = "";
             users +="<form name='req_form' id='req_form' action='<?php echo $this->Html->url('/Users/assignrec');?>' onSubmit='return ((validateformRec()));'  ><label id='projectname' style='font-size: 110%;margin-left:4%;color: #be5e00;'><br>&nbsp;&nbsp;&nbsp;&nbsp;The following Positions are currently assigned to the Inactivated Recruiter. Please assign them to another Recruiter. </label></h1>";
                users +="<br><table cellspacing='7' cellpadding='7' style='margin-left: 4%;margin-top:4%;'>";
            users += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Project</td><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Position</td><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Select Recruiter</td></tr>";
				//alert(arr_ids.length);
				remove_id = result[0].User['ID'];
				remove_name = result[0].User['fullName'];
				//var rid = arr_ids;
				//var rname = arr_names;
				for(x in arr) {
						if(arr[x]!=result[0].User['fullName']) {
						ops += "<option  value='"+x+"'  >"+arr[x]+"</option>";
						}
					 }
				
                 var f;
                 var proname = [];   
                 
              //   alert(proname);
                      for (var i = 0; i < result.length; i++) {
                          var pre = i-1;
                          if(i==0){
                        	  users += "<tr><td> <input type='text' style='width:290px;' title='"+result[i].Project['Name']+"' value='"+result[i].Project['Name']+"' name='proj_name"+i+"'  readonly ></td>";
                              users += "<td><input type='hidden' value='"+result[i].Position['RequisitionNumber']+"' name='req_name"+i+"' ><input type='text' title='"+result[i].Position['Role']+"' value='"+result[i].Position['Role']+"' name='role_name"+i+"' style='width:260px;'  readonly ></td>";  
                              users += "<td><select name='sel_rec"+i+"' class='sel_rec'><option value='0'>---Select---</option>"+ops+"</select><input type='hidden' value='"+result[i].Position['ID']+"' name='pos_id"+i+"' ></td><input type='hidden' value='"+result[i].User['ID']+"' name='user_id' ></td>";
                              users += "</tr>";  
                               f = i+1;			
                          }
                          else {
                          if(result[pre].Project['Name']==result[i].Project['Name']) {
                        	  users += "<tr><td>&nbsp;</td>";
                              users += "<td><input type='hidden' value='"+result[i].Position['RequisitionNumber']+"' name='req_name"+i+"' ><input type='text' title='"+result[i].Position['Role']+"' value='"+result[i].Position['Role']+"' name='role_name"+i+"' style='width:260px;'  readonly ></td>";  
                              users += "<td><select name='sel_rec"+i+"' class='sel_rec'><option value='0'>---Select---</option>"+ops+"</select><input type='hidden' value='"+result[i].Position['ID']+"' name='pos_id"+i+"' ></td><input type='hidden' value='"+result[i].User['ID']+"' name='user_id' ></td>";
                              users += "</tr>";  
                               f = i+1;
                          }
                          else{
                        users += "<tr><td> <input type='text' style='width:290px;' title='"+result[i].Project['Name']+"' value='"+result[i].Project['Name']+"' name='proj_name"+i+"'  readonly ></td>";
                        users += "<td><input type='hidden' value='"+result[i].Position['RequisitionNumber']+"' name='req_name"+i+"' ><input type='text' title='"+result[i].Position['Role']+"' value='"+result[i].Position['Role']+"' name='role_name"+i+"' style='width:260px;'  readonly ></td>";  
                        users += "<td><select name='sel_rec"+i+"' class='sel_rec'><option value='0'>---Select---</option>"+ops+"</select><input type='hidden' value='"+result[i].Position['ID']+"' name='pos_id"+i+"' ></td><input type='hidden' value='"+result[i].User['ID']+"' name='user_id' ></td>";
                        users += "</tr>";  
                         f = i+1;
                          }
                      }
               
                 }
                         users +="<tr><td colspan='4'><input type='hidden' name='hh' value='"+f+"'><input type='submit' style='float:right;' name='req' id='req' value='Assign'  ></td></tr></table></form>";
                         
                         $('#dialog-modal-assign-rec').html(users); 
                         
                         $(function() {
     						
							 $( "#dialog-modal-assign-rec" ).dialog({
								 width:1000,
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
					 url: "<?php echo $this->Html->url("/Users/activateRecruiter");?>",
					 data: { userId:$(this).attr("data-val") },
					// dataType: "json",
					 success: function (result) {
			//		 alert(result);
			//alert(result);
          // alert(result.length);
						 $(function() {
	     						
							 $( "#dialog-modal-active-rec" ).dialog({
								 width:300,
								 height:120,
							 	 modal: true
							 });
						});
						setTimeout(function(){location.reload();},2000);
						
				}
     
          });

				
					
			}
			return false;
		}
	}
	if($(this).attr("degn")=='1'){	
		//alert("Acc");	
		var x=confirm("Do you want to "+$(this).attr("title")+" this Account Manager ?");
		if(x){
			if($(this).attr("title")=='Inactivate'){
				//alert($(this).attr("title"));
				 $.ajax({
					 type: "POST",
					 url: "<?php echo $this->Html->url("/Users/checkAccmanager");?>",
					 data: { userId:$(this).attr("data-val"),userName:$(this).attr("data-nam"),userMail:$(this).attr("data-mail") },
				dataType: "json",
					 success: function (result_acc) {
					//alert(result_acc);
					 if($.isNumeric(result_acc))  {
						// alert("in if part");
						 $(function() {
	     						
							 $( "#dialog-modal-deactive-acc" ).dialog({
								 width:380,
								 height:150,
							 	 modal: true
							 });
						});
					setTimeout(function(){location.reload();},2000);
					
					 }
					 else {
						//alert("In else part");
					 var users_acc = ""; 
		              var ops_acc = "";
		             users_acc +="<form name='req_form' id='req_form' action='<?php echo $this->Html->url('/Users/assignAcc');?>' onSubmit='return ((validateformAcc()));'  ><label id='projectname' style='font-size: 110%;margin-left:4%;color: #be5e00;'><br>The following Projects are currently assigned to the Inactivated Account Manager. Please assign them to another Account Manager. </label></h1>";
		                users_acc +="<table cellspacing='7' cellpadding='7' style='margin-left: 5%;margin-top:4%;'>";
		                users_acc += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Project</td><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Select Account Manager</td></tr>";
						//alert(arr_ids.length);
						//remove_name = result_acc[0].EncoreContacts['ContactName'];
						//var rid = arr_ids;
						//var rname = arr_names;
					//alert("firn"+result_acc[0].Users['FirstName']+" "+result_acc[0].Users['LastName']);
					var accn = result_acc[0].Users['FirstName']+" "+result_acc[0].Users['LastName'];
					for(x in arr1) {
						if(arr1[x]!=accn) {
						ops_acc += "<option  value='"+x+"'  >"+arr1[x]+"</option>";
						}
					 }
					//users_acc += "<tr><td style='font-weight: bold;font-size:14px;'>Project&nbsp;Name</td>";
		                 // users_acc += "<td>:</td>";
		                 var f;
		                          for (var i = 0; i < result_acc.length; i++) { 
		                  
		                  users_acc += "<tr><td><input type='text' style='width:290px;' title='"+result_acc[i].Project['Name']+"' value='"+result_acc[i].Project['Name']+"' name='pro_name"+i+"'  readonly ></td>";  
		                  users_acc += "<td><select name='sel_acc"+i+"' class='sel_acc'><option value='0'>---Select---</option>"+ops_acc+"</select></td>";
		                  users_acc += "<td><input type='hidden' value='"+result_acc[i].Project['ID']+"' name='pro_id"+i+"' ></td>"; 
		                  users_acc += "<td><input type='hidden' value='"+result_acc[i].Users['ID']+"' name='enc_id' ></td>";
		                  users_acc += "<td><input type='hidden' value='"+result_acc[0].Users['fullName']+"' name='enc_name' ></td>";
		                  users_acc += "<td><input type='hidden' value='"+result_acc[0].Users['Email']+"' name='enc_mail' ></td>";
		                  users_acc += "</tr>";
		                  f = i+1; 
		                  
		                 }
		                         users_acc +="<tr><td colspan='4'><input type='hidden' name='hh' value='"+f+"'><input type='submit' style='float:right;' name='req' id='req' value='Assign'  ></td></tr></table></form>";
		                         
            // alert(result_acc.length);
		                         $('#dialog-modal-assign-acc').html(users_acc); 
		                         
		                         $(function() {
		     						
									 $( "#dialog-modal-assign-acc" ).dialog({
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
					 success: function (result_acc) {
			//		 alert(result_acc);
			//alert(result_acc);
         // alert(result_acc.length);
						 $(function() {
	     						
							 $( "#dialog-modal-active-acc" ).dialog({
								 width:350,
								 height:150,
							 	 modal: true
							 });
						});
			setTimeout(function(){location.reload();},2000);	
			
				}
    
         });

				
					
			}
			
			return false;
		}
	}
/* For Project Lead*/ 
	if($(this).attr("degn")=='10'){	
		//alert("Acc");	
		var x=confirm("Do you want to "+$(this).attr("title")+" this Project Lead ?");
		if(x){
			if($(this).attr("title")=='Inactivate'){
				//alert($(this).attr("title"));
				 $.ajax({
					 type: "POST",
					 url: "<?php echo $this->Html->url("/Users/inactivateProjectlead");?>",
					 data: { userId:$(this).attr("data-val"),userName:$(this).attr("data-nam"),userMail:$(this).attr("data-mail") },
					// dataType: "json",
					 success: function (result_pl) {
					//alert(result_acc);
					 
						 $(function() {
	     						
							 $( "#dialog-modal-deactive-pl" ).dialog({
								 width:340,
								 height:150,
							 	 modal: true
							 });
						});
					setTimeout(function(){location.reload();},2000);
					
					
					
				}
       
            });

				
					
			}
			if($(this).attr("title")=='Activate'){
				
				 $.ajax({
					 type: "POST",
					 url: "<?php echo $this->Html->url("/Users/activateProjectlead");?>",
					 data: { userId:$(this).attr("data-val") },
					// dataType: "json",
					 success: function (result_pl) {
			//		 alert(result_acc);
			//alert(result_acc);
         // alert(result_acc.length);
						 $(function() {
	     						
							 $( "#dialog-modal-active-pl" ).dialog({
								 width:330,
								 height:150,
							 	 modal: true
							 });
						});
			setTimeout(function(){location.reload();},2000);	
			
				}
    
         });

				
					
			}
			
			return false;
		}
	}
	/* else{
			return false;
		} */
	});		

	
	
});

function validateformRec() {
	
	var xx = document.getElementsByClassName("sel_rec");
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
function validateformAcc() {
	
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
