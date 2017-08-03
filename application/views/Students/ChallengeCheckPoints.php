<?php $this->load->view('Public/Header'); ?>
<link href="<?php echo asset_url();?>Public/css/timeline.css" rel="stylesheet">

<body>
  <?php $this->load->view('Public/Nav'); ?>
  <?php $this->load->view('Students/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <br>
    <div class="panel panel-info block">
      <div class="panel-heading">
        <?php echo $challenge->name; ?>
      </div>
      <div class="panel-body">
        <p><?php echo $challenge->description; ?></p>
        <br>
        <div>
          <a href="<?php echo site_url(array('students/competition',$challenge->getCompetitionID())); ?>" class="btn btn-primary bold">
            <span class="glyphicon glyphicon-chevron-left f9"></span> &nbsp; Back To The Competition
          </a>
        </div>
      </div>
    </div>

    <?php if( $registered && !empty($checkpoints) ) : ?>
      <div class="panel panel-default block">
        <div class="panel-heading">Check Points</div>
        <div class="panel-body">
          <ul class="timeline">
            <?php foreach ($checkpoints as $key => $checkpoint) : ?>
              <li class="<?php echo ($key%2 == 1 ? 'timeline-inverted' : ''); ?>">
                <?php 
                $status = $checkpoint->getStudentStatus( $user_id );
                $class = 'info'; $icon = 'glyphicon-question-sign';
                switch ($status) {
                  case 'correct':
                  $class = 'success';
                  $icon  = 'glyphicon-ok-sign';
                  break;

                  case 'wrong':
                  $class = 'danger';
                  $icon  = 'glyphicon-remove-sign';
                  break;

                  case 'wait':
                  $class = 'warning';
                  $icon  = 'glyphicon-info-sign';
                  break;
                }
                ?>
                <div class="timeline-badge <?php echo $class; ?>">
                  <i class="glyphicon <?php echo $icon; ?>"></i>
                </div>
                <div class="timeline-panel">
                  <div class="timeline-heading">
                    <a class="inherit" href="<?php echo site_url(array('students/checkpoint', $checkpoint->getID())); ?>">
                      <h4 class="timeline-title"><?php echo $checkpoint->name; ?></h4>
                    </a>
                  </div>
                  <div class="timeline-body">
                    <p><?php echo substr($checkpoint->instructions,0,150)." ..."; ?></p>
                    <hr>
                    <div class="row">
                      <div class="col-sm-6">
                        <p class="nomar">
                          Score: <?php echo $checkpoint->getStudentScore($user_id); ?> / 
                          <?php echo $checkpoint->getTotalScore(); ?> 
                        </p>
                      </div>
                      <div class="col-sm-6 text-right text-left-sm">
                        <p class="nomar">
                          Trials: <?php echo $checkpoint->getStudentTrials($user_id); ?> / 
                          <?php echo $checkpoint->getTotalTrials(); ?> 
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <?php $this->load->view('Public/Footer'); ?>
</body>
</html>