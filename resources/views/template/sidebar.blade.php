<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="background: #fff;">
      <img src="{{ asset('logo.png') }}"
           alt=""
           class="brand-image img-fluid">
      <span class="brand-text" style="color:#343a40">Aplikasi</span>
      <img src="{{ asset('icon.png') }}" height="27">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 0px solid #daddf6;">
        <div class="image">
          <?php $akses = strtolower(Pos::get_level_name(session('id_level')));?>
          <?php $du2 = Pos::get_account(session('username')); $akses = Pos::get_level_name(session('id_level')); ?>
          <img src="{{ $du2->foto == '' || $du2->foto == NULL ? url('/public/avatar.png') : url('/storage/photo/'.$du2->foto) }}" alt="Avatar" class="img-circle elevation-2" style="height: 35px !important;width: 35px !important;">
        </div>
        <div class="info">
          <a href="{{ url(strtolower($akses).'/profile') }}" class="d-block" style="color:#fff;">
             @if (session('nama')!='')    
                    {{ session('nama') }}
             @endif
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php 
                $parent = Pos::get_parent();
                $userlevel = session('id_level');
                $mymenu = array(); 
                $mymenu = Pos::get_my_menu($userlevel);
          ?>
                @foreach ($parent as $mp)
                   @if(in_array($mp->id, $mymenu))
                        <?php $nc = Pos::get_count_child($mp->id);?>
                          @if ($nc > 0)
                            <li class="nav-item has-treeview"> 
                            <a href="#" class="nav-link" style="color: #daddf6;"><i class="{{ $mp->ikon_menu }}"></i>
                            <p>{{ $mp->nama_menu }} <i class="right fa fa-angle-left"></i></p></a>
                            <ul class="nav nav-treeview">
                                <?php $child = Pos::get_child($mp->id); ?>
                                @foreach ($child as $mc)
                                  @if (in_array($mc->id, $mymenu))

                                    <?php $nd = Pos::get_count_child($mc->id); ?>
                                    @if ($nd > 0)
                                      <li class="nav-item has-treeview"> 
                                        <a href="#" class="nav-link" style="color: #daddf6;">
                                        <p>{{ $mc->nama_menu }} <i class="right fa fa-angle-left"></i></p></a>
                                        <ul class="nav nav-treeview">
                                          <?php $child2 = Pos::get_child($mc->id); ?>
                                          @foreach ($child2 as $md)
                                            @if (in_array($md->id, $mymenu))
                                              <li class="nav-item"><a href="<?php echo (($md->url_menu != '') ? ((preg_match('/'.strtolower($akses).'/i', $md->url_menu)) ? url($md->url_menu) : url(strtolower($akses).'/'.$md->url_menu) ) : ((preg_match('/'.strtolower($akses).'/i', $md->url_menu)) ? $md->url_menu : strtolower($akses).'/'.$md->url_menu ));?>" class="nav-link" style="color: #daddf6;">&nbsp;&nbsp; {{ $md->nama_menu }}</a></li>
                                            @endif      
                                          @endforeach
                                        </ul>
                                      </li>
                                    @else
                                      <li class="nav-item"><a href="<?php echo (($mc->url_menu != '') ? ((preg_match('/'.strtolower($akses).'/i', $mc->url_menu)) ? url($mc->url_menu) : url(strtolower($akses).'/'.$mc->url_menu) ) : ((preg_match('/'.strtolower($akses).'/i', $mc->url_menu)) ? $mc->url_menu : strtolower($akses).'/'.$mc->url_menu )) ;?>" class="nav-link" style="color: #daddf6;">{{ $mc->nama_menu }}</a></li>
                                    @endif

                                  @endif
                                @endforeach
                            </ul>
                          @else
                            <li class="nav-item"> <a href="<?php echo (($mp->url_menu != '') ? ((preg_match('/'.strtolower($akses).'/i', $mp->url_menu)) ? url($mp->url_menu) : url(strtolower($akses).'/'.$mp->url_menu) ) : ((preg_match('/'.strtolower($akses).'/i', $mp->url_menu)) ? $mp->url_menu : strtolower($akses).'/'.$mp->url_menu )) ;?>" class="nav-link" style="color: #daddf6;"><i class="{{ $mp->ikon_menu }}"></i> <p>{{ $mp->nama_menu }}</p></a></li>
                          @endif
                   @endif
                @endforeach

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>