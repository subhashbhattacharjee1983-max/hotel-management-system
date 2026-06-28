<?php 
	$this->assign('title','Food & Kitchen Bill / Cash Memo');
	$this->assign('heading','Food & Kitchen Bill / Cash Memo');
	$this->assign('breadcrumb','Food & Kitchen Bill / Cash Memo'); 
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
						<div class="col-lg-6">Food & Kitchen Bill / Cash Memo</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'view', $booking->id]);?>" class="btn btn-success">Back to Bookings</a>
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'foodbillprint', $booking->id]);?>" target="_blank" class="btn btn-yellow">Print</a>
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
												<b>Bill No:</b> KOT-<?php echo date("Y",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?> <br />
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
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
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
																		<b>Total Food & Kitchen Amount</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php echo $site_general_settings->currency; ?><?php echo round($sub_total_kitchen_amount);?>
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
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>BST (<?php echo $site_general_settings->bst_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $bst_tax = round(($sub_total_kitchen_amount * $site_general_settings->bst_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>
																	</div>
																</td>
															</tr>
															<?php } ?>
															<?php if($site_general_settings->service_tax > 0){ ?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Service Charge (<?php echo $site_general_settings->service_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $service_tax = round(($sub_total_kitchen_amount * $site_general_settings->service_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>
																	</div>
																</td>
															</tr>
															<?php } ?>
															<?php if($site_general_settings->gst_tax > 0){ ?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>GST (<?php echo $site_general_settings->gst_tax; ?>%)</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $gst_tax = round(($sub_total_kitchen_amount * $site_general_settings->gst_tax)/100); ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?>
																	</div>
																</td>
															</tr>
															<?php } ?>
															<tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Total Charge</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php $total_charge = round($bst_tax) + round($service_tax) + round($gst_tax);?>
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
																		<?php $grand_total = ($sub_total_kitchen_amount + $total_charge) ?>
																		<?php echo $site_general_settings->currency; ?><?php echo round($grand_total);?>
																	</div>
																</td>
															</tr>
															<!-- <tr>
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<b>Total Payment</b>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-right" style="padding: 9px;">
																		<?php //$food_booking_payment = $this->Common->food_booking_payment($booking->id) ?>
																		<?php //echo $site_general_settings->currency; ?> <?php echo round($food_booking_payment);?>
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
																		<?php //$payment_give = $grand_total - $food_booking_payment ?>
																		<?php //echo $site_general_settings->currency; ?><?php echo round($payment_give);?>
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