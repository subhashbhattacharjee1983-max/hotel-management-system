<?php 
	$this->assign('title','Customer');
	$this->assign('heading','View Customer');
	$this->assign('breadcrumb','Customer'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Customers', 'action'=>'index'])); 
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
				<div class="panel-heading">View Customer </div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Full Name
												</label>
												<div class="input-icon right">
													<?php echo $customer->full_name;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Email Address
												</label>
												<div class="input-icon right">
													<?php echo $customer->email_address;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Mobile Number
												</label>
												<div class="input-icon right">
													<?php echo $customer->mobile_number;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Guest Category
												</label>
												<div class="input-icon right">
													<?php echo $customer->guest_category; ?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Address
												</label>
												<div class="input-icon right">
													<?php echo $customer->address;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													ID Type
												</label>
												<div class="input-icon right">
													<?php echo $customer->id_type; ?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Id Number
												</label>
												<div class="input-icon right">
													<?php echo $customer->id_number;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Status
												</label>
												<div class="input-icon right">
													<?php echo $status[$customer->status]; ?>
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