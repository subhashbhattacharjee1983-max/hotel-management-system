<!doctype html>
<html lang="en">
 <head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order KOT-<?php echo date("Y",strtotime($foodItemOrder->order_date)) ?>-<?php echo $foodItemOrder->id; ?> - Print</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 10px;
			font-weight: bold;
			line-height: 1.2;
			color: #000 !important;
			background: #fff;
			width: 80mm;
			margin: 0 auto;
			padding: 5mm;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}
		.header {
			text-align: center;
			margin-bottom: 10px;
			border-bottom: 2px solid #000;
			padding-bottom: 5px;
		}
		.order-title {
			font-size: 14px;
			font-weight: 900;
			margin-bottom: 2px;
			color: #000 !important;
			letter-spacing: 1px;
		}
		.order-number {
			font-size: 10px;
			font-weight: bold;
			margin-bottom: 1px;
			color: #000 !important;
		}
		.order-date {
			font-size: 8px;
			font-weight: bold;
			margin-bottom: 3px;
			color: #000 !important;
		}
		.order-info {
			margin-bottom: 8px;
			font-size: 9px;
			font-weight: bold;
			color: #000 !important;
		}
		.order-info div {
			margin-bottom: 1px;
			word-wrap: break-word;
			word-break: break-word;
			overflow-wrap: break-word;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 8px;
			font-size: 8px;
			color: #000 !important;
		}
		th, td {
			padding: 2px 1px;
			text-align: left;
			border: none;
			color: #000 !important;
			font-weight: bold;
		}
		th {
			font-weight: 900;
			border-bottom: 2px solid #000;
		}
		.item-row td {
			border-bottom: 1px solid #000;
		}
		.total-section {
			border-top: 2px solid #000;
			padding-top: 3px;
			margin-top: 5px;
			font-size: 9px;
			color: #000 !important;
			font-weight: bold;
		}
		.total-row {
			font-weight: 900;
			font-size: 11px;
			color: #000 !important;
		}
		.subtotal-row {
			font-size: 9px;
			color: #000 !important;
			margin-bottom: 1px;
		}
		.footer {
			margin-top: 10px;
			text-align: center;
			font-size: 8px;
			font-weight: bold;
			border-top: 2px solid #000;
			padding-top: 5px;
			color: #000 !important;
		}
		.item-name {
			font-weight: 900;
			color: #000 !important;
		}
		@media print {
			body {
				margin: 0;
				padding: 2mm;
				width: 80mm;
				font-weight: bold !important;
				color: #000 !important;
				-webkit-print-color-adjust: exact !important;
				print-color-adjust: exact !important;
			}
			.no-print {
				display: none;
			}
			* {
				color: #000 !important;
				font-weight: bold !important;
			}
		}
	</style>
</head>
<?php
	$qty = "Qty";
	if($foodItemOrder->order_type == "C"){
		$qty = "No of Heads";
	}
?>
<body>
	<div class="no-print" style="margin: 10px 0; text-align: center;">
		<button onclick="window.print()" style="padding: 5px 10px; margin: 0 5px;">Print</button>
		<button onclick="window.close()" style="padding: 5px 10px; margin: 0 5px;">Close</button>
	</div>
	<div class="header">
		<div class="order-title">🍽️ FOOD ORDER 🍽️</div>
		<div class="order-title"><?php echo $site_general_settings->company_name ?></div>
		<div class="order-number">Order KOT-<?php echo date("Y",strtotime($foodItemOrder->order_date)) ?>-<?php echo $foodItemOrder->id; ?></div>
		<div class="order-date"><?php echo date("M d, Y H:i A",strtotime($foodItemOrder->order_date));?></div>
	</div>
	<div class="order-info">
		<?php if($foodItemOrder->booking_id == 0 && ($foodItemOrder->order_type == "T" || $foodItemOrder->order_type == "E" || $foodItemOrder->order_type == "C")){ ?>
		<div><strong>Order Type:</strong> <?php echo $order_type[$foodItemOrder->order_type] ?> Order</div>
		<div><strong>Invoice No:</strong> <?php echo $foodItemOrder->table_number; ?></div>
		<div><strong>Taken By:</strong> <?php echo $foodItemOrder->guest_name; ?></div>
		<?php if($foodItemOrder->from_date != ""){ ?>
		<div><strong>From Date:</strong> <?php echo $this->Common->entry_date($foodItemOrder->from_date);?></div>
		<?php } if($foodItemOrder->to_date != ""){ ?>
		<div><strong>To Date:</strong> <?php echo $this->Common->entry_date($foodItemOrder->to_date);?></div>
		<?php } ?>
		<?php }else{ ?>
		<div><strong>Order Type:</strong> Room Order</div>
		<div><strong>Room No:</strong> <?php echo $foodItemOrder->room_number; ?></div>
		<div><strong>Taken By:</strong> <?php echo $booking->customer->full_name; ?></div>
		<?php } ?>
		<div><strong>Status:</strong> <?php echo $food_order_status[$foodItemOrder->status]; ?></div>
		<div><strong>Payment Status:</strong> <?php echo $payment_status[$foodItemOrder->is_payment]; ?></div>
	</div>
	<div style="font-weight: bold; font-size: 10px; margin-bottom: 5px; border-bottom: 1px solid #000; padding-bottom: 2px; color: #000 !important;">
		 🍽️ ORDER ITEMS
	</div>
	<table>
			<thead>
				<tr>
					<th width="40%">Item</th>
					<th width="15%">Price</th>
					<th width="15%"><?php echo $qty ?></th>
					<th width="15%">No of Day</th>
					<th width="15%">Total</th>
				</tr>
			</thead>
			<tbody>
					<?php 
					$sub_total_kitchen_amount = 0;
					if(!empty($foodItemOrder))
					{
						foreach($foodItemOrder->food_item_details as $key_dtls => $val)
						{
							$sub_total_kitchen_amount = $sub_total_kitchen_amount + $val->sub_total;
					?>
					<tr class="item-row">
						<td>
							<div class="item-name"><?php echo $val->food_item_name; ?></div>
						</td>
						<td><?php echo $site_general_settings->currency; ?><?php echo round($val->price); ?></td>
						<td><?php echo $val->quantity; ?></td>
						<td><?php echo $val->item_no_of_days; ?></td>
						<td><?php echo $site_general_settings->currency; ?><?php echo round($val->sub_total); ?></td>
					</tr>
					<?php
						}
					}
					?>
			</tbody>
	</table>
	<div class="total-section">
			<div class="subtotal-row">
				<div style="display: flex; justify-content: space-between;">
					<span>Subtotal:</span>
					<span><?php echo $site_general_settings->currency; ?><?php echo round($sub_total_kitchen_amount);?></span>
				</div>
			</div>
			<?php 
			$bst_tax = 0;
			$service_tax = 0;
			$gst_tax = 0;
			if($site_general_settings->food_bst_tax > 0){ ?>
			<div class="subtotal-row">
				<div style="display: flex; justify-content: space-between;">
					<span>BST Tax (<?php echo $site_general_settings->food_bst_tax; ?>%):</span>
					<?php $bst_tax = round(($sub_total_kitchen_amount * $site_general_settings->food_bst_tax)/100); ?>
					<span><?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?></span>
				</div>
			</div>
			<?php } ?>
			<?php if($site_general_settings->food_service_tax > 0){ ?>
			<div class="subtotal-row">
				<div style="display: flex; justify-content: space-between;">
					<span>Service (<?php echo $site_general_settings->food_service_tax; ?>%):</span>
					<?php $service_tax = round(($sub_total_kitchen_amount * $site_general_settings->food_service_tax)/100); ?>
					<span><?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?></span>
				</div>
			</div>
			<?php } ?>
			<?php if($site_general_settings->food_gst_tax > 0){ ?>
			<div class="subtotal-row">
				<div style="display: flex; justify-content: space-between;">
					<span>GST Tax (<?php echo $site_general_settings->food_gst_tax; ?>%):</span>
					<?php $gst_tax = round(($sub_total_kitchen_amount * $site_general_settings->food_gst_tax)/100); ?>
					<span><?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?></span>
				</div>
			</div>
			<?php } ?>
			<div class="total-row" style="margin-top: 3px;">
				<div style="display: flex; justify-content: space-between;">
					<span>TOTAL:</span>
					<?php $total_charge = round($bst_tax) + round($service_tax) + round($gst_tax);?>
					<?php $grand_total = ($sub_total_kitchen_amount + $total_charge) ?>
					<span><?php echo $site_general_settings->currency; ?><?php echo round($grand_total);?></span>
				</div>
			</div>
	</div>
	<div class="footer">
			🍴 Thank you for your order! 🍴<br>
			This is an electronically generated document.<br>
			No signature required.<br>
			................................................................<br>
			Printed on: <?php $now = new DateTime();
						echo $timestring = $now->format('M d, Y h:i A'); 
						?>   
	</div>
</body>
</html>  