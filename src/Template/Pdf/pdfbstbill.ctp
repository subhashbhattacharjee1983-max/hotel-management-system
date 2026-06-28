<?php
$this->assign('title', 'BST Report');
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
	}
	table th {
		padding:5px 0;
		font-size: 10px;
		text-align: center;
	}
</style>
<?php ob_start(); ?>				
	<div style="width: 100%; text-align: center;">
		<div style="margin-bottom:15px;">
			<?php echo $this->Html->image($site_logo, ['alt' => $site_general_settings->website_name, 'border' => '0', 'style' => 'width: 25%; margin-top: -4%;'])?>
		</div>
		<div style="margin-bottom:15px; font-size:19px;">BST Report</div>
	</div>
	<div style="width: 100%;">
	<table border="1" style="width: 100%;" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Booking Number</th>
				<th>Customer Name</th>
				<th>Room Number</th>
				<th>Booking Date</th>
				<th>Bill Number</th>
				<th>Receipt Number</th>
				<th>BST Amount</th>
				<th>Total Bill Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$i=0;
		$all_room_amount = 0;
		$all_food_amount = 0;
		$all_bar_amount = 0;
		$all_house_kipping_amount = 0;
		$all_gross_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($booking_bst))
		{
			foreach ($booking_bst as $booking):
			$i++;
			$show_rooms = $this->Common->show_rooms($booking->id);
			$room_charge = round($booking->booking_price) * $booking->number_of_night; 
			$all_room_amount = $all_room_amount + $room_charge;
			$food_order_total_amount = $this->Common->food_order_total_amount($booking->id);
			$all_food_amount = $all_food_amount + $food_order_total_amount;
			$bar_order_total_amount = $this->Common->bar_order_total_amount($booking->id);
			$all_bar_amount = $all_bar_amount + $bar_order_total_amount;
			$house_keeping_total_amount = $this->Common->house_keeping_total_amount($booking->id);
			$all_house_kipping_amount = $all_house_kipping_amount + $house_keeping_total_amount;
			$gross_amount = $room_charge + $food_order_total_amount + $bar_order_total_amount + $house_keeping_total_amount;
			$all_gross_amount = $all_gross_amount + $gross_amount;
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			/*if($food_order_total_amount > 0 || $bar_order_total_amount > 0 || $house_keeping_total_amount > 0)
			{
				$bst_tax = round(($gross_amount * $site_general_settings->bst_tax)/100);
				$service_tax = round(($gross_amount * $site_general_settings->service_tax)/100);
				$gst_tax = round(($gross_amount * $site_general_settings->gst_tax)/100);
			}
			else
			{*/
				if($booking->allow_bst == "Y")
				{
					$bst_tax = round(($gross_amount * $booking->bst_tax)/100);
				}
				if($booking->allow_service_charge == "Y")
				{
					$service_tax = round(($gross_amount * $booking->service_tax)/100);
				}
				if($booking->allow_gst == "Y")
				{
					$gst_tax = round(($gross_amount * $booking->gst_tax)/100);
				}
			//}
			$all_bst_tax = $all_bst_tax + $bst_tax;
			$all_service_tax = $all_service_tax + $service_tax;
			$all_gst_tax = $all_gst_tax + $gst_tax;
			$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax;
			$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
		?>
			<tr>
				<td><?php echo h($booking->id); ?></td>														
				<td><?php echo h($booking->customer->full_name); ?></td>
				<td><?php echo $show_rooms; ?></td>
				<td><?php echo $this->Common->entry_date($booking->booking_date);?></td>
				<td>BILL-<?php echo date("Y",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?></td>
				<td>PAY-<?php echo date("Ymd",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?></td>
				<td><?php echo $site_general_settings->currency.round($bst_tax); ?> (<?php echo $booking->bst_tax; ?>%)</td>
				<td><?php echo $site_general_settings->currency.round($grand_total_booking_amount); ?></td>
			</tr>
		<?php 
			endforeach;
		}
		?>
		</tbody>
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th><?php echo $site_general_settings->currency.round($all_bst_tax); ?></th>
				<th><?php echo $site_general_settings->currency.round($all_grand_amount); ?></th>
			</tr>
		</thead>
	</table>
	</div>
	<?php $ext_add = ob_get_clean();
	echo $ext_add; 
	?>