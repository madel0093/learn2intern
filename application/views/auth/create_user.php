<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Register</title>    
        <link rel="stylesheet" href="<?php echo asset_url();?>Auth/css/style.css">
        <link rel="stylesheet" href="<?php echo asset_url();?>Public/css/jquery.ambiance.css">
  </head>

  <body>
    <body>
<div class="container">
  <section id="content">
    <?php echo form_open("auth/Register");?>
      <h1>Register</h1>
      <div>
      <?php
      if($identity_column!=='email') {
          $identity['placeholder']='Username';
          $identity['required']='';
          echo form_error('identity');
          echo form_input($identity);
      }
      ?>
      </div>
      <div>
        <?php 
          $email['placeholder']='email';
          $email['required']='';
          echo form_input($email);
        ?>
      </div>
      <div>
        <?php 
          $password['placeholder']='password';
          $password['required']='';
          echo form_input($password);
        ?>
      </div>
      <div>
        <?php 
          $password_confirm['placeholder']='password_confirm';
          $password_confirm['required']='';
          echo form_input($password_confirm);
        ?>
      </div>
      <div>
        <?php 
          $first_name['placeholder']='first_name';
          $first_name['required']='';
          echo form_input($first_name);
        ?>
      </div>
      <div>
        <?php 
          $last_name['placeholder']='last_name';
          $last_name['required']='';
          echo form_input($last_name);
        ?>
      </div>
      <div>
          <select id='countries' Name='country'>
            <?php foreach($Countries  as $r): ?>
                <option value="<?php echo $r->id; ?>"><?php echo $r->Name; ?></option>
            <?php endforeach; ?>
          </select>      
      </div>
      <div>
          <select id='cities' Name='city'>

          </select>      

      </div>
      <div>
          <select id='universities' Name='city'>

          </select>      

      </div>
      <div>
          <select id='faculties' Name='city'>

          </select>      

      </div>
      <div>
        <?php echo form_submit('Register', 'Register');?>
        <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
        <a href="login">Login</a>
      </div>
    <?php echo form_close();?><!-- form -->
  </section><!-- content -->
</div><!-- container -->
</body>
        <script src="<?php echo asset_url();?>Auth/js/jquery-3.1.0.js"></script>  
        <script src="<?php echo asset_url();?>Auth/js/index.js"></script>   
        <script src="<?php echo asset_url();?>Public/js/jquery.ambiance.js"></script>  
        <script type="text/javascript">
          $( document ).ready(function() {
            var ErrorMessage = "<?php echo trim(preg_replace('/\s+/', ' ', strip_tags($message)));?>";
            if(ErrorMessage!='')
            {
              $.ambiance({message: ErrorMessage});
            }
            $('#countries').on('change', function() {
              LoadCities();
            });
            $('#cities').on('change', function() {
              LoadUniversities();
            });
            function LoadUniversities() {
              $("#universities").load("<?php echo base_url();?>index.php/Auth/ViewUniversities/"+$('#cities').val());
            }
            function LoadCities() {
              $("#cities").load("<?php echo base_url();?>index.php/Auth/ViewCities/"+$('#countries').val());
            }
            LoadCities();
          });
        </script>
  </body>
</html>
