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
<br>
<div class="form-group">
  <div class="col-sm-10 col-sm-offset-2">
    <button type="submit" name="<?php echo $action; ?>" class="btn btn-primary bold">
      <?php echo strtoupper($action); ?>
    </button>
  </div>
</div>
<?php echo form_close(); ?>