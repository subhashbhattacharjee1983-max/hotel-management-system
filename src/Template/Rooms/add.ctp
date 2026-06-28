<?php 
	$this->assign('title','Room');
	$this->assign('heading','Add Room');
	$this->assign('breadcrumb','Room'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Rooms', 'action'=>'index'])); 
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#add-form").validationEngine();
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
		<div class="col-lg-12">
			<div id="notify_msg_div"></div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-grey">
				<div class="panel-heading">Add Room </div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<?php echo $this->Form->create($room,["name" => "add-form", "id" => "add-form", "method" => "POST", "type" => "file"]); ?>
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Room Number
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_number', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Floor
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('floor', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Room Category
												</label>
												<div class="input-icon right">
													<?php 
													$options = array();
													if(!empty($roomCategories))
													{
														foreach($roomCategories as $key => $val)
														{
															array_push($options, array('text' => $val->room_category_name.' - '.$site_general_settings->currency.number_format($val->price_per_night,2).' / night', 'value' => $val->id));
														}
													}
													echo $this->Form->control('room_category_id',['type'=>'select','options'=>$options, 'class'=>'form-control validate[required]', 'empty'=>'Room Category', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Description
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('description', ['type'=>'textarea',  'autocomplete' => 'off', 'id'=>'editor1', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Description is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Room Status
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_status',['type'=>'select','options'=>$room_status, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
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
										<?=$this->Form->button('Add', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-orange-middle','value'=>'Login']);?>
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