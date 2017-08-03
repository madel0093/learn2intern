<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Login</title>    
        <link rel="stylesheet" href="<?php echo asset_url();?>Auth/css/style.css">
        <link rel="stylesheet" href="<?php echo asset_url();?>Public/css/jquery.ambiance.css">
  </head>

  <body>
    <body>
<div class="container">
  <section id="content">
    <?php echo form_open("auth/login");?>
      <h1>Login</h1>
      <div>
        <?php 
          $identity['placeholder']='Username';
          $identity['required']='';
          echo form_input($identity);
        ?>
      </div>
      <div>
        <?php 
          $password['placeholder']='Password';
          $password['required']='';
          echo form_input($password);
        ?>
      </div>
      <div>
        <?php echo form_submit('Log in', lang('login_submit_btn'));?>
        <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
        <a href="Register">Register</a>
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
          });
        </script>
  </body>
</html>
