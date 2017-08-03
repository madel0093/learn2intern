<?php
$this->load->view('Public/Header');
?>

<body>
		

        <script type="text/javascript">
          $( document ).ready(function() {
					$("#change_password_submit").click(function(){
					  $.ajax({
					    type: 'POST', 
					    url: '<?php echo base_url()."auth/change_password"; ?> ', 
					    data: $('#change_password_form').serialize(),
					    success: function (ErrorMessage) {    
					    	$.ambiance({message: ErrorMessage});
					    },
					    beforeSend:function(){
					    }
					  });
					  return false;
					});
          });

        </script>
<?php
$this->load->view('Public/Nav');
$this->load->view('Students/Sidebar');

/* required php ini */


			$old_password = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
				'class'=> 'form-control',
				'required' =>'',
			);
			$new_password = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'class'=> 'form-control',
				'required' =>'',
			);
			$new_password_confirm = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'class'=> 'form-control',
				'required' =>'',
			);

/* end of form ini */



?>
		

		
	<div class="col-sm-12 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<br />
		<div class="row col-lg-12">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">Login Information<a href="#" data-toggle="collapse" data-target="#Login_Information" class="pull-right"><svg class="glyph stroked chevron up"><use xlink:href="#stroked-chevron-up"/></svg></a></div>
					<div class="panel-body">
						<div id="Login_Information">
                                          <?php 
                                                $attributes = array('id' => 'change_password_form');
                                                echo form_open("auth/change_password",$attributes);
                                          ?>
                                          
                                                <div class="form-group">
                                                      <label>Old password</label>
                                                      <?php echo form_input($old_password);?>
                                                </div>
                                                                                                
                                                <div class="form-group">
                                                      <label>New Password (at least 8 characters long):</label>
                                                      <?php echo form_input($new_password);?>
                                                </div>
                                                
                                                <div class="form-group">
                                                      <label>Confirm New Password:</label>
                                                      <?php echo form_input($new_password_confirm);?>
                                                </div>                                            
                                                <div class="form-group">
                                                <button id="change_password_submit" type="button submit" class="btn btn-success pull-right">Submit</butto>
                                                </div>
                                          </div>
                                    <?php echo form_close();?>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->			
	</div>	<!--/.main-->

<?php
$this->load->view('Public/Footer');
?>

</body>

</html>
