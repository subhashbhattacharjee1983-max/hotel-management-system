<?php
$this->assign('title', 'Beverage & Bar Report');
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
		<div style="margin-bottom:15px; font-size:19px;">Beverage & Bar Report</div>
	</div>
	<div style="width: 100%;">
	<table border="1" style="width: 100%;" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>SL No</th>	
				<th>Room / Table Number</th>
				<th>Customer Name</th>
				<th>Mobile Number</th>
				<th>Bar Charge</th>
				<th>Service Charge (<?php echo $site_general_settings->bar_service_tax; ?>%)</th>
				<th>BST Charge (<?php echo $site_general_settings->bar_bst_tax; ?>%)</th>
				<th>GST Charge (<?php echo $site_general_settings->bar_gst_tax; ?>%)</th>
				<th>Grand Total</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$i=0; 
		$all_bar_amount = 0;
		$all_bst_tax = 0;
		$all_service_tax = 0;
		$all_gst_tax = 0;
		$all_grand_amount = 0;
		if(!empty($beverageItemOrders))
		{
			foreach ($beverageItemOrders as $key => $barItemOrder):
			$i++;
			if($barItemOrder->booking_id > 0){
				$show_rooms = "Room: ".$this->Common->show_rooms($barItemOrder->booking_id);
				$booking = $this->Common->booking_customer_details($barItemOrder->booking_id);
				$customer_name = $booking->customer->full_name;
				$mobile_number = $booking->customer->mobile_number;
			}else{
				$show_rooms = "Table: ".$barItemOrder->table_number;
				$customer_name = $barItemOrder->guest_name;
				$mobile_number = $barItemOrder->mobile_number;
			}
			$bar_charge = round($barItemOrder->sub_total); 
			$all_bar_amount = $all_bar_amount + $bar_charge;
			$bst_tax = round(($bar_charge * $site_general_settings->bar_bst_tax)/100);
			$service_tax = round(($bar_charge * $site_general_settings->bar_service_tax)/100);
			$gst_tax = round(($bar_charge * $site_general_settings->bar_gst_tax)/100);
			
			$all_bst_tax = $all_bst_tax + $bst_tax;
			$all_service_tax = $all_service_tax + $service_tax;
			$all_gst_tax = $all_gst_tax + $gst_tax;
			$grand_total_booking_amount = $bar_charge + $bst_tax + $service_tax + $gst_tax;
			$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
		?>
			<tr>
				<td><?php echo $key + 1; ?></td>	
				<td><?php echo $show_rooms; ?></td>
				<td><?php echo $customer_name; ?></td>
				<td><?php echo $mobile_number; ?></td>
				<td><?php echo $site_general_settings->currency.round($bar_charge); ?></td>
				<td><?php echo $site_general_settings->currency.round($service_tax); ?></td>
				<td><?php echo $site_general_settings->currency.round($bst_tax); ?></td>
				<td><?php echo $site_general_settings->currency.round($gst_tax); ?></td>
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
				<th><?php echo $site_general_settings->currency.round($all_bar_amount); ?></th>
				<th><?php echo $site_general_settings->currency.round($all_service_tax); ?></th>
				<th><?php echo $site_general_settings->currency.round($all_bst_tax); ?></th>
				<th><?php echo $site_general_settings->currency.round($all_gst_tax); ?></th>
				<th><?php echo $site_general_settings->currency.round($all_grand_amount); ?></th>
			</tr>
		</thead>
	</table>
	</div>
	<?php $ext_add = ob_get_clean();
	echo $ext_add; 
	?>