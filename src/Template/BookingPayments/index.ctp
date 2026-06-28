<?php 
	$this->assign('title','Payment Process');
	$this->assign('heading','List of Payment Process');
	$this->assign('breadcrumb',' Payment Process'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'BookingPayments', 'action'=>'index'])); 
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
							<div class="col-lg-6">Payment Process for Booking Id: <?php echo $booking_id ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'index', $booking_id]);?>" class="btn btn-success">Back to Bookings</a>
								<a href="<?=$this->Url->build(['controller'=>'BookingPayments', 'action'=>'add', $booking_id]);?>" class="btn btn-orange-middle">Add Payment</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<?php echo $this->Common->booking_payment($booking_id); ?>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
										<div class="newsCategorys index">
											<table cellpadding="0" cellspacing="0" class="table table-hover" id="myTable">
												<thead>
													<tr>
														<th>#</th>
														<th>Bill Type</th>
														<th>Payment Method</th>
														<th>Payment Price</th>
														<th>Payment Date</th>
														<th>Payment Time</th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($bookingPayments))
												{
													foreach ($bookingPayments as $bookingPayment):
													$i++;
												?>
													<tr>
														<td><?php echo $i; ?>&nbsp;</td>
														<td><?php echo h($bill_type[$bookingPayment->bill_type]); ?></td>
														<td><?php echo h($payment_method[$bookingPayment->payment_method]); ?></td>
														<td><?php echo $site_general_settings->currency; ?><?php echo h(round($bookingPayment->payment_price)); ?>&nbsp;</td>
														<td><?php echo h($this->Common->entry_date($bookingPayment->payment_date)); ?></td>
														<td><?php echo h($bookingPayment->payment_time); ?></td>
														<!-- <td class="actions">															
															<a href="<?php //echo $this->Url->build(['controller'=>'BookingPayments', 'action'=>'edit',$bookingPayment->id, $bookingPayment->booking_id]);?>"><?php //echo $this->Html->image('/img/icons/edit.png', array('alt' => 'Edit', 'border' => '0', 'title' => 'Edit'  ))?></a>&nbsp;
															<a onclick="return confirm('Are you sure you want to delete?')" href="<?php //echo $this->Url->build(['controller'=>'BookingPayments', 'action'=>'delete',$bookingPayment->id, $bookingPayment->booking_id]);?>"><?php //echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a>
														</td> -->
													</tr>
												<?php 
													endforeach;
												}
												?>
												</tbody>
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
<script type="text/javascript">
<!--
$(document).ready( function () {
	var table = $('#myTable').DataTable();
});
//-->
</script>