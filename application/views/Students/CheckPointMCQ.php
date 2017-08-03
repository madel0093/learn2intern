<form action="" method="post">
  <div class="form-group">
    <p><?php echo $data['question']; ?></p>
  </div>
  <?php foreach ($data['choices'] as $key => $value) : ?>
    <div class="radio">
      <label>
        <input type="radio" name="answer" value="<?php echo $key; ?>"> <?php echo $value; ?>
      </label>
    </div>
  <?php endforeach; ?>
  <br>
  <?php if( $can_submit ) : ?>
    <input type="submit" name="answer-mcq" class="btn btn-primary" value="Submit">
  <?php else: ?>
    <p class="error-wrapper text-center">You Can't Answer Anymore</p>
  <?php endif; ?>
</form>
