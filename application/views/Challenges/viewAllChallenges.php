<?php $this->load->view('Public/Header'); ?>
<body>
  <?php $this->load->view('Public/Nav'); ?>
  <?php $this->load->view('Competitions/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
      </ol>
    </div>
    <h1 class="page-header"><?php echo $competition->name; ?> Challenges</h1>
    <div class="text-right">
      <a href="<?php echo base_url(); ?>index.php/challenges/create/<?php echo $competition->getID(); ?>" class="btn btn-primary bold">
        Add New Challenge
      </a>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <table data-toggle="table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true">
              <thead>
                <tr>
                  <th data-field="name"       data-sortable="true">Name</th>
                  <th data-field="actions"    data-class="wrapper"> Actions </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($challenges as $key => $challenge) : ?>
                  <tr>
                    <td><?php echo $challenge['name']; ?></td>
                    <td>
                      <a href="<?php echo base_url().'index.php/challenges/index/'.$challenge['id']; ?>" class="btn btn-success bold">
                        View
                      </a>
                      <a href="<?php echo base_url().'index.php/challenges/update/'.$challenge['id']; ?>" class="btn btn-primary bold">
                        Edit 
                      </a>
                      <a href="<?php echo base_url().'index.php/challenges/delete/'.$challenge['id']; ?>" class="btn btn-danger bold">
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('Public/Footer'); ?>
</body>
</html>