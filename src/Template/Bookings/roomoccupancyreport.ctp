<?php 
	$this->assign('title','Room Occupancy Report');
	$this->assign('heading','List of Room Occupancy Report');
	$this->assign('breadcrumb','Room Occupancy Report'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'report'])); 
	$start_date_occupancy = $this->request->getQuery('start_date_occupancy');
	$end_date_occupancy = $this->request->getQuery('end_date_occupancy');
	$room_number = "";
	$number_of_days = "";
	if(!empty($room)){
		foreach($room as $room_val){
			$total_room = $this->Common->total_room_occupancy($room_val->room_number, $start_date_occupancy, $end_date_occupancy);
			$room_number .= "'Room ".$room_val->room_number."', ";
			$number_of_days .= $total_room.", ";
		}
		$room_number = rtrim($room_number,", ");
		$number_of_days = rtrim($number_of_days,", ");
	}
?>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        h1 {
            color: #333;
        }
        #chart-container {
            width: 80%;
            margin: auto;
        }
		canvas {
			max-width: 100%;
		}
    </style>
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
							<div class="col-lg-6">Room Occupancy Report From <?php echo $start_date_occupancy ?> to <?php echo $end_date_occupancy ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'occupancycsv', $start_date_occupancy, $end_date_occupancy]);?>" target="_blank" class="btn btn-success">Export CSV</a>
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'occupancypdf', $start_date_occupancy, $end_date_occupancy]);?>" target="_blank" class="btn btn-orange-middle">View PDF</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
											<div id="chart-container">
												<canvas id="occupancyChart"></canvas>
											</div>

											<script>
												// Sample data: rooms and number of days occupied
												const roomLabels = [<?php echo $room_number ?>];
												const occupancyDays = [<?php echo $number_of_days ?>]; // e.g., days occupied during the report period

												const ctx = document.getElementById('occupancyChart').getContext('2d');
												const occupancyChart = new Chart(ctx, {
													type: 'bar',
													data: {
														labels: roomLabels,
														datasets: [{
															label: 'Days Occupied',
															data: occupancyDays,
															backgroundColor: 'rgba(54, 162, 235, 0.6)',
															borderColor: 'rgba(54, 162, 235, 1)',
															borderWidth: 1
														}]
													},
													options: {
														scales: {
															y: {
																beginAtZero: true,
																title: {
																	display: true,
																	text: 'Number of Days'
																}
															},
															x: {
																title: {
																	display: true,
																	text: 'Room Number'
																}
															}
														},
														plugins: {
															legend: {
																display: false
															},
															title: {
																display: true,
																text: 'Room Occupancy (in <?php echo $start_date_occupancy ?> to <?php echo $end_date_occupancy ?>)'
															}
														}
													}
												});
											</script>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>