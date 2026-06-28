<?php 
	$this->assign('title','Payment Process');
	$this->assign('heading','List of Payment Process');
	$this->assign('breadcrumb',' Payment Process'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'OrderItemPayments', 'action'=>'index'])); 
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
							<div class="col-lg-6">Payment Process for Item Order Id: <?php echo $order_payment_id ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<?php if(isset($table_type) && $table_type == "F"){ ?>
								<a href="<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'index']);?>" class="btn btn-success">Back to Orders</a>
								<?php } ?>
								<?php if(isset($table_type) && $table_type == "B"){ ?>
								<a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'index']);?>" class="btn btn-success">Back to Orders</a>
								<?php } ?>
								<a href="<?=$this->Url->build(['controller'=>'OrderItemPayments', 'action'=>'add', $order_payment_id, $table_type]);?>" class="btn btn-orange-middle">Add Payment</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<?php echo $this->Common->order_item_payment($order_payment_id, $table_type); ?>
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
														<th class="actions"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($orderItemPayments))
												{
													foreach ($orderItemPayments as $orderItemPayment):
													$i++;
												?>
													<tr>
														<td><?php echo $i; ?>&nbsp;</td>
														<td><?php echo h($bill_type[$orderItemPayment->bill_type]); ?></td>
														<td><?php echo h($payment_method[$orderItemPayment->payment_method]); ?></td>
														<td><?php echo $site_general_settings->currency; ?><?php echo h(round($orderItemPayment->payment_price)); ?>&nbsp;</td>
														<td><?php echo h($this->Common->entry_date($orderItemPayment->payment_date)); ?></td>
														<td class="actions">															
															<a href="<?php echo $this->Url->build(['controller'=>'BookingPayments', 'action'=>'edit',$orderItemPayment->id, $orderItemPayment->booking_id]);?>"><?php echo $this->Html->image('/img/icons/edit.png', array('alt' => 'Edit', 'border' => '0', 'title' => 'Edit'  ))?></a>&nbsp;
															<!-- <a onclick="return confirm('Are you sure you want to delete?')" href="<?php //echo $this->Url->build(['controller'=>'BookingPayments', 'action'=>'delete',$orderItemPayment->id, $orderItemPayment->booking_id]);?>"><?php //echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a> -->
														</td>
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
