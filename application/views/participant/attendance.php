<head>
<style>
	th{
		color:white; background-color: #003000;
	}
	
	table{
		border: 1px solid #666633;
	}
	
	#bg{
		opacity: 0.5;
	}
</style>
</head>
<body>	
	<div class="title5"><?php echo $fullname; ?></div>

	<div class="title3">PAID COURSES</div>	
	<div class="content">
		<table class="viewtable" border="0">	
			<thead>
				<tr>
					<th style="width: 27%"><div>Name</div></th>
					<th style="width: 18%"><div>Start</div></th>
					<th style="width: 18%"><div>End</div></th>
					<th style="width: 21%"><div>Time</div></th>
					<th style="width: 16%"><div>Venue</div></th>
				</tr>
			</thead>
			<tbody>
				<?php for($i=0; $i<$count; $i++): ?>
					<div>
						<tr class="lin">
							<td class="dataf"><center><div><?php echo $names[$i]; ?></div></center></td>
							<td class="dataf"><center><div><?php echo $start[$i]; ?></div></center></td>
							<td class="dataf"><center><div><?php echo $end[$i]; ?></div></center></td>
							<td class="dataf"><center><div><?php echo $startTime[$i]." - ". $endTime[$i]; ?></div></center></td>
							<td class="dataf"><center><div><?php echo $venue[$i]; ?></div></center></td>
						</tr>
					</div>
				<?php endfor; ?>
			</tbody>	
		</table>
	</div>	
</body>