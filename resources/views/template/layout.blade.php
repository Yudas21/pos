<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Poin of Sale</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('bri.png') }}">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="{{ asset('template/plugins/font-awesome/css/font-awesome.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"> 
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <!-- Theme style -->
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('template/plugins/datatables/dataTables.bootstrap4.css') }}"> -->

  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/ballon.css') }}">

  <!-- <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/froala_editor.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/froala_style.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/code_view.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/draggable.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/colors.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/emoticons.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/image_manager.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/image.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/line_breaker.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/table.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/char_counter.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/video.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/fullscreen.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/file.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/quick_insert.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/help.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/third_party/spell_checker.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/froala_editor/css/plugins/special_characters.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css"> -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
              th {
                  position: relative;
                  min-height: 41px;
              }
              th span {
                  display: block;
                  position: absolute;
                  left: 0;
                  right: 0;
                  white-space: nowrap;
                  text-overflow: ellipsis;
                  overflow: hidden;
              }
              .fade.in {
                opacity: 1;
              }

              .modal.in .modal-dialog {
                -webkit-transform: translate(0, 0);
                -ms-transform: translate(0, 0);
                -o-transform: translate(0, 0);
                transform: translate(0, 0);
                z-index: 999;
              }

              .modal-backdrop.in {
                opacity: 0.5;
              }
            </style>
              
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include('template.header')
    @include('template.sidebar')
        @yield('content')
    @include('template.footer')
    <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<!-- <script src="{{ asset('template/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/dataTables.bootstrap4.js') }}"></script> -->
<!-- SlimScroll -->
<script src="{{ asset('template/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('template/plugins/fastclick/fastclick.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="{{ asset('template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script> -->
<!-- Select2 -->
<script src="{{ asset('template/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- <script src="{{ asset('js/vendor/typeahead.js') }}"></script>
 --><!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template/dist/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/toastr.min.js') }}"></script>
<!-- ChartJS 1.0.2 -->
<script src="{{ asset('template/plugins/chartjs-old/Chart.min.js') }}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{ asset('template/dist/js/pages/dashboard2.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/vendor/vue.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/vue-resource.min.js') }}"></script> -->
@yield('myjsfile')
<script>
  $(function () {
    // $('.bulan').datepicker({
    //     format: 'yyyy-mm',
    //     todayHighlight: true,
    //     autoclose: true,
    //     starView: 'months',
    //     minViewMode: 'months'
    // });
    // $('.datepicker').datepicker({
    //     format: 'yyyy-mm-dd',
    //     todayHighlight: true,
    //     autoclose: true
    // });
    // $('.tgl_lahir').datepicker({
    //     format: 'yyyy-mm-dd',
    //     todayHighlight: true,
    //     autoclose: true,
    //     endDate: new Date()

    // });
  });
  
  function numberOnly(e) {
      var charCode = (e.which) ? e.which : e.keyCode;

      if (!((charCode >= 48 && charCode <= 57) || charCode == 8 || charCode == 9))
        return false;
  }
</script>
</body>
</html>