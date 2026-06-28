<?php 
	$this->assign('title','Payment');
	$this->assign('heading','Add Payment');
	$this->assign('breadcrumb','Payment'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'BookingPayments', 'action'=>'index'])); 
?>
<script type="text/javascript">
<!--
	function YourOnSubmitFn()
	{
		if($("#add-form").validationEngine('validate')==true)
		{
			$("#btn_submit").attr("disabled", true);
			$("#loader_section").show();
			$("#add-form").submit();
		}
	}
	
	document.onkeydown = function(e){
		if (e.ctrlKey &&
			(e.keyCode === 67 ||
				e.keyCode === 86 ||
				e.keyCode === 85 ||
				e.keyCode === 123 ||
				e.keyCode == 'E'.charCodeAt(0) ||
				e.shiftKey && e.keyCode == 'I'.charCodeAt(0) ||
				e.shiftKey && e.keyCode == 'J'.charCodeAt(0) ||
				e.keyCode == 'S'.charCodeAt(0) ||
				e.keyCode === 117)) {
				return false;
			} else {
				return true;
			}
		};
		$(document).bind("contextmenu",function(e){
		  e.preventDefault();
		  return false;
		}); 
		function disableselect(e) {
		  return false
		}

		function reEnable() {
		  return true
		}

	
	function is_amount(evt, element) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (
			//(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
			(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
			(charCode < 48 || charCode > 57))
			return false;
		return true;
	}
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
						<div class="col-lg-6">Add Payment for Booking Id: <?php echo $booking_id ?></div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'BookingPayments', 'action'=>'index', $booking_id]);?>" class="btn btn-orange-middle">Back to Payment History</a>
						</div>	
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<?php echo $this->Form->create($bookingPayment,["name" => "add-form", "id" => "add-form", "method" => "POST", "type" => "file"]); ?>
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<?php echo $this->Common->booking_payment($booking_id); ?>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Bill Type <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('bill_type',['type'=>'select','options'=>$bill_type, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Payment Method <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('payment_method',['type'=>'select','options'=>$payment_method, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Payment Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('payment_price', ['autocomplete' => 'off', 'value' => $booking_payment, 'class' => 'form-control validate[required]', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return is_amount(event, this)']);?>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Payment Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('payment_date', ['autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control validate[required]', 'value' => date("Y-m-d"), 'style' => 'background: #FFFFFF', 'label'=>false, 'required'=>false, 'div'=>false, 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Payment Time <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('payment_time', ['autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control validate[required]', 'value' => date("H:i:s"), 'style' => 'background: #FFFFFF', 'label'=>false, 'required'=>false, 'div'=>false, 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Payment Notes
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('description', ['type'=>'textarea',  'autocomplete' => 'off', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Payment Notes is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
									</div>
									<div class="form-actions text-right pal">
										<?=$this->Form->button('Submit', ['type'=>'button', 'name'=>'btn_submit', 'id'=>'btn_submit', 'class'=>'btn btn-orange-middle', 'value'=>'Submit', 'onclick' => 'YourOnSubmitFn()']);?>
									</div>
									<?php echo $this->Form->end(); ?>
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
	$("label").each(function() {
		var label = $(this);
		var placeholder = label.text();
		label.parent(".form-group").find(".form-control").attr("placeholder", placeholder.trim());
	});
//-->
</script>
