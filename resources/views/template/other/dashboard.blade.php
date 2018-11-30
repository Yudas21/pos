        @extends('template.layout')
        @section('content')
        <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                      <li class="breadcrumb-item active">Home</li>
                    </ol>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

              <!-- Default box -->
              <div class="card">
                <div class="card-header">
                  <!-- <h3 class="card-title">Home</h3> -->
                  <h3>Home</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                     <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-users"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Users</span>
                                <span class="info-box-number">
                                  {{ Pos::count_account() }}
                                  <small>Org</small>
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>

                          <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-id-card"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Customer</span>
                                <span class="info-box-number">
                                  {{ Pos::count_customer() }}
                                  <small>Org</small>
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>

                          <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-truck"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Supplier</span>
                                <span class="info-box-number">
                                  {{ Pos::count_supplier() }}
                                  <!-- <small></small> -->
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>

                          <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-cubes"></i></span>

                              <div class="info-box-content">
                                <span class="info-box-text">Barang</span>
                                <span class="info-box-number">
                                  {{ Pos::count_barang() }}
                                  <small>jenis</small>
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>

                     </div>
                </div>
              </div>
            </section>
          </div>
          @section('myjsfile')
            <script type="text/javascript">
              $(function () {
                 
              });
            </script>
          @endsection
        @stop
