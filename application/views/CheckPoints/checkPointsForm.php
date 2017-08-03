<?php echo form_open('', array('role'=>'form', 'class'=>'form-horizontal', 'novalidate'=>'')); ?>
<div class="form-group <?php echo form_error('name') ? 'has-error' : ''; ?>">
  <label class="control-label col-sm-2">Name</label>
  <div class="col-sm-10">
    <?php echo form_input('name', $model->name, array('class'=>'form-control', 'required'=>'')); ?>
    <?php echo form_error('name', '<p class="error">', '</p>'); ?>
  </div>
</div>
<div class="form-group <?php echo form_error('instructions') ? 'has-error' : ''; ?>">
  <label class="control-label col-sm-2">Instructions</label>
  <div class="col-sm-10">
    <?php echo form_textarea('instructions', $model->instructions, array('class'=>'form-control', 'required'=>'')); ?>
    <?php echo form_error('instructions', '<p class="error">', '</p>'); ?>
  </div>
</div>
<div class="form-group <?php echo form_error('trials') ? 'has-error' : ''; ?>">
  <label class="control-label col-sm-2">Trials</label>
  <div class="col-sm-10">
    <?php echo form_input('trials', $model->trials, array('class'=>'form-control', 'required'=>'')); ?>
    <?php echo form_error('trials', '<p class="error">', '</p>'); ?>
  </div>
</div>
<div class="form-group <?php echo form_error('score') ? 'has-error' : ''; ?>">
  <label class="control-label col-sm-2">Score</label>
  <div class="col-sm-10">
    <?php echo form_input('score', $model->score, array('class'=>'form-control', 'required'=>'')); ?>
    <?php echo form_error('score', '<p class="error">', '</p>'); ?>
  </div>
</div>
<div class="form-group <?php echo form_error('type') ? 'has-error' : ''; ?>">
  <label class="control-label col-sm-2">Type</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('type', $model->getTypes(), $model->type, array('class'=>'form-control', 'id'=>'type', 
    'required'=>'')); ?>
    <?php echo form_error('type', '<p class="error">', '</p>'); ?>
  </div>
</div>

<div class="checkpoint-meta form-group <?php echo $model->type == 'mcq' ? 'open' : ''; ?>" id="mcq">
  <div class="col-sm-offset-2 col-sm-10">
    <label>Question</label>
    <textarea name="question" class="form-control" rows="3"><?php echo isset($model->meta['question']) ? $model->meta['question'] : ''; ?></textarea>
    <br>
    <p>Add all of the available choices and select the correct one</p>
    <a href="#" class="btn btn-default" id="add-new-option">Add New Choice</a>
    <ul class="list">
      <?php if( isset($model->meta['choices']) && is_array($model->meta['choices']) ) : ?>
        <?php foreach ($model->meta['choices'] as $key => $value) : ?>
          <li>
            <div class="form-group">
              <div class="col-sm-1">
                <div class="checkbox">
                  <label>
                    <input type="radio" name="correct" required="" value="<?php echo $key; ?>"
                    <?php echo ( $key == $model->meta['correct'] ? "checked" : "" ); ?>>
                  </label>
                </div>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" required="" name="options[]" value="<?php echo $value; ?>" placeholder="Enter New Choice Here">
              </div>
              <div class="col-sm-2">
                <a href="#" class="btn btn-danger del">DELETE</a>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
    <?php echo $model->type == 'mcq' ? form_error('meta', '<p class="error">', '</p>') : ''; ?>
  </div>
</div>

<div class="checkpoint-meta form-group <?php echo $model->type == 'video' ? 'open' : ''; ?>" id="video">
  <label class="control-label col-sm-2">Video Url</label>
  <div class="col-sm-10">
    <input type="url" name="video" class="form-control" placeholder="Video Url" 
    value="<?php echo isset($model->meta['video_url']) ? $model->meta['video_url'] : ''; ?>">
    <?php echo $model->type == 'video' ? form_error('meta', '<p class="error">', '</p>') : ''; ?>
  </div>
</div>

<div class="checkpoint-meta <?php echo $model->type == 'submit' ? 'open' : ''; ?>" id="submit">
  <div class="col-sm-10 col-sm-offset-2">
    <?php echo $model->type == 'submit' ? form_error('meta', '<p class="error">', '</p>') : ''; ?>
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