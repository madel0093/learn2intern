<form action="" method="post">
  <?php $video = str_replace("watch?v=", "embed/", $data['video_url']); ?>
  <?php $video = $video.'?rel=0'; ?>
  <div class="video-frame">
    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="embed-responsive-item" src="<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
  <br><br>
  <?php if( $can_submit ) : ?>
    <div class="text-right">
      <input type="submit" class="btn btn-primary" name="watch-video" value="Confirm Watching The Video">
    </div>
  <?php endif; ?>
</form>