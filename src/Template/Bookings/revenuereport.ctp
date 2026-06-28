<?php 
	$this->assign('title','Revenue Report');
	$this->assign('heading','List of Revenue Report');
	$this->assign('breadcrumb','Revenue Report'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'report'])); 
	$start_date_revenue = $this->request->getQuery('start_date_revenue');
	$end_date_revenue = $this->request->getQuery('end_date_revenue');
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
				<div id="notify_msg_div"></div>
			</div>
			<div class="col-lg-12">
				 <div class="panel panel-grey">
				 
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-6">Revenue Report From <?php echo $start_date_revenue ?> to <?php echo $end_date_revenue ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'revenuecsv', $start_date_revenue, $end_date_revenue]);?>" target="_blank" class="btn btn-success">Export CSV</a>
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'revenuepdf', $start_date_revenue, $end_date_revenue]);?>" target="_blank" class="btn btn-orange-middle">View PDF</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
											<table cellpadding="0" cellspacing="0" class="table table-hover">
												<thead>
													<tr>
														<th>Booking Number</th>														
														<th>Room Number</th>
														<th>Room Charge</th>
														<th>Food Charge</th>
														<th>Bar Charge</th>
														<th>House Keeping Charge</th>
														<th>Gross Amount</th>
														<th>Service Charge</th>
														<th>BST Charge</th>
														<th>GST Charge</th>
														<th>Bank Transfer Charge</th>
														<th>Grand Total</th>
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