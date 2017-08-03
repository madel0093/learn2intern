<?php $this->load->view('Public/Header'); ?>
<body>
	<?php $this->load->view('Public/Nav'); ?>
	<?php $this->load->view('Competitions/Sidebar'); ?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<br />
		<?php if( $edit == true ) : ?>
			<div class="text-right">
				<a href="<?php echo base_url(); ?>index.php/competitions/create" class="btn btn-primary bold">Add New Competition</a>
			</div>
			<br>
		<?php endif; ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<table data-toggle="table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true">
							<thead>
								<tr>
									<th data-field="name"       data-sortable="true">Name</th>
									<th data-field="start-time" data-sortable="true">Start Time</th>
									<th data-field="end-time"   data-sortable="true">End Time</th>
									<th data-field="open"       data-sortable="true">Registration</th>
									<th data-field="actions"    data-class="wrapper"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($competitions as $key => $competition) : ?>
									<tr>
										<td><?php echo $competition['name']; ?></td>
										<td><?php echo date('M d, Y  h:i a', strtotime($competition['startTime'])); ?></td>
										<td><?php echo date('M d, Y  h:i a', strtotime($competition['endTime'])); ?></td>
										<td><?php echo $competition['registration_open'] ? "Open" : "Locked"; ?></td>
										<td>
											<a href="<?php echo base_url().'index.php/competitions/index/'.$competition['id']; ?>" class="btn btn-success bold">
												View
											</a>
											<?php if( $edit == true ) : ?>
												<a href="<?php echo base_url().'index.php/competitions/update/'.$competition['id']; ?>" class="btn btn-primary bold">
													Edit 
												</a>
												<a href="<?php echo base_url().'index.php/competitions/delete/'.$competition['id']; ?>" class="btn btn-danger bold">
													Delete
												</a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('Public/Footer'); ?>
</body>
</html>