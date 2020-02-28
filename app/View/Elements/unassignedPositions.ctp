<?php if(!empty($unassignedPositionList)){?>
<div class="titletxt" id="" >Unassigned Positions:</div>
<div class="displayResults" style="max-height: 200px; overflow: auto;">
	<table class="tablesorter" id="" cellspacing="0">
		<thead>
			<tr>
				<th>Client Name</th>
				<th>Project Name</th>
				<th>Requisition Number</th>
				<th>Role</th>
				<th>Track</th>
				<th>Work Location</th>
				<th>No. of Position</th>
				<th width="25%">Essential Skills</th>
				<th class="headerRight">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($unassignedPositionList as $ckey=>$cval){ ?>
			<tr>
				
				<td><?php echo $cval["Client"]["Name"]?></td>
				<td><?php echo $cval["Project"]["Name"]?></td>
				<td><?php echo $cval["Position"]["RequisitionNumber"]?></td>
				<td><?php echo $cval["Position"]["Role"]?></td>
				<td><?php echo $cval["Position"]["Track"]?></td>
				<td><?php echo $cval["Position"]["WorkLocation"]?></td>
				<td><?php echo $cval["Position"]["NoOfPosition"]?></td>
				<td><?php echo $cval["Position"]["EssentialSkills"]?></td>
				<td class="headerRight"><a href="<?php $this->Html->url("/")?>?positionid=<?php echo $cval["Position"]["ID"] ?>">Select</a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php }?>
