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
                      <div class="col-md-6">
                        <!-- USERS LIST -->
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Karyawan yang berulang tahun hari ini</h3>

                            <div class="card-tools">
                              <span class="badge badge-danger">4 Karyawan</span>
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
                      <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Barang Per Kategori</h3>

                                    <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                                    </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                         
                                    </div>
                                </div>
                      </div>

                    </div>


                </div>
              </div>
            </section>
          </div>
          @section('myjsfile')
          
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
          <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>

          @endsection
        @stop
