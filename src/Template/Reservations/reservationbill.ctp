<?php 
	$this->assign('title','Reservation Bill / Cash Memo');
	$this->assign('heading','Reservation Bill / Cash Memo');
	$this->assign('breadcrumb','Reservation Bill / Cash Memo'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Reservations', 'action'=>'index'])); 
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
						<div class="col-lg-6">Reservation Bill / Cash Memo</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'view', $reservation->id]);?>" class="btn btn-success">Back to Reservation</a>
							<a href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'reservationbillprint', $reservation->id]);?>" target="_blank" class="btn btn-yellow">Print</a>
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
										<b>Tel:</b> <?php echo $site_general_settings->phone_number ?><br />
										<b>Email:</b> <?php echo $site_general_settings->billing_email_address ?><br />
										<?php echo nl2br($site_general_settings->street_address) ?>
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
						<div class="col-lg-6">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6"></div>
										<div class="col-md-6">
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
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="col-md-12 btn btn-success" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Rooom Details</div>
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
															if(!empty($reservation->reservation_room_details))
															{
																foreach($reservation->reservation_room_details as $key_dtls => $val)
																{
																	$key = $key_dtls + 1;
															?>
															<tr>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->reservation_room_number!="" ? $val->reservation_room_number : "-"; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->reservation_room_category; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->booking_room_price) ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->booking_room_discount; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
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
														<?php $total_room_reservation_amount = $reservation->booking_price * $reservation->number_of_night; ?>
														<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Room Reservation Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($total_room_reservation_amount); ?> (<?php echo $this->Common->convert_number_to_words($total_room_reservation_amount); ?>)</label>
													</div>
												</div>
											</div>
										</div>
										<?php
										if($reservation->food_total1 > 0 || $reservation->food_total2 > 0 || $reservation->food_total3 > 0 || $reservation->food_total4 > 0)
										{
										?>
										<div class="col-md-12">
											<div class="form-group">
												<div class="input-icon right">
													<div class="col-md-12 btn btn-warning" style="padding: 7px; margin: 17px 0; text-align: left; font-size: 17px;">Food Details</div>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->food_total1 > 0)
										{
										?>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
													Food 1
												</label>
												<div class="input-icon right">
													<?php echo $reservation->food1;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price1;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="font-weight: bold; font-size: 17px; color: #f76600;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Total Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total1;?>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->food_total2 > 0)
										{
										?>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
													Food 2
												</label>
												<div class="input-icon right">
													<?php echo $reservation->food2;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price2;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="font-weight: bold; font-size: 17px; color: #f76600;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Total Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total2;?>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->food_total3 > 0)
										{
										?>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
													Food 3
												</label>
												<div class="input-icon right">
													<?php echo $reservation->food3;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price3;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="font-weight: bold; font-size: 17px; color: #f76600;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Total Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total3;?>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->food_total4 > 0)
										{
										?>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
													Food 4
												</label>
												<div class="input-icon right">
													<?php echo $reservation->food4;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_price4;?> 
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="font-weight: bold; font-size: 17px; color: #f76600;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Total Price
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->food_total4;?>
												</div>
											</div>
										</div>
										<?php
										}
										?>
										<?php 
										$all_total_amount = 0;
										$all_total_amount = $reservation->all_total_amount;
										?>
										<div class="col-md-4" style="margin-top: 15px;">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												All Total Amount
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $all_total_amount;?>
												</div>
											</div>
										</div>
										<?php
										if($reservation->allow_bst == "Y")
										{
										?>
										<div class="col-md-4" style="margin-top: 15px;">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												BST (<?php echo $site_general_settings->bst_tax; ?>%)
												</label>
												<div class="input-icon right">
													<?php $bst_tax = ($all_total_amount * $site_general_settings->bst_tax)/100; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>
												</div>
											</div>
										</div>
										<?php
										}
										else
										{
										?>
										<div class="col-md-4" style="margin-top: 15px;">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												BST (0%)
												</label>
												<div class="input-icon right">
													<?php $bst_tax = 0; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($bst_tax);?>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->allow_service_charge == "Y")
										{
										?>
										<div class="col-md-4" style="margin-top: 15px;">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Service Charge (<?php echo $site_general_settings->service_tax; ?>%)
												</label>
												<div class="input-icon right">
													<?php $service_tax = ($all_total_amount * $site_general_settings->service_tax)/100; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>
												</div>
											</div>
										</div>
										<?php
										}
										else
										{
										?>
										<div class="col-md-4" style="margin-top: 15px;">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Service Charge (0%)
												</label>
												<div class="input-icon right">
													<?php $service_tax = 0; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($service_tax);?>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->allow_gst == "Y")
										{
										?>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												GST (<?php echo $site_general_settings->gst_tax; ?>%)
												</label>
												<div class="input-icon right">
													<?php $gst_tax = ($all_total_amount * $site_general_settings->gst_tax)/100; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?>
												</div>
											</div>
										</div>
										<?php
										}
										else
										{
										?>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												GST (0%)
												</label>
												<div class="input-icon right">
													<?php $gst_tax = 0; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($gst_tax);?>
												</div>
											</div>
										</div>
										<?php
										}
										if($reservation->allow_bank_transfer_charge == "Y")
										{
										?>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Bank Transfer Charge
												</label>
												<div class="input-icon right">
													<?php $bank_transfer_charge = $site_general_settings->bank_transfer_charge; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($bank_transfer_charge);?>
												</div>
											</div>
										</div>
										<?php
										}
										else
										{
										?>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Bank Transfer Charge
												</label>
												<div class="input-icon right">
													<?php $bank_transfer_charge = 0; ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($bank_transfer_charge);?>
												</div>
											</div>
										</div>
										<?php
										}
										?>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Grand Total Amount
												</label>
												<div class="input-icon right">
													<?php $grand_total = ($all_total_amount + round($bst_tax) + round($service_tax) + round($gst_tax) + round($bank_transfer_charge)) ?>
													<?php echo $site_general_settings->currency; ?><?php echo round($grand_total);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Paid Amount
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $reservation->paid_amount;?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="font-size: 19px;">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Remaining Amount
												</label>
												<div class="input-icon right">
													<?php echo $site_general_settings->currency; ?><?php echo $grand_total - $reservation->paid_amount;?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<label style="font-size: 17px; font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Grand Total Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($grand_total); ?> (<?php echo $this->Common->convert_number_to_words($grand_total); ?>)</label>
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