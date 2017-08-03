<?php $this->load->view('Public/Header'); ?>
<body>
  <?php $this->load->view('Public/Nav'); ?>
  <?php $this->load->view('CheckPoints/Sidebar'); ?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
      </ol>
    </div>
    <br>
    <div class="panel panel-info">
      <div class="panel-heading">
        <?php echo $checkpoint->name; ?>
      </div>
      <div class="panel-body">
        <p><?php echo $checkpoint->instructions; ?></p>
        <br>
        <table class="table table-striped">
          <tbody>
            <tr>
              <td>Type</td>
              <td><?php echo $checkpoint->getTypes()[$checkpoint->type]; ?></td>
            </tr>
            <tr>
              <td>Trials</td>
              <td><?php echo $checkpoint->trials; ?></td>
            </tr>
            <?php 
            switch ($checkpoint->type) {
              case 'mcq':
              echo "<tr>";
              echo "<td class=\"wrapper\"> Question </td>";
              echo "<td>{$checkpoint->meta['question']}</td>";
              echo "</tr>";
              echo "<tr>";
              $choices = $checkpoint->meta['choices'];
              echo "<td class=\"wrapper\"> Choices </td>";
              echo "<td><ul class=\"bound-padding\">";
              foreach ($choices as $choice)
                echo "<li>{$choice}</li>";
              echo "</ul></td>";
              echo "</tr>";
              break;

              case 'video':
              echo "<tr>";
              $video_url = $checkpoint->meta['video_url'];
              echo "<td class=\"wrapper\"> Video Url </td>";
              echo "<td>{$video_url}</td>";
              echo "</tr>";
              break;
            }
            ?>
          </tbody>          
        </table>
      </div>
    </div>

    <?php if( $checkpoint->type == 'submit' ) : ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          Submissions
        </div>
        <div class="panel-body">
          <?php $submissions = $checkpoint->getSubmissions(); ?>
          <?php if( empty($submissions) ) : ?>
            <p class="info-wrapper text-center">
              No New Submissions Yet
            </p>
          <?php else : ?>
            <table data-toggle="table" data-show-refresh="true" data-show-columns="true" data-search="true" data-pagination="true">
              <thead>
                <tr>
                  <th data-field="username" data-sortable="true">Student Username</th>
                  <th data-field="file"     data-sortable="true">Submitted File</th>
                  <th data-field="actions"  data-class="wrapper"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($submissions as $submission) : ?>
                  <tr>
                    <td><?php echo $submission['username']; ?></td>
                    <td>
                      <?php $meta = unserialize($submission['meta']); ?>
                      <?php if( strpos($meta['type'], "image/") !== FALSE ) : ?>
                        <a href="#" id="open-modal" data-src="<?php echo base_url(array('uploads', $meta['name'])); ?>">
                          <?php echo $meta['name']; ?>
                        </a>
                      <?php else : ?>
                        <a href="<?php echo base_url(array('uploads', $meta['name'])); ?>">
                          <?php echo $meta['name']; ?>
                        </a>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="<?php echo site_url(array('checkpoints/accept', $checkpoint->getID(), $submission['studentId'])); ?>" class="btn btn-success bold">
                        Accept
                      </a>
                      <a href="<?php echo site_url(array('checkpoints/refuse', $checkpoint->getID(), $submission['studentId'])); ?>" class="btn btn-danger bold">
                        Refuse
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <?php $this->load->view('Public/Footer'); ?>

  <div class="modal fade" id="file-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <img src="" class="img-responsive img-center" id="img-perview">
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#open-modal").click(function(e){
        e.preventDefault();
        $("#img-perview").attr('src', $(this).attr('data-src'));
        $("#file-preview").modal('show');
      });
    });
  </script>

</body>
</html>