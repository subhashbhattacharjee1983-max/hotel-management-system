<?php 
	$this->assign('title','Bar Orders (BOT)');
	$this->assign('heading','List of Bar Orders (BOT)');
	$this->assign('breadcrumb',' Bar Orders (BOT)'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'oldbotorder']));
	$today_year = date('Y');
	$year = isset($this->request->getParam('pass')[0]) && $this->request->getParam('pass')[0] != "" ? str_replace("_", " ", $this->request->getParam('pass')[0]) : "";
	if(isset($year) && $year!="")
	{
		$today_year = $year;
	}
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
							<div class="col-lg-3">Bar Orders (BOT)</div>
							<div class="col-lg-6">
								<?php for($i=2025;$i<=date('Y');$i++){ ?>
									<a href="<?php echo $this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'oldbotorder', $i]); ?>" class="btn year-btn <?php echo $i == $today_year ? 'btn-orange-middle' : 'btn-success' ?>"><?php echo $i; ?></a>
								<?php } ?>
							</div>
							<div class="col-lg-3" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Bar Orders (BOT)</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
										<div class="newsCategorys index">
											<table cellpadding="0" cellspacing="0" class="table table-hover">
												<thead>
													<tr>
														<th>Order ID</th>
														<th>Booking ID</th>
														<th>Order Type / Invoice No</th>
														<th>Taken By</th>
														<th>Quantity</th>
														<th>Amount</th>
														<th>Status</th>
														<th>Payment Status</th>
														<th>Order Date</th>
														<th style="width:15%;"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($beverageItemOrders))
												{
													foreach ($beverageItemOrders as $beverageItemOrder):
													$i++;
													if($beverageItemOrder->is_payment == "P"){
														$payment_status_booking = "btn-success";
													}else if($beverageItemOrder->is_payment == "U"){
														$payment_status_booking = "btn-danger";
													}else{
														$payment_status_booking = "btn-yellow";
													}
													if($beverageItemOrder->status == "Y"){
														$status_booking = "btn-success";
													}else{
														$status_booking = "btn-yellow";
													}
												?>
													<tr>
														<td><?php echo h($beverageItemOrder->id); ?></td>
														<td><?php echo h($beverageItemOrder->booking_id); ?> 
														<?php if($beverageItemOrder->order_type == "R"){ ?>
														<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'view', $beverageItemOrder->booking_id]);?>"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View Booking Details', 'border' => '0', 'title' => 'View Booking Details'))?></a>
														<?php } ?>
														</td>
														<td><?php 
															if($beverageItemOrder->order_type == "R"){
																echo "Room: ".$beverageItemOrder->room_number;
															}else if($beverageItemOrder->order_type == "T"){
																echo "Table: ".$beverageItemOrder->table_number;
															}else if($beverageItemOrder->order_type == "E"){
																echo "Conference / Event: ".$beverageItemOrder->table_number;
															}
														?>
														</td>
														<td><?php echo h($beverageItemOrder->booked_by); ?></td>
														<td><?php echo h($beverageItemOrder->total_quantity); ?></td>
														<td><?php echo h($site_general_settings->currency.round($beverageItemOrder->sub_total)); ?></td>
														<td><a style="width: 85px;" class="status_btn status_checks <?php echo $status_booking ?>"><?php echo h($food_order_status[$beverageItemOrder->status]); ?></a></td>
														<td><a style="width: 85px;" class="status_btn status_checks <?php echo $payment_status_booking ?>"><?php echo h($payment_status[$beverageItemOrder->is_payment]); ?></a></td>
														<td><?php echo h(date("d/m/Y H:i:s",strtotime($beverageItemOrder->order_date))); ?></td>
														<td class="actions">															
															<a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'view', $beverageItemOrder->id]);?>"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View Order Details', 'border' => '0', 'title' => 'View Order Details'))?></a>&nbsp;
															<?php if($beverageItemOrder->booking_id == 0){ ?>
															<?php if($beverageItemOrder->is_payment != "P"){ ?>
															<a href="<?=$this->Url->build(['controller'=>'OrderItemPayments', 'action'=>'index',$beverageItemOrder->id,"B"]);?>"><?=$this->Html->image('/img/icons/payment.png', array('alt' => 'Payment', 'border' => '0', 'title' => 'Payment'))?></a>&nbsp;	
															<?php } ?>
															<?php } ?>
															<?php if($beverageItemOrder->is_delivered=="N"){ ?>
															<a onclick="return confirm('✅ Mark as Completed\n\nAre you sure you want to mark this BAR order as completed?\n\nOrder: <?php echo $beverageItemOrder->id; ?>')" href="<?php echo $this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'ordermark',$beverageItemOrder->id]);?>"><?php echo $this->Html->image('/img/icons/mark.jpg', array('alt' => 'Mark as Completed', 'border' => '0', 'title' => 'Mark as Completed'))?></a>&nbsp;
															<?php } ?>
															<a href="<?php echo $this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'orderprint',$beverageItemOrder->id]);?>" target="_blank"><?php echo $this->Html->image('/img/icons/print.jpg', array('alt' => 'Print', 'border' => '0', 'title' => 'Print'))?></a>&nbsp;
														</td>
													</tr>
												<?php 
													endforeach;
												}
												?>
												</tbody>
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
</div>
<script type="text/javascript">
<!--
$(document).ready( function () {
	var table = $('#myTable').DataTable({"order": [[0, 'desc' ]], "lengthMenu": [10, 25, 50, 100],
			"pageLength": 25
	});
});
//-->
</script>