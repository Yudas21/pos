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

                    <div class="row">
                      <div class="col-md-6">
                        <!-- USERS LIST -->
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Karyawan yang hari ini berulang tahun</h3>

                            <div class="card-tools">
                              <span class="badge badge-danger">8 Karyawan</span>
                              <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body p-0">
                            <ul class="users-list clearfix">
                              <li>
                                <img src="{{ asset('template/dist/img/user1-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Alexander Pierce</a>
                                <span class="users-list-date">32 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user8-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Norman</a>
                                <span class="users-list-date">29 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user7-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Jane</a>
                                <span class="users-list-date">26 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user6-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">John</a>
                                <span class="users-list-date">42 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Alexander</a>
                                <span class="users-list-date">38 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user5-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Sarah</a>
                                <span class="users-list-date">27 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user4-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Nora</a>
                                <span class="users-list-date">17 th</span>
                              </li>
                              <li>
                                <img src="{{ asset('template/dist/img/user3-128x128.jpg') }}" alt="User Image" style="height:87px !important;">
                                <a class="users-list-name" href="#">Nadia</a>
                                <span class="users-list-date">19 th</span>
                              </li>
                            </ul>
                            <!-- /.users-list -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer text-center">
                            <a href="javascript::">Lihat Semua</a>
                          </div>
                          <!-- /.card-footer -->
                        </div>
                        <!--/.card -->
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
