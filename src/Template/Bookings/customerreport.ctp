<?php 
	$this->assign('title','Customer Report');
	$this->assign('heading','List of Customer Report');
	$this->assign('breadcrumb','Customer Report'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'report'])); 
	$startDate = new DateTime('first day of this month');
	$start_date_customer = $startDate->format('Y-m-d');
	$endDate = new DateTime('last day of this month');
	$end_date_customer = $endDate->format('Y-m-d');
	$parameter_arr = array();
	$start_date_customer = $this->request->getQuery('start_date_customer');
	$end_date_customer = $this->request->getQuery('end_date_customer');
	if($start_date_customer!="" && $end_date_customer !=""){
		if($start_date_customer != ""){
			$parameter_arr['start_date_customer'] = $start_date_customer;
		}
		if($end_date_customer != ""){
			$parameter_arr['end_date_customer'] = $end_date_customer;
		}
	}
	$customer_id = $this->request->getQuery('customer_id');
	if($customer_id != ""){
		$parameter_arr['customer_id'] = $customer_id;
	}
?>
	<script type="text/javascript">
	<!--
		$(function(){
			$( "#start-date-customer, #end-date-customer" ).datepicker({
				dateFormat : 'yy-mm-dd',
			});
		});
	//-->
	</script>
	<div id="tab-general">
		<div class="row mbl">
			<div class="col-lg-12">
				<div class="col-md-12">
					<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div id="notify_msg_div"></div>
			</div>
			<div class="col-lg-12">
				 <div class="panel panel-grey">
				 
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-6">Customer Report <?php echo $start_date_customer!="" ? "From ".$start_date_customer : "" ?> <?php echo $end_date_customer!="" ? "to ".$end_date_customer : "" ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'customercsv', "?" => $parameter_arr]);?>" target="_blank" class="btn btn-success">Export CSV</a>
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'customerbillpdf', "?" => $parameter_arr]);?>" target="_blank" class="btn btn-orange-middle">View PDF</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								
								<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
								<div class="col-lg-12">
									<div class="row">
										<div class="col-lg-12">
											<div class="panel-body pan">
												<div class="form-body pal">
													<div class="row">
														<div class="col-md-2">
															<div class="form-group">
																<label for="inputName" class="control-label">
																Start Date
																</label>
																<div class="input-icon right">
																	<?php echo $this->Form->control('start_date_customer', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start_date_customer, 'label'=>false, 'required'=>false, 'div'=>false]);?>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label for="inputName" class="control-label">
																End Date
																</label>
																<div class="input-icon right">
																	<?php echo $this->Form->control('end_date_customer', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end_date_customer, 'label'=>false, 'required'=>false, 'div'=>false]);?>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="text-right" style="padding-top: 12%;">
																<?=$this->Form->button('Submit', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-orange','value'=>'Submit']);?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php echo $this->Form->end(); ?>
								
								
								<div class="panel-body pan">
									<div class="form-body pal">
											<table cellpadding="0" cellspacing="0" class="table table-hover">
												<thead>
													<tr>
														<th>Booking Number</th>														
														<th>Customer Name</th>
														<th>Mobile Number</th>
														<th>Room Number</th>
														<th>Room Bill</th>
														<th>Food Bill</th>
														<th>Bar Bill</th>
														<th>House Keeping Bill</th>
														<th>Gross Amount</th>
														<th>Service Charge</th>
														<th>BST Charge</th>
														<th>GST Charge</th>
														<th>Bank Transfer Charge</th>
														<th>Grand Total</th>
														<th>Amount Paid</th>
														<th>Outstanding</th>
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
												$all_bank_transfer_charge = 0;
												$all_amount_paid = 0;
												$all_outstanding = 0;
												$all_grand_amount = 0;
												if(!empty($bookings))
												{
													foreach ($bookings as $booking):
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
													$bank_transfer_charge = 0;
													$final_tally_summery = $this->Common->final_tally_summery($booking->id); 
													$tally_summery = explode("@",$final_tally_summery);
													$amount_payble = round($tally_summery[0]);
													$amount_received = round($tally_summery[1]);
													$outstanding = round($tally_summery[2]);
													$all_amount_paid = $all_amount_paid + $amount_received;
													$all_outstanding = $all_outstanding + $outstanding;
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
														if($booking->allow_bank_transfer_charge == "Y")
														{
															$bank_transfer_charge = $booking->bank_transfer_charge;
														}
													//}
													$all_bst_tax = $all_bst_tax + $bst_tax;
													$all_service_tax = $all_service_tax + $service_tax;
													$all_gst_tax = $all_gst_tax + $gst_tax;
													$all_bank_transfer_charge = $all_bank_transfer_charge + $bank_transfer_charge;
													$grand_total_booking_amount = $gross_amount + $bst_tax + $service_tax + $gst_tax + $bank_transfer_charge;
													$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
												?>
													<tr>
														<td><?php echo h($booking->id); ?></td>														
														<td><?php echo h($booking->customer->full_name); ?> <a href="<?=$this->Url->build(['controller'=>'Customers', 'action'=>'view',$booking->customer_id]);?>" target="_blank"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View', 'border' => '0'))?></a></td>
														<td><?php echo h($booking->customer->mobile_number); ?></td>
														<td><?php echo $show_rooms; ?></td>
														<td><?php echo $site_general_settings->currency.round($room_charge); ?></td>
														<td><?php echo $site_general_settings->currency.round($food_order_total_amount); ?></td>
														<td><?php echo $site_general_settings->currency.round($bar_order_total_amount); ?></td>
														<td><?php echo $site_general_settings->currency.round($house_keeping_total_amount); ?></td>
														<td><?php echo $site_general_settings->currency.round($gross_amount); ?></td>
														<td><?php echo $site_general_settings->currency.round($service_tax); ?> (<?php echo $booking->service_tax; ?>%)</td>
														<td><?php echo $site_general_settings->currency.round($bst_tax); ?> (<?php echo $booking->bst_tax; ?>%)</td>
														<td><?php echo $site_general_settings->currency.round($gst_tax); ?> (<?php echo $booking->gst_tax; ?>%)</td>
														<td><?php echo $site_general_settings->currency.round($bank_transfer_charge); ?></td>
														<td><?php echo $site_general_settings->currency.round($grand_total_booking_amount); ?></td>
														<td><?php echo $site_general_settings->currency.round($amount_received); ?></td>
														<td style="color: <?php echo round($outstanding) > 0 ? 'red' : '' ?>"><?php echo $site_general_settings->currency.round($outstanding); ?></td>
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
														<th><?php echo $site_general_settings->currency.round($all_room_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_food_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_bar_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_house_kipping_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_gross_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_service_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_bst_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_gst_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_bank_transfer_charge); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_grand_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_amount_paid); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_outstanding); ?></th>
													</tr>
												</thead>
											</table>
											<div class="col-lg-12 col-md-12">
												<ul class="service_pagination">
													<?php echo $this->Paginator->prev('< ' . __(''), array(), null, array('class' => 'prev page-numbers disabled'));?>
													<?php echo $this->Paginator->numbers(array('separator' => ''));?>
													<?php echo $this->Paginator->next(__('') . ' >', array(), null, array('class' => 'next page-numbers disabled'));?>
												</ul>
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