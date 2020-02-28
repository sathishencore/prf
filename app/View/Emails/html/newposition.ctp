Hi Everyone,<br>

   <p style="padding-left: 25px">A new position has been created. The position details are as follows :</p>
   
		 <table style="padding-left: 50px">
		  <tr>
		    <td style="font-weight: bold;">Client Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['Client']['Name']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Project Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['Project']['Name']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Requisition Number</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo substr_replace($content_data['Position']['RequisitionNumber'], "-", -3,0);?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Role</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['Position']['Role']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Location</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $content_data['Position']['WorkLocation']?></td>
		  </tr>
		</table>
		<br>

Thanks
