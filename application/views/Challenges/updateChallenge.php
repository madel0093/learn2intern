<?php $this->load->view('Public/Header'); ?>

<body>

  <?php $this->load->view('Public/Nav'); ?>

  <?php $this->load->view('Challenges/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
      </ol>
    </div>
    <h1 class="page-header">Challenges</h1>
    <div class="panel panel-default">
      <div class="panel-heading">Update Challenge</div>
      <div class="panel-body">
        <?php 
        $this->load->view('Challenges/challengeForm', array(
          'model' => $model,
          'action' => $action,
          )
        );
        ?>
      </div>
    </div>

  </div>

  <?php $this->load->view('Public/Footer'); ?>

</body>

</html>