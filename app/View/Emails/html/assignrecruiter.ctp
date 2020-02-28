Hi Everyone,<br>

   <p style="padding-left: 25px">A new recruiter has been assigned. The assignment details are as follows :</p>
   
		 <table style="padding-left: 50px">
		  <tr>
		    <td style="font-weight: bold;">Client Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['client'];?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Project Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['project'];?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Requisition Number</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo substr_replace($content_data['requistion_no'], "-", -3,0);?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Role</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['role'];?></td>		    
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Primary Recruiter</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['primary_recruiter'];?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Secondary Recruiter</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['secondary_recruiter'];?></td>		    
		  </tr>
		</table>
		<br>

Thanks
