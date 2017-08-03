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
    <br>
    <div class="panel panel-default">
      <div class="panel-heading">
        <?php echo $challenge->name; ?>
      </div>
      <div class="panel-body">
        <p><?php echo $challenge->description; ?></p>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <?php echo $challenge->name; ?> Check Points
      </div>
      <div class="panel-body">
        <?php if( $edit == true ) : ?>
          <div class="text-right">
            <a href="<?php echo base_url(); ?>index.php/checkpoints/create/<?php echo $challenge->getID(); ?>" class="btn btn-primary bold">
              Add New Check Point
            </a>
          </div>
          <br>
        <?php endif; ?>
        <table data-toggle="table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true">
          <thead>
            <tr>
              <th data-field="name"     data-sortable="true">Name</th>
              <th data-field="actions"  data-class="wrapper"></th>
            </tr>
          </thead>
          <tbody>
            <?php if( !empty($checkpoints) ) : ?>
              <?php foreach ($checkpoints as $checkpoint) : ?>
                <tr>
                  <td><?php echo $checkpoint['name']; ?></td>
                  <td>
                    <a href="<?php echo base_url().'index.php/checkpoints/index/'.$checkpoint['id']; ?>" class="btn btn-success bold">
                      View
                    </a>
                    <?php if( $edit == true ) : ?>
                      <a href="<?php echo base_url().'index.php/checkpoints/update/'.$checkpoint['id']; ?>" class="btn btn-primary bold">
                        Edit 
                      </a>
                      <a href="<?php echo base_url().'index.php/checkpoints/delete/'.$checkpoint['id']; ?>" class="btn btn-danger bold">
                        Delete
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php $this->load->view('Public/Footer'); ?>
</body>
</html>