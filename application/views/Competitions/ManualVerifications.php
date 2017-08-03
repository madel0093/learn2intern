<?php $this->load->view('Public/Header'); ?>
<body>
  <?php $this->load->view('Public/Nav'); ?>
  <?php $this->load->view('Competitions/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <br>
    <div class="panel panel-info">
      <div class="panel-heading">Manual Verification Submissions</div>
      <div class="panel-body">
        <?php if( empty($data) ) : ?>
          <p class="info-wrapper text-center">
            No New Submissions Yet
          </p>
        <?php else: ?>
          <table data-toggle="table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th data-field="competition" data-sortable="true">Competition</th>
                <th data-field="challenge"   data-sortable="true">Challenge</th>
                <th data-field="checkpoint"  data-sortable="true">Check Point</th>
                <th data-field="submissions" data-sortable="true">Submissions</th>
                <th data-field="actions"     data-class="wrapper"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $value) : ?>
                <tr>
                  <td><?php echo $value['competition']; ?></td>
                  <td><?php echo $value['challenge']; ?></td>
                  <td><?php echo $value['checkpoint']; ?></td>
                  <td><?php echo $value['cnt']; ?></td>
                  <td>
                    <a href="<?php echo site_url(array('checkpoints/index', $value['id'])); ?>" class="btn btn-success bold">
                      Enter
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php $this->load->view('Public/Footer'); ?>
</body>
</html>