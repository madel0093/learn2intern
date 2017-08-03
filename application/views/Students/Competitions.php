<?php $this->load->view('Public/Header'); ?>
<body>
	<?php $this->load->view('Public/Nav'); ?>
	<?php $this->load->view('Students/Sidebar'); ?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<br>
		<div class="row row-eq-height">
			<?php foreach($Competitions as $Competition): ?>
				<div class="col-md-4 col-sm-6">
					<div class="panel panel-info block">
						<div class="panel-heading">
							<?php echo $Competition['model']->name; ?>
						</div>
						<div class="panel-body">
							<p style="min-height: 100px;"><?php echo substr($Competition['model']->description, 0, 150)."......"; ?>
							</p>
							<div class="pull-right">
								<?php if($Competition['registered'] == true ) : ?>
									<a href="<?php echo site_url(array('students/competition', $Competition['model']->id)); ?>" class="btn btn-success">Enter</a>
								<?php elseif($Competition['registered'] == false && $Competition['model']->registration_open == true ) : ?>
									<a href="<?php echo site_url(array('students/registercompetition', $Competition['model']->id)); ?>" class="btn btn-primary">Register</a>
								<?php else : ?>
									<button type="button" class="btn btn-primary disabled">Register</button>
								<?php endif; ?>
							</div> 
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<?php $this->load->view('Public/Footer'); ?>
</body>

</html>