<?php 
	$this->assign('title','Room Bill / Cash Memo');
	$this->assign('heading','Room Bill / Cash Memo');
	$this->assign('breadcrumb','Room Bill / Cash Memo'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'index'])); 
?>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="col-md-12">
				<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-grey">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-6">Room Bill / Cash Memo</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'view', $booking->id]);?>" class="btn btn-success">Back to Bookings</a>
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'roombillprint', $booking->id]);?>" target="_blank" class="btn btn-yellow">Print</a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
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
												<b>Bill No:</b> ROOM-<?php echo date("Y",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?> <br />
												<b>Bill Date:</b> <?php echo $this->Common->entry_date($booking->booking_date);?> <br />
												<b>Check In Date:</b> <?php echo $this->Common->entry_date($booking->check_in_date);?> <br />
												<b>Check Out Date:</b> <?php echo $this->Common->entry_date($booking->check_out_date);?> <br />
												<b>Adults:</b> <?php echo $booking->adults; ?> <br />
												<b>Children:</b> <?php echo $booking->children; ?> <br />
												<b>Number Of Night:</b> <?php echo $booking->number_of_night; ?> <br />
												<b>Booking Package:</b> <?php echo $booking->booking_package; ?> <br />
												<b>Booking Food Plan:</b> <?php echo $booking->food_plan; ?>
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
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Category</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Room Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Discount (%)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Booking Price (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															if(!empty($booking->booking_room_details))
															{
																foreach($booking->booking_room_details as $key_dtls => $val)
																{
																	$key = $key_dtls + 1;
															?>
															<tr>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->booking_room_name; ?>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-center">
																		<?php echo $val->booking_room_category; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo round($val->booking_room_price) ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo $val->booking_room_discount; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">																		
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
											</div>
										</div>
										<div class="col-md-6"></div>
										<div class="col-md-6">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding-left:0px">
														<table width="100%" border="1">
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Total Room Booking Amount</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php echo $site_general_settings->currency; ?><?php echo round($booking->room_price);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Discount</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php echo $site_general_settings->currency; ?><?php echo round($booking->room_price - $booking->booking_price);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Booking Amount</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php echo $site_general_settings->currency; ?><?php echo round($booking->booking_price);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Gross Amount</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $total_room_booking_amount = round($booking->booking_price) * $booking->number_of_night; ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($total_room_booking_amount);?>
																	</div>
																</td>
															</tr>
															<?php $bst_tax = 0;
															if($booking->allow_bst == "Y")
															{
															?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>BST (<?php echo $booking->bst_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $bst_tax = round(($total_room_booking_amount * $booking->bst_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>
																	</div>
																</td>
															</tr>
															<?php
															}
															$service_tax = 0;
															if($booking->allow_service_charge == "Y")
															{
															?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Service Charge (<?php echo $booking->service_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $service_tax = round(($total_room_booking_amount * $booking->service_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>
																	</div>
																</td>
															</tr>
															<?php
															}
															$gst_tax = 0;
															if($booking->allow_gst == "Y")
															{
															?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>GST (<?php echo $booking->gst_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $gst_tax = round(($total_room_booking_amount * $booking->gst_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?>
																	</div>
																</td>
															</tr>
															<?php
															}
															$bank_transfer_charge = 0;
															if($booking->allow_bank_transfer_charge == "Y")
															{
															?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Bank Transfer Charge</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $bank_transfer_charge = $booking->bank_transfer_charge; ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($bank_transfer_charge);?>
																	</div>
																</td>
															</tr>
															<?php
															}
															?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Total Charge</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $total_charge = round($bst_tax) + round($service_tax) + round($gst_tax) + $bank_transfer_charge;?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($total_charge);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Grand Total</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $grand_total = ($total_room_booking_amount + $total_charge) ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($grand_total);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Total Payment</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $room_booking_payment = $this->Common->room_booking_payment($booking->id) ?>
																		<?php echo $site_general_settings->currency; ?> <?php echo round($room_booking_payment);?>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Net Payable</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $payment_give = $grand_total - $room_booking_payment ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($payment_give);?>
																	</div>
																</td>
															</tr>
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
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			<div class="form-body">
				<div class="row">
					<div class="col-md-12">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>