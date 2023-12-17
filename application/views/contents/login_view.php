<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo config_item('app_name') ?> | Log in</title>
  <meta name="googlebot-news" content="noindex" />
  <meta  name="googlebot" content="noindex" />
  <meta name="robots" content="noindex" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="stylesheet" href="<?php echo base_url('assets/').'css/bootstrap.min.css'; ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/').'css/font-awesome/css/font-awesome.min.css?v=2'; ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/').'css/Ionicons/css/ionicons.min.css'; ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/').'css/AdminLTE.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/').'plugins/sweetalert/css/sweetalert.css'; ?>">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b><?php echo config_item('app_name') ?></b>CMS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Pastikan username dan password sesuai</p>

    <form id="form_data" method="post">

      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-user"></i>
          </div>
          <input type="text" id="email" name="email" class="form-control" placeholder="Username/Email/Telepon">
        </div>
      </div>

      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-lock"></i>
          </div>
          <input type="password" id="password" name="password" class="form-control" placeholder="Password">
        </div>
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4 pull-right" >
          <button type="button" class="btn btn-primary btn-block btn-flat btn_action" data-idle="Masuk" data-process="Login..." data-form="#form_data" data-action="<?php echo base_url('login'); ?>" data-redirect="<?php echo base_url(); ?>">Masuk</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/').'js/jquery.min.js';?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/').'js/bootstrap.min.js';?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/').'js/adminlte.min.js';?>"></script>
<!-- SweetAlert -->
<script src="<?php echo base_url('assets/').'plugins/sweetalert/js/sweetalert.min.js';?>"></script>
<!-- custom js general -->
<?php $this->load->view('script/general_script') ?>
<script type="text/javascript">
  $('#password').keypress(function (e) {
   var key = e.which;
   console.log(key);
   if(key == 13)
    {
      $('.btn_action').click();
      return false;
    }
  });
</script>
</body>
</html>
