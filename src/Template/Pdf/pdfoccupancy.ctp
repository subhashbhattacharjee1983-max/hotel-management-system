<?php
$this->assign('title', 'Room Occupancy Report');
$website_logo_folder = 'logo_folder';
$upload_folder = 'hotel';
if(isset($site_general_settings->website_logo) && trim($site_general_settings->website_logo)!='' && file_exists(WWW_ROOT.$upload_folder. "/".$website_logo_folder."/".$site_general_settings->website_logo))
{
	$site_logo='/'.$upload_folder.'/'.$website_logo_folder.'/'.$site_general_settings->website_logo;
}
else
{
	$site_logo='/images/logo.png';
}
?>
<style type="text/css">
	table td {
		padding:5px 0;
		font-size: 10px;
		text-align: center;
		width: 25%;
	}
	table th {
		padding:5px 0;
		font-size: 10px;
		text-align: center;
		width: 25%;
	}
</style>
<?php ob_start(); ?>				
	<div style="width: 100%; text-align: center;">
		<div style="margin-bottom:15px;">
			<?php echo $this->Html->image($site_logo, ['alt' => $site_general_settings->website_name, 'border' => '0', 'style' => 'width: 25%; margin-top: -4%;'])?>
		</div>
		<div style="margin-bottom:15px; font-size:19px;">Room Occupancy Report</div>
	</div>
	<div style="width: 100%;">
	<?php 
	if(!empty($room))
	{
	?>
	<table border="1" style="width: 100%;" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Room Number</th>
				<th>Number Of Days Occupied</th>
				<th>From Date</th>
				<th>To Date</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$i=0;
		if(!empty($room))
		{
			foreach ($room as $val):
				$total_room = $this->Common->total_room_occupancy($val->room_number, $start_date_occupancy, $end_date_occupancy);
		?>
			<tr>
				<td><?php echo $val->room_number; ?></td>														
				<td><?php echo $total_room; ?></td>
				<td><?php echo $start_date_occupancy; ?></td>
				<td><?php echo $end_date_occupancy; ?></td>
			</tr>
		<?php 
			endforeach;
		}
		?>
		</tbody>
	</table>
	<?php
	}
	?>
	</div>
	<?php $ext_add = ob_get_clean();
	echo $ext_add; 
	?>