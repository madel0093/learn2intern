<?php $this->load->view('Public/Header'); ?>
<link href="<?php echo asset_url();?>Public/css/timeline.css" rel="stylesheet">

<body>
  <?php $this->load->view('Public/Nav'); ?>
  <?php $this->load->view('Students/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <br>
    <div class="panel panel-info block">
      <div class="panel-heading">
        <?php echo $competition->name; ?>
      </div>
      <div class="panel-body">
        <p><?php echo $competition->description; ?></p>
        <?php if( !$registered && $competition->registration_open ) : ?>
          <br>
          <div class="text-right">
            <a href="<?php echo site_url(array('students/registercompetition', $competition->getID())); ?>" class="btn btn-primary">Register</a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if( $registered && !empty($challenges) ) : ?>
      <div class="panel panel-default block">
        <div class="panel-heading">Challenges</div>
        <div class="panel-body">
          <ul class="timeline">
            <?php foreach ($challenges as $key => $challenge) : ?>
              <li class="<?php echo ($key%2 == 1 ? 'timeline-inverted' : ''); ?>">
                <?php 
                $status = $challenge->getStudentStatus( $user_id ); 
                $class = 'info'; $icon = 'glyphicon-question-sign';
                switch ($status) {
                  case 'full':
                  $class = 'success';
                  $icon  = 'glyphicon-ok-sign';
                  break;
                }
                ?>
                <div class="timeline-badge <?php echo $class; ?>">
                  <i class="glyphicon <?php echo $icon; ?>"></i>
                </div>
                <div class="timeline-panel">
                  <div class="timeline-heading">
                    <a class="inherit" href="<?php echo site_url(array('students/challenge', $challenge->getID())); ?>">
                      <h4 class="timeline-title"><?php echo $challenge->name; ?></h4>
                    </a>
                  </div>
                  <div class="timeline-body">
                    <p><?php echo substr($challenge->description,0,150)." ..."; ?></p>
                    <hr>
                    <p>
                      Score: <?php echo $challenge->getStudentScore($user_id); ?> / 
                      <?php echo $challenge->getTotalScore(); ?> 
                    </p>
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