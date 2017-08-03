<?php $this->load->view('Public/Header'); ?>
<body>
	<?php $this->load->view('Public/Nav'); ?>
	<?php $this->load->view('Competitions/Sidebar'); ?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			</ol>
		</div>
		<br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo $competition->name; ?>
			</div>
			<div class="panel-body">
				<table class="table table-striped single-competition">
					<tbody>
						<tr>
							<td>Name</td>
							<td><?php echo $competition->name; ?></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><?php echo $competition->description; ?></td>
						</tr>
						<tr>
							<td>Start Time</td>
							<td><?php echo date('M d, Y  h:i a', strtotime($competition->startTime)); ?></td>
						</tr>
						<tr>
							<td>End Time</td>
							<td><?php echo date('M d, Y  h:i a', strtotime($competition->endTime)); ?></td>
						</tr>
						<tr>
							<td>Registration</td>
							<td><?php echo $competition->registration_open ? "Open" : "Locked"; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<?php echo $competition->name; ?> Challenges
			</div>
			<div class="panel-body">
				<?php if( $edit == true ) : ?>
					<div class="text-right">
						<a href="<?php echo base_url(); ?>index.php/challenges/create/<?php echo $competition->getID(); ?>" class="btn btn-primary bold">
							Add New Challenge
						</a>
					</div>
					<br>
				<?php endif; ?>
				<table data-toggle="table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true">
					<thead>
						<tr>
							<th data-field="name"     data-sortable="true">Name</th>
							<th data-field="actions"  data-class="wrapper"></th>
						</tr>
					</thead>
					<tbody>
						<?php if( !empty($challenges) ) : ?>
							<?php foreach ($challenges as $challenge) : ?>
								<tr>
									<td><?php echo $challenge['name']; ?></td>
									<td>
										<a href="<?php echo base_url().'index.php/challenges/index/'.$challenge['id']; ?>" class="btn btn-success bold">
											View
										</a>
										<?php if( $edit == true ) : ?>
											<a href="<?php echo base_url().'index.php/challenges/update/'.$challenge['id']; ?>" class="btn btn-primary bold">
												Edit 
											</a>
											<a href="<?php echo base_url().'index.php/challenges/delete/'.$challenge['id']; ?>" class="btn btn-danger bold">
												Delete
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php $this->load->view('Public/Footer'); ?>
</body>
</html>