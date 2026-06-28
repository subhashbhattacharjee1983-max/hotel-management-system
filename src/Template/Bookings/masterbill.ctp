<?php 
	$this->assign('title','Master Bill / Cash Memo');
	$this->assign('heading','Master Bill / Cash Memo');
	$this->assign('breadcrumb','Master Bill / Cash Memo'); 
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
						<div class="col-lg-6">Master Bill / Cash Memo</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'view', $booking->id]);?>" class="btn btn-success">Back to Bookings</a>
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'masterbillprint', $booking->id]);?>" target="_blank" class="btn btn-yellow">Print</a>
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
												<b>Bill No:</b> BILL-<?php echo date("Y",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?> <br />
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
													<div class="col-md-12 btn btn-success" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Room Details</div>
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
												<div class="col-md-12">
													<div class="row">
														<?php $total_room_booking_amount = round($booking->booking_price) * $booking->number_of_night; ?>
														<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Room Booking Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($total_room_booking_amount); ?> (<?php echo $this->Common->convert_number_to_words($total_room_booking_amount); ?>)</label>
													</div>
												</div>
												<?php 
												if(!empty($foodItemOrder))
												{
												?>												
												<div class="input-icon right">
													<div class="col-md-12 btn btn-yellow" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Food & Kitchen Order (KOT) Details</div>
													<?php
													$sub_total_kitchen_amount = 0;
													foreach($foodItemOrder as $food_key => $food_val)
													{
														$sub_total_kitchen_amount = $sub_total_kitchen_amount + $food_val->sub_total;
														$food_item_details = $this->Common->food_item_details($food_val->id);
													?>
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold;" for="inputName" class="control-label">Room Number: <?php echo $food_val->room_number; ?></label>
														</div>
													</div>
													<?php
													if(!empty($food_item_details))
													{
													?>
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<!-- <th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th> -->
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:5%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Order Date</th>
															</tr>
															<?php
															foreach($food_item_details as $key_dtls => $val)
															{
															?>
															<tr>
																<!-- <td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php //echo $val->food_item_category; ?>
																	</div>
																</td> -->																
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->food_item_name; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->price); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
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
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Food & Kitchen Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($sub_total_kitchen_amount); ?> (<?php echo $this->Common->convert_number_to_words($sub_total_kitchen_amount); ?>)</label>
														</div>
													</div>
												</div>
												<?php
												}
												?>
												<?php 
												if(!empty($bavarageItemOrder))
												{
												?>												
												<div class="input-icon right">
													<div class="col-md-12 btn btn-orange" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Beverage & Bar Order (BOT) Details</div>
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
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
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
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php //echo $val->beverage_item_category; ?>
																	</div>
																</td> -->																
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->beverage_item_name; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->price); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
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
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Beverage & Bar Order Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($sub_total_bar_amount); ?> (<?php echo $this->Common->convert_number_to_words($sub_total_bar_amount); ?>)</label>
														</div>
													</div>
												</div>
												<?php
												}
												?>
												<?php 
												if(!empty($housekeepingOrders))
												{
												?>												
												<div class="input-icon right">
													<div class="col-md-12 btn btn-pink" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">House keeping / Service Details</div>
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Service Name</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Service Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Sub Total (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															$sub_total_house_keeping_amount = 0;
															foreach($housekeepingOrders as $key_dtls => $val)
															{
																$sub_total_house_keeping_amount = $sub_total_house_keeping_amount + $val->sub_total;
															?>
															<tr>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->room_number; ?>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-center">
																		<?php echo $val->service_name; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo round($val->service_price); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
															</tr>
															<?php
															}
															?>
														</table>
													</div>
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total House keeping Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($sub_total_house_keeping_amount); ?> (<?php echo $this->Common->convert_number_to_words($sub_total_house_keeping_amount); ?>)</label>
														</div>
													</div>
												</div>
												<?php
												}
												if(!empty($bookingPayments))
												{
												?>
												<div class="input-icon right">
													<div class="col-md-12 btn btn-warning" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">All Payment Details</div>
													<?php echo $this->Common->verify_booking_payment($booking->id); ?>
												</div>
												<?php
												}
												if(!empty($refundPayments))
												{
												?>
												<div class="input-icon right">
													<div class="col-md-12 btn btn-warning" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Refund Payment to <?php echo $booking->customer->full_name ?></div>
													<?php echo $this->Common->refund_payment($booking->id); ?>
												</div>
												<?php
												}
												?>
												<div class="col-md-12" style="margin-top: 27px;">
													<div class="row">
														<div class="form-group">
															<?php echo $this->Common->booking_payment($booking->id); ?>
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
</div>