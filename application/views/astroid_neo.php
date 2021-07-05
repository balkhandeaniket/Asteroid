<?php $this->load->view('common/header'); 

 ?> 
	<div class="container">
		<center><h4>Asteroid Neo</h4></center>	
		<form method="post" action="<?= site_url('Asteroid_neo/search_action') ?>">
			<input type="text" name="from_date" required id="datepicker1" readonly placeholder="From Date">
			<input type="text" name="to_date" required id="datepicker2" readonly placeholder="To Date">
			<button type="submit" class="btn btn-info" >Submit</button>
		</form>	

	 	<?php 
	 		if ($message=="success") { 
	 		
	 	?>
	 		<div class="clearfix">&nbsp;</div>
	 		<span class="alert alert-success"><b>Fastest Asteroid in km/h : </b><?= $fastest_distance ?></span>
	 		<div class="clearfix">&nbsp;</div>
	 		<span class="alert alert-success"><b>Closest Asteroid : </b><?= $closest_distance ?></span>
	 		<div class="clearfix">&nbsp;</div>
	 		<span class="alert alert-success"><b>Average Size of the Asteroids in kilometers (Min) : </b><?= $estimated_diameter_min ?></span>
	 		<div class="clearfix">&nbsp;</div>
	 		<span class="alert alert-success"><b>Average Size of the Asteroids in kilometers (Max) : </b><?= $estimated_diameter_max ?></span>
	 		<br><br>
	 		<canvas id="myChart" width="100px" height="100px"></canvas>

	 		<table class="table table-bordered">
	 			<thead>
	 				<tr>
	 					<th>Name</th>
		 				<th>Fastest Asteroid in km/h</th>
		 				<th>Closest Asteroid</th>
	 				</tr>
	 			</thead>
	 			<tbody>
	 				<?php foreach ($neo_datas as $neo_data_row) {  ?>
		 				<tr>
		 					<td><?= $neo_data_row['name'] ?></td>
			 				<td><?= $neo_data_row['kilometers_per_hour'] ?></td>
			 				<td><?= $neo_data_row['close_distance'] ?></td>
		 				</tr>
	 				<?php } ?>
	 			</tbody>
	 		</table>	
	 	<?php }else if(!empty($message)) { ?>
	 		<br><br>
	 		<span class="alert alert-danger"><?= $message ?></span>
	 	<?php } ?>

	</div>

<?php $this->load->view('common/footer'); ?> 
<script type="text/javascript">
	var ctx = document.getElementById('myChart').getContext('2d');
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			       labels: [<?= $date ?>],
			        datasets: [{
			            label: '# of Votes',
			            data: [<?= $date_count ?>],
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            y: {
			                beginAtZero: true
			            }
			        }
			    }
			});
</script>
