<?php 
	$this->assign('title','Reports');
	$this->assign('heading','Reports');
	$this->assign('breadcrumb','Reports'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'report'])); 
	$startDate = new DateTime('first day of this month');
	$start = $startDate->format('Y-m-d');

	$endDate = new DateTime('last day of this month');
	$end = $endDate->format('Y-m-d');
?>
<script type="text/javascript">
<!--
	$(function(){
		$( "#start-date-master, #end-date-master, #start-date-room, #end-date-room, #start-date-food, #end-date-food, #start-date-bar, #end-date-bar, #start-date-customer, #end-date-customer, #start-date-revenue, #end-date-revenue, #start-date-occupancy, #end-date-occupancy, #start-date-bst, #end-date-bst, #start-date-outstanding, #end-date-outstanding" ).datepicker({
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
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-3">
			<div class="panel panel-grey">
				<div class="panel-heading">Master Bill</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Generate master bills with detailed charge breakdowns for each booking.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_master', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_master', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 7%;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-success','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'masterbillcsv']);?>" target="_blank" style="width: 100%;" class="btn btn-orange">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'masterbillpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-3">
			<div class="panel panel-grey">
				<div class="panel-heading">Room Bill</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Detailed room booking reports with customer information, room details, and pricing.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_room', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_room', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 7%;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-warning','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'roombillcsv']);?>" target="_blank" style="width: 100%;" class="btn btn-pink">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'roombillpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-3">
			<div class="panel panel-grey">
				<div class="panel-heading">Food & Kitchen Bill</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Comprehensive food order reports with customer details and order information.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_food', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_food', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 7%;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-orange','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'foodbillcsv']);?>" target="_blank" style="width: 100%;" class="btn btn-info">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'foodbillpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-3">
			<div class="panel panel-grey">
				<div class="panel-heading">Beverage & Bar Bill</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Detailed bar order reports with customer information and beverage details.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_bar', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_bar', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 7%;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-yellow','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'barbillcsv']);?>" target="_blank" style="width: 100%;" class="btn btn-violet">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'barbillpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-3">
			<div class="panel panel-grey">
				<div class="panel-heading">Customer Report</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>View customer statistics, booking history, and spending patterns.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_customer', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_customer', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 7%;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-danger','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'customercsv']);?>" target="_blank" style="width: 100%;" class="btn btn-warning">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'customerbillpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-3">
			<div class="panel panel-grey">
				<div class="panel-heading">Revenue Report</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Generate reports on revenue from room bookings, food orders, and services.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_revenue', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_revenue', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 7%;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-pink','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'revenuecsv']);?>" target="_blank" style="width: 100%;" class="btn btn-yellow">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 14%;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'revenuepdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">Occupancy Report</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Analyze room occupancy rates and trends over time.</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_occupancy', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_occupancy', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 40px;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-violet','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 19px;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'occupancycsv']);?>" target="_blank" style="width: 100%;" class="btn btn-success">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 19px;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'occupancypdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">BST Collection Report</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Comprehensive BST (Bhutan Service Tax) collection report from all sources including Room, Restaurant, Bar, and Services. <br /><strong>Data Sources:</strong> Room Bills, Food Orders, Bar Orders, Service Orders<br /><strong>Columns:</strong> Room No, Customer Name, Date, Section, Bill No, Receipt No, BST Amount, Total Bill</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_bst', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_bst', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 27px;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-success','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 19px;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'bstbillcsv']);?>" target="_blank" style="width: 100%;" class="btn btn-pink">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 19px;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'bstbillpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create("", ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">Outstanding / Force Checkout Report</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<p>Track outstanding dues and force checkout cases for better accounts management and follow-up. <br /><strong>Filters:</strong> Daily, Weekly, Monthly, Quarterly, Last Week/Month/Quarter, Custom<br /><strong>Columns:</strong> Room No, Customer, Contact, Check-in/out Date, Total/Paid/Outstanding, Remarks</p>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Start Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('start_date_outstanding', ['autocomplete' => 'off', 'placeholder' => 'Start Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $start, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												End Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('end_date_outstanding', ['autocomplete' => 'off', 'placeholder' => 'End Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $end, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="text-right" style="padding-top: 45px;">
												<?=$this->Form->button('Generate Report', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-danger','value'=>'Submit']);?>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 19px;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'outstandingcsv']);?>" target="_blank" style="width: 100%;" class="btn btn-info">Export CSV</a>
											</div>
										</div>
										<div class="col-md-6">
											<div style="padding-top: 19px;">
												<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'outstandingpdf']);?>" target="_blank" style="width: 100%;" class="btn btn-orange-middle">View PDF</a>
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
		<?php echo $this->Form->end(); ?>
	</div>
</div>