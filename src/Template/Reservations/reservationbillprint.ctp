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
	span {
		padding: 0px 15px;
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
										<b>Tel:</b> <?php echo $site_general_settings->phone_number ?><br />
										<b>Email:</b> <?php echo $site_general_settings->billing_email_address ?><br />
										<?php echo nl2br($site_general_settings->street_address) ?>
										</div>
										<div class="col-md-4"></div>
									</div>								
								</div>
							</div>
						</div>
						<div class="col-lg-6" style="width: 50%; float: left; margin-top: 17px;">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												<b>Bill No:</b> REV-<?php echo date("Y",strtotime($reservation->booking_date)) ?>-<?php echo $reservation->id; ?> <br />
												<b>Bill Date:</b> <?php echo $this->Common->entry_date($reservation->booking_date);?> <br />
												<b>Check In Date:</b> <?php echo $this->Common->entry_date($reservation->check_in_date);?> <br />
												<b>Check Out Date:</b> <?php echo $this->Common->entry_date($reservation->check_out_date);?> <br />
												<b>Adults:</b> <?php echo $reservation->adults; ?> <br />
												<b>Children:</b> <?php echo $reservation->children; ?> <br />
												<b>Number Of Night:</b> <?php echo $reservation->number_of_night; ?> <br />
												<b>Booking Package:</b> <?php echo $reservation->booking_package; ?> <br />
												<b>Booking Food Plan:</b> <?php echo $reservation->food_plan; ?>
												</label>
											</div>
										</div>										
									</div>								
								</div>
							</div>
						</div>
						<div class="col-lg-6" style="width: 45%; float: left; margin-top: 17px;">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-6" style="float: right;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												<b>Customer Name:</b> <?php echo $reservation->customer->full_name; ?> <br />
												<b>Customer Address:</b> <?php echo $reservation->customer->address; ?>
												</label>
											</div>
										</div>										
									</div>								
								</div>
							</div>
						</div>
						<div class="col-lg-12" style="width: 100%; float: left;">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="col-md-12 btn btn-success" style="margin: 27px 0; text-align: left; font-size: 17px;">Room Details</div>
													<div class="form-group col-md-12" style="padding-left:0px">
														<table width="100%" border="1" cellspacing="0" cellpadding="0">
															<tr>
																<th style="text-align:center; padding:8px; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; width:20%;">Room Category</th>
																<th style="text-align:center; padding:8px; width:15%;">Room Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; width:15%;">Discount (%)</th>
																<th style="text-align:center; padding:8px; width:20%;">Booking Price (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															if(!empty($reservation->reservation_room_details))
															{
																foreach($reservation->reservation_room_details as $key_dtls => $val)
																{
																	$key = $key_dtls + 1;
															?>
															<tr>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo $val->reservation_room_number!="" ? $val->reservation_room_number : "-"; ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo $val->reservation_room_category; ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo round($val->booking_room_price) ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">
																		<?php echo $val->booking_room_discount; ?>
																	</div>
																</td>
																<td>
																	<div style="padding: 9px; text-align:center;">																		
																		<?php echo round($val->room_booking_price); ?>
																	</div>
																</td>
															</tr>
															<?php
																}
															}
															?>
														</table>
													</div>
												</div>
												<div class="col-md-12" style="margin-top: 17px;">
													<div class="row">
														<?php $total_room_reservation_amount = $reservation->booking_price * $reservation->number_of_night; ?>
														<label style="font-weight: bold;" for="inputName" class="control-label">Total Room Reservation Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($total_room_reservation_amount); ?> (<?php echo $this->Common->convert_number_to_words($total_room_reservation_amount); ?>)</label>
													</div>
												</div>												
											</div>
										</div>
										
										<?php
										if($reservation->food_total1 > 0 || $reservation->food_total2 > 0 || $reservation->food_total3 > 0 || $reservation->food_total4 > 0)
										{
										?>
										<p>Food Details</p>
										<?php
										}
										if($reservation->food_total1 > 0)
										{
										?>
										<p>
											Food 1: <?php echo $reservation->food1;?> <span>|</span> Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price1;?>  <span>|</span> Total Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total1;?> 
										</p>
										<?php
										}
										if($reservation->food_total2 > 0)
										{
										?>
										<p>
											Food 2: <?php echo $reservation->food2;?> <span>|</span> Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price2;?>  <span>|</span> Total Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total2;?> 
										</p>
										<?php
										}
										if($reservation->food_total3 > 0)
										{
										?>
										<p>
											Food 3: <?php echo $reservation->food3;?> <span>|</span> Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price3;?>  <span>|</span> Total Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total3;?> 
										</p>
										<?php
										}
										if($reservation->food_total4 > 0)
										{
										?>
										<p>
											Food 4: <?php echo $reservation->food4;?> <span>|</span> Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price4;?>  <span>|</span> Total Price: <?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total4;?> 
										</p>
										<?php
										}
										?>
										<?php 
										$all_total_amount = 0;
										$all_total_amount = $reservation->all_total_amount;
										?>
										<p style="font-size: 17px;">
											All Total Amount: <?php echo $site_general_settings->currency; ?><?php echo $all_total_amount;?> 
										</p>
										<p style="font-size: 17px;">
											<?php
											if($reservation->allow_bst == "Y")
											{
											?>
											BST (<?php echo $site_general_settings->bst_tax; ?>%): 
											<?php $bst_tax = ($all_total_amount * $site_general_settings->bst_tax)/100; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>  <span>|</span> 
											<?php
											}
											else
											{
											?>
											BST (0%): 
											<?php $bst_tax = 0; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>  <span>|</span>
											<?php
											}
											if($reservation->allow_service_charge == "Y")
											{
											?>
											Service Charge (<?php echo $site_general_settings->service_tax; ?>%): 
											<?php $service_tax = ($all_total_amount * $site_general_settings->service_tax)/100; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>  <span>|</span>
											<?php
											}
											else
											{
											?>
											Service Charge (0%): 
											<?php $service_tax = 0; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>  <span>|</span>
											<?php
											}
											if($reservation->allow_gst == "Y")
											{
											?>
											GST (<?php echo $site_general_settings->gst_tax; ?>%): 
											<?php $gst_tax = ($all_total_amount * $site_general_settings->gst_tax)/100; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?> <span>|</span>
											<?php
											}
											else
											{
											?>
											GST (0%): 
											<?php $gst_tax = 0; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?> <span>|</span>
											<?php
											}
											if($reservation->allow_bank_transfer_charge == "Y")
											{
											?>
											Bank Transfer Charge: 
											<?php $bank_transfer_charge = $site_general_settings->bank_transfer_charge; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($bank_transfer_charge);?>
											<?php
											}
											else
											{
											?>
											Bank Transfer Charge: 
											<?php $bank_transfer_charge = 0; ?> 
											<?php echo $site_general_settings->currency; ?><?php echo round($bank_transfer_charge);?>
											<?php
											}
											?>
										</p>
										<p style="font-size: 17px;">
											Grand Total Amount: <?php $grand_total = ($all_total_amount + round($bst_tax) + round($service_tax) + round($gst_tax) + round($bank_transfer_charge)) ?>
											<?php echo $site_general_settings->currency; ?><?php echo round($grand_total);?> (<?php echo $this->Common->convert_number_to_words($grand_total); ?>) 
										</p>
										<p style="font-size: 17px;">
											Paid Amount: <?php echo $site_general_settings->currency; ?><?php echo $reservation->paid_amount;?> 
										</p>
										<p style="font-size: 17px;">
											Remaining Amount: <?php echo $site_general_settings->currency; ?><?php echo $grand_total - $reservation->paid_amount;?> 
										</p>
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