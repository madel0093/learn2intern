<form action="" method="post" enctype="multipart/form-data">
  <?php if( $can_submit ) : ?>
    <div class="form-group">
      <label for="file">Select Your File</label>
      <input type="file" name="file">
      <p class="help-block">Only images, pdf or zip files are allowed (maximum size 20 MB)</p>
    </div>
    <br>
    <input type="submit" name="file-upload" class="btn btn-primary" value="Upload">
  <?php else: ?>
    <p class="error-wrapper text-center">You Can't Submit Anymore</p>
  <?php endif; ?>
</form>