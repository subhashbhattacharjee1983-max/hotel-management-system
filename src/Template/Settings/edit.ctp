<?php 
	$this->assign('title','Setting');
	$this->assign('heading','Settings');
	$this->assign('breadcrumb','Setting'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Settings', 'action'=>'edit'])); 
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#edit-form").validationEngine();
	});
//-->
</script>
<script type="text/javascript">
	CKEDITOR.config.autoParagraph = false;
	CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
	CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
	CKEDITOR.config.protectedSource.push(/<i[^>]*><\/i>/g);
	CKEDITOR.config.allowedContent = true;
	function delete_image(image_field_name, id, cur)
	{
		if(confirm("Do you really want to delete this image"))
		{
			$.ajax({
				type:"POST",
				dataType: 'json',
				url:"<?=$this->Url->build(['controller'=>'Settings', 'action'=>'imagedelete'])?>/"+image_field_name+"/"+id,
				beforeSend: function(){
				},
				success: function(response){
					//alert(JSON.stringify(response, null, 4));
					//alert(response);
					if(response.msg=="success")
					{
						$("#up_"+image_field_name+"_preview img").attr("src", "").css("display", "none");
						cur.remove();
						//alert(response.success);
						showCustomMessage('<div class="message success">Image has been deleted successfully.</div>');
					}
					else
					{
						//alert(response.msg);
						showCustomMessage('<div class="message error">Error occurs to delete image.</div>');
					}
				},
				error: function(){
					alert("We are having some problem. Please try later.");
				}
			});
		}
	}
</script>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="col-md-12">
				<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
				</div>
			</div>
		</div>
		<?php echo $this->Form->create($setting, ["name" => "edit-form", "id" => "edit-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<?php 									
			echo $this->Form->control('website_logo', ['type'=>'hidden', 'hiddenField' => true]);
		?>
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">Site Info</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Site Name <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('website_name', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Website name is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Billing Email Address <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('billing_email_address', ['autocomplete' => 'off', 'class' => 'form-control validate[required,custom[email]]', 'data-errormessage-value-missing'=>'Billing Address is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Mobile Number <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('phone_number', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Mobile number is required']);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Whatsapp Number
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('whatsapp_number', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Whatsapp number is required']);?>
												</div>
											</div>
										</div>	
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Company Name
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('company_name', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Company Name is required']);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Business Logo
												</label>
												<div class="input-icon right">
													<?=$this->Form->control('up_website_logo',['type' => 'file', 'label'=>false, 'required'=>false, 'div'=>false,'class' => 'form-control', 'style'=>'padding:0', 'data-id'=>'up_website_logo_preview']);?>
													<?php 
													if(isset($setting->website_logo) && trim($setting->website_logo)!='' && file_exists(WWW_ROOT . $upload_folder . DS . $website_logo_folder . DS . $setting->website_logo)){
														echo $this->Html->div(null, $this->Html->image('/'.$upload_folder.'/'.$website_logo_folder.'/'.$setting->website_logo, ['alt' => '', 'border' => '0', 'style'=>'max-width:100px;']), ['id'=>'up_website_logo_preview', 'style' => 'padding:10px 0 0 0;']);
														echo $this->Html->image('/img/icons/delete.png', ['alt' => 'Delete Image', 'border' => '0', 'style'=>'margin-left:145px;margin-top:-44px;cursor:pointer', 'class'=>'del_img', 'onclick'=>'delete_image("website_logo", '.$setting->id.', $(this))']);
													}
													else
													{
														echo $this->Html->div([], $this->Html->image([], ['alt' => '', 'border' => '0', 'style'=>'max-width:260px;display:none']), ['id'=>'up_website_logo_preview', 'style' => 'padding:10px 0 0 0;']);
													}
													?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Currency
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('currency',['type'=>'select','options'=>$currency, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Site Url <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('site_url', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Site Url is required']);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Billing Address <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('street_address', ['type'=>'textarea', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
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
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">Tax</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group" style="margin: 0 0 45px; background: #f76600; color: #FFF; padding: 5px 0 0 15px;">
												<label for="inputName" class="control-label">
													<h4><b>Room Booking Tax</b></h4>
												</label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Service Charge (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('service_tax', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Bhutan Sales Tax (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('bst_tax', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												GST (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('gst_tax', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Bank Transfer Charge <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('bank_transfer_charge', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group" style="margin: 27px 0 45px; background: #f76600; color: #FFF; padding: 5px 0 0 15px;">
												<label for="inputName" class="control-label">
													<h4><b>Food & Kitchen (KOT) Tax</b></h4>
												</label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Service Charge (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_service_tax', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Bhutan Sales Tax (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_bst_tax', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												GST (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_gst_tax', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group" style="margin: 27px 0 45px; background: #f76600; color: #FFF; padding: 5px 0 0 15px;">
												<label for="inputName" class="control-label">
													<h4><b>Beverage & Bar (BOT) Tax</b></h4>
												</label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Service Charge (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('bar_service_tax', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Bhutan Sales Tax (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('bar_bst_tax', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												GST (%) <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('bar_gst_tax', ['type'=>'text', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
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
		<div class="col-lg-6"></div>
		<div class="col-lg-6">
			<div class="form-body">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right" style="padding-top: 7%;">
							<?=$this->Form->button('Submit for both site info and tax', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-booking','value'=>'Login']);?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script>
	$("label").each(function() {
	var label = $(this);
	var placeholder = label.text();
	label.parent(".form-group").find(".form-control").attr("placeholder", placeholder.trim());
	});
</script>