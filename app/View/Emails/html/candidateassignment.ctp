Hi <?php echo $manager['User']['FirstName']." ".$manager['User']['LastName']?>,<br>

   <p style="padding-left: 25px">A Candidate has been assigned to the position you created. The details are as follows :</p>
   
		 <table style="padding-left: 50px">
		  <tr>
		    <td style="font-weight: bold;">Client Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $position['Client']['Name']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Project Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $position['Project']['Name']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Primary Recruiter</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $position['User']['fullName']?></td>
		  </tr>
		  <tr>
            <td style="font-weight: bold;">Role</td>
            <td style="font-weight: bold;">:</td>
            <td><?php echo $position['Position']['Role']?></td>
          </tr>
		  <tr>
		    <td style="font-weight: bold;">Requisition Number</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo substr_replace($position['Position']['RequisitionNumber'], "-", -3,0);?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Candidate Name</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['FirstName']." ".$candidate['Candidate']['LastName']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Current Location</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['City'].", ".$candidate['Candidate']['State']?></td>
		  </tr>
		  <?php $cost = "";
		   	if(!empty($candidate['Candidate']['Amount'])){
		  			if($candidate['Candidate']['CompensationPeriod'] == "W2 - Salary"){
						$cost = (($candidate['Candidate']['Amount']) * Configure::read("SalaryCalculation.MF")) /Configure::read("SalaryCalculation.HY");
					}
					else if($candidate['Candidate']['CompensationPeriod'] == "W2 - Hourly"){
						$cost = (($candidate['Candidate']['Amount']) * Configure::read("SalaryCalculation.MF"));
					}
					else{
						$cost = $candidate['Candidate']['Amount'];
					}
					$cost = number_format($cost, 2, '.', ',');
		 	 }
		  $candidate['Candidate']['Amount'] = number_format($candidate['Candidate']['Amount'], 2, '.', ',');?>
		    <tr>
		  	<td style="font-weight: bold;">Cost to company:</td>
		  	<td style="font-weight: bold;">:</td>
		    <td><?php echo $cost; ?></td>
		  </tr>
		  <tr>
		  	<td style="font-weight: bold;">Rate</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['Currency']." ".$candidate['Candidate']['Amount']?></td>
		  </tr>
		  <tr>
		  	<td style="font-weight: bold;">Type</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['CompensationPeriod']?></td>
		  </tr>
		   <tr>
		  	<td style="font-weight: bold;">Availability for an interview:</td>
		  	<td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['LeadTimeForInterview']?></td>
		  </tr>
		   <tr>
		  	<td style="font-weight: bold;">Availability to start if found suitable</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['LeadTime']?></td>
		  </tr>
		  <tr>
		    <td style="font-weight: bold;">Contact</td>
		    <td style="font-weight: bold;">:</td>
		    <td><?php echo $candidate['Candidate']['ContactPhone'].", ".$candidate['Candidate']['Email']?></td>
		  </tr>
		</table>
		<br>

Thanks