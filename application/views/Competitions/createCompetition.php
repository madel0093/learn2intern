<?php $this->load->view('Public/Header'); ?>

<body>

	<?php $this->load->view('Public/Nav'); ?>

	<?php $this->load->view('Competitions/Sidebar'); ?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<br />
		<div class="panel panel-default">
			<div class="panel-heading">Create New Competition</div>
			<div class="panel-body">
				<?php 
				$this->load->view('Competitions/competitionForm', array(
					'model' => $model,
					'action' => $action,
					'supervisors' => $supervisors
					)
				);
				?>
			</div>
		</div>

	</div>

	<?php $this->load->view('Public/Footer'); ?>

</body>

</html>