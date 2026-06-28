<?php 
	$this->assign('title','Refund Payment Process');
	$this->assign('heading','List of Refund Payment Process');
	$this->assign('breadcrumb','Refund Payment Process'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'RefundPayments', 'action'=>'index'])); 
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
							<div class="col-lg-6">Refund Payment to <?php echo $booking->customer->full_name ?> for Order Id: <?php echo $booking_id ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'cancellation', $booking_id]);?>" class="btn btn-success">Back to Orders</a>
								<a href="<?=$this->Url->build(['controller'=>'RefundPayments', 'action'=>'add', $booking_id]);?>" class="btn btn-orange-middle">Add Payment</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<?php echo $this->Common->booking_payment_for_reservation($booking_id); ?>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
										<div class="newsCategorys index">
											<table cellpadding="0" cellspacing="0" class="table table-hover" id="myTable">
												<thead>
													<tr>
														<th>Id</th>
														<th>Bill Type</th>
														<th>Payment Method</th>
														<th>Payment Price</th>
														<th>Payment Date</th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($refundPayments))
												{
													foreach ($refundPayments as $refundPayment):
													$i++;
												?>
													<tr>
														<td><?php echo $i; ?>&nbsp;</td>
														<td><?php echo h($bill_type[$refundPayment->bill_type]); ?></td>
														<td><?php echo h($payment_method[$refundPayment->payment_method]); ?></td>
														<td><?php echo $site_general_settings->currency; ?><?php echo h(round($refundPayment->payment_price)); ?>&nbsp;</td>
														<td><?php echo h($this->Common->entry_date($refundPayment->payment_date)); ?></td>
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
