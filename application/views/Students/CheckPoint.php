<?php $this->load->view('Public/Header'); ?>
<body>
  <?php $this->load->view('Public/Nav'); ?>
  <?php $this->load->view('Students/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <br>
    <div class="panel panel-info block">
      <div class="panel-heading">
        <?php echo $checkpoint->name; ?>
      </div>
      <div class="panel-body">
        <?php if( !empty($checkpoint->instructions) ) : ?>
          <p><?php echo $checkpoint->instructions; ?></p>
          <br><br>
        <?php endif; ?>
        <?php
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
          echo $checkpoint->getSubmissionMessage();
        }
        if( $checkpoint->showForm() ) {
          switch ($checkpoint->type) {
            case 'mcq':
            $this->load->view('Students/CheckPointMCQ', array('data' => $checkpoint->meta, 'submit' => $can_submit));
            break;

            case 'video':
            $this->load->view('Students/CheckPointVIDEO', array('data' => $checkpoint->meta, 'submit' => $can_submit));
            break;

            case 'submit':
            $this->load->view('Students/CheckPointSUBMIT', array('submit' => $can_submit));
            break;
          }
        }
        ?>
      </div>
    </div>
    <div>
      <a class="btn btn-primary bold" href="<?php echo site_url(array('students/challenge',$checkpoint->getChallengeID())); ?>">
        <span class="glyphicon glyphicon-chevron-left f9"></span> &nbsp; Back To The Challenge
      </a>
    </div>
    <br>
  </div>
  <?php $this->load->view('Public/Footer'); ?>
</body>
</html>