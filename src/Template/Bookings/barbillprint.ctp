<style type="text/css">
	body {
            font-family: Arial, sans-serif;
            font-weight: bold;
            line-height: 1.2;
            color: #000 !important;
            background: #fff;
            width: 70%;
            margin: 0 auto;
            padding: 5mm;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
	label {
		display: inline-block;
		margin-bottom: 5px;
		background: none !important;
		color: #000 !important;
	  }
	table {
		width: 95% !important;
	}
	table td {
		background: none !important;
	}
	table tr {
		background: none !important;
	}
	table td img {
		display: none !important;
	}
	table tr th {
		color: #000 !important;
	}
	  @media print {
            body {
                margin: 0;
                padding: 2mm;
                width: 100%;
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
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="panel panel-grey">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="no-print" style="margin: 10px 0; text-align: center;">
								<button onclick="window.print()" style="padding: 5px 10px; margin: 0 5px;">Print</button>
								<button onclick="window.close()" style="padding: 5px 10px; margin: 0 5px;">Close</button>
							</div>
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-4"></div>
										<div class="col-md-4" style="text-align: center;">
										<?php
										if(isset($site_general_settings->website_logo) && trim($site_general_settings->website_logo)!='' && file_exists(WWW_ROOT.$upload_folder. DS.$website_logo_folder.DS.$site_general_settings->website_logo))
										{
											echo $this->Html->image('/'.$upload_folder.'/'.$website_logo_folder.'/'.$site_general_settings->website_logo, array('alt' => $site_general_settings->website_name, 'border' => '0', 'align'=>'center', 'style'=>"width:117px"));
										}
										?><br />
										<?php echo $site_general_settings->company_name ?><br />
										Tel: <?php echo $site_general_settings->phone_number ?><br />
										Email: <?php echo $site_general_settings->billing_email_address ?>
										</div>
										<div class="col-md-4"></div>
									</div>								
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												<b>Bill No:</b> BOT-<?php echo date("Y",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?> <br />
												<b>Bill Date:</b> <?php echo date("Y-m-d",strtotime($booking->booking_date));?> <br />
												<b>Check In Date:</b> <?php echo date("Y-m-d",strtotime($booking->check_in_date));?> <br />
												<b>Check Out Date:</b> <?php echo date("Y-m-d",strtotime($booking->check_out_date));?> <br />
												<b>Adults:</b> <?php echo $booking->adults; ?> <br />
												<b>Children:</b> <?php echo $booking->children; ?> <br />
												<b>Number Of Night:</b> <?php echo $booking->number_of_night; ?>
												</label>
											</div>
										</div>										
									</div>								
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												<b>Customer Name:</b> <?php echo $booking->customer->full_name; ?> <br />
												<b>Customer Address:</b> <?php echo $booking->customer->address; ?>
												</label>
											</div>
										</div>										
									</div>								
								</div>
							</div>
						</div>
						<div class="col-lg-12" style="margin-top: 17px;">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<?php
													$sub_total_bar_amount = 0;
													foreach($bavarageItemOrder as $beverage_key => $beverage_val)
													{
														$sub_total_bar_amount = $sub_total_bar_amount + $beverage_val->sub_total;
														$beverage_item_details = $this->Common->beverage_item_details($beverage_val->id);
													?>
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold;" for="inputName" class="control-label">Room Number: <?php echo $beverage_val->room_number; ?></label>
														</div>
													</div>
													<?php
													if(!empty($beverage_item_details))
													{
													?>
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1" cellspacing="0" cellpadding="0">
															<tr>
																<!-- <th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th> -->
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:5%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Order Date</th>
															</tr>
															<?php
															foreach($beverage_item_details as $key_dtls => $val)
															{
															?>
															<tr>
																<!-- <td>
																	<div style="padding: 9px; text-align:center;" style="padding: 9px;">
																		<?php //echo $val->beverage_item_category; ?>
																	</div>
																</td> -->																
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo $val->beverage_item_name; ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo round($val->price); ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo $this->Common->entry_date($val->order_date); ?>
																	</div>
																</td>
															</tr>
															<?php
															}
															?>
														</table>
													</div>
													<?php
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="col-md-6"></div>
										<div class="col-md-6" style="margin: 17px 0 47px 0;">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding-left:0px">
														<table width="100%" border="1" cellspacing="0" cellpadding="0">
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>Total Beverage & Bar Amount</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php echo $site_general_settings->currency; ?><?php echo round($sub_total_bar_amount);?>
																	</div>
																</td>
															</tr>
															<?php 
															$bst_tax = 0;
															$service_tax = 0;
															$gst_tax = 0;
															if($site_general_settings->bst_tax > 0){ ?>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>BST (<?php echo $site_general_settings->bst_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php $bst_tax = round(($sub_total_bar_amount * $site_general_settings->bst_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>
																	</div>
																</td>
															</tr>
															<?php } ?>
															<?php if($site_general_settings->service_tax > 0){ ?>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>Service Charge (<?php echo $site_general_settings->service_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php $service_tax = round(($sub_total_bar_amount * $site_general_settings->service_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>
																	</div>
																</td>
															</tr>
															<?php } ?>
															<?php if($site_general_settings->gst_tax > 0){ ?>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>GST (<?php echo $site_general_settings->gst_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php $gst_tax = round(($sub_total_bar_amount * $site_general_settings->gst_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?>
																	</div>
																</td>
															</tr>
															<?php } ?>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>Total Charge</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php $total_charge = round($bst_tax) + round($service_tax) + round($gst_tax);?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($total_charge);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>Grand Total</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php $grand_total = ($sub_total_bar_amount + $total_charge) ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($grand_total);?>
																	</div>
																</td>
															</tr>
															<!-- <tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>Total Payment</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php //$bar_booking_payment = $this->Common->bar_booking_payment($booking->id) ?>
																		<?php //echo $site_general_settings->currency; ?> <?php //echo round($bar_booking_payment);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<b>Net Payable</b>
																	</div>
																</td>																
																<td>
																	<div style="padding: 9px; text-align:right;">
																		<?php //$payment_give = $grand_total - $bar_booking_payment ?>
																		<?php //echo $site_general_settings->currency; ?><?php //echo round($payment_give);?>
																	</div>
																</td>
															</tr> -->
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>