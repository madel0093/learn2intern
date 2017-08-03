<?php $model->startTime = date('M d, Y  h:i a', strtotime($model->startTime)); ?>
<?php $model->endTime   = date('M d, Y  h:i a', strtotime($model->endTime)); ?>

<?php echo form_open('', array('role'=>'form', 'class'=>'form-horizontal')); ?>
<div class="form-group <?php echo form_error('name') ? 'has-error' : ''; ?>">
	<label class="control-label col-sm-2">Name</label>
	<div class="col-sm-10">
		<?php echo form_input('name', $model->name, array('class'=>'form-control', 'required'=>'')); ?>
		<?php echo form_error('name', '<p class="error">', '</p>'); ?>
	</div>
</div>
<div class="form-group <?php echo form_error('description') ? 'has-error' : ''; ?>">
	<label class="control-label col-sm-2">Description</label>
	<div class="col-sm-10">
		<?php echo form_textarea('description', $model->description, array('class'=>'form-control', 
		'required'=>'')) ?>
		<?php echo form_error('description', '<p class="error">', '</p>'); ?>
	</div>
</div>
<div class="form-group <?php echo form_error('startTime') ? 'has-error' : ''; ?>">
	<label class="control-label col-sm-2">Start Time</label>
	<div class="col-sm-10">
		<?php 
		echo form_input('startTime', $model->startTime, array('class'=>'form-control calendar-datetime',
			'required'=>''));
		echo form_error('startTime', '<p class="error">', '</p>'); 
		?>
	</div>
</div>
<div class="form-group <?php echo form_error('endTime') ? 'has-error' : ''; ?>">
	<label class="control-label col-sm-2">End Time</label>
	<div class="col-sm-10">
		<?php 
		echo form_input('endTime', $model->endTime, array('class'=>'form-control calendar-datetime',
			'required'=>''));
		echo form_error('endTime', '<p class="error">', '</p>');
		?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<div class="checkbox">
			<label>
				<?php echo form_checkbox('registration_open', 'true', $model->registration_open); ?>
				Registration Open
			</label>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2">Supervisors</label>
	<div class="col-sm-10">
		<?php $options = array(); 
		foreach ($supervisors as $supervisor)
			$options[ $supervisor['id'] ] = $supervisor['username'];
		
		echo form_multiselect('supervisors[]', $options, $current_supervisors, 
		array('class'=>'form-control select2')); ?>
		<?php echo form_error('supervisors[]', '<p class="error">', '</p>'); ?>
	</div>
</div>
<br>
<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<button type="submit" name="<?php echo $action; ?>" class="btn btn-primary bold">
			<?php echo strtoupper($action); ?>
		</button>
	</div>
</div>
<?php echo form_close(); ?>