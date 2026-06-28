<?php 
	$this->assign('title','Customer');
	$this->assign('heading','Edit Customer');
	$this->assign('breadcrumb','Customer'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Customers', 'action'=>'index'])); 
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#edit-form").validationEngine();
	});

	function number(evt){
	 var charCode = (evt.which) ? evt.which : event.keyCode;
	 if(charCode>31 && (charCode<48 || charCode>57))
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
				<div class="panel-heading">Edit Customer </div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<?php echo $this->Form->create($customer,["name" => "edit-form", "id" => "edit-form", "method" => "POST", "type" => "file"]); ?>
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Full Name *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('full_name', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Full name is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Email Address *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('email_address', ['autocomplete' => 'off', 'class' => 'form-control validate[custom[email]]', 'data-errormessage-value-missing'=>'Email Address is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Mobile Number *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('mobile_number', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Mobile number is required', 'data-errormessage-value-missing'=>'Mobile number is required', 'onKeyPress' => 'return number(event, this)', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Guest Category *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('guest_category',['type'=>'select','options'=>$guest_category, 'class'=>'form-control validate[required]', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Address *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('address', ['type'=>'textarea', 'placeholder' => 'Address', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													ID Type *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('id_type',['type'=>'select','options'=>$id_type, 'class'=>'form-control validate[required]', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Id Number *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('id_number', ['type'=>'text', 'placeholder' => 'Id Number', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Id number is required']);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Status
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('status',['type'=>'select','options'=>$status, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="form-actions text-right pal">
										<?=$this->Form->button('Update', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-orange-middle','value'=>'Login']);?>
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