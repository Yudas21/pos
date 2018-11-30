<template>
    <div class="row" style="margin-bottom: 7px;">
        <div class="col-md-12" style="margin-bottom: 7px;">
            <div class="row">
                <div class="col-md-4">
                  <button @click="initAddUsers()" class="btn btn-success">
                    <i class="fa fa-plus"></i> User Baru
                  </button>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div align="right">
                        <input type="text" class="form-control" name="pencarian" placeholder="Pencarian" v-model="pencarian">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 7px;">
            <table class="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center;width: 70px;">No.</th>
                  <th style="text-align: center;">Username</th>
                  <th style="text-align: center;">Nama</th>
                  <th style="text-align: center;">Level</th>
                  <th style="text-align: center;">Status</th>
                  <th style="text-align: center;">Kelola</th>
                </tr>
              </thead>
              <tbody v-if="items.length">
                <tr v-for="(item, no) in items">
                  <td>{{ countPage(++no) }}.</td>
                  <td>{{ item.username }}</td>
                  <td>{{ item.nama }}</td>
                  <td>{{ item.nama_level }}</td>
                  <td style="text-align: center;"><span v-if="item.active == 1" style="color: #48970a;font-weight: bold;">Aktif</span><span v-else style="color: #bf3724;font-weight: bold;">Tidak Aktif</span></td>
                  <td style="text-align: center;"><a href="#" @click.prevent="editUsers(item)" data-balloon="Update User" data-balloon-pos="down"><i class="fa fa-edit"></i></a> &nbsp; <a href="#" data-balloon="Ubah Password Baru" data-balloon-pos="down" @click.prevent="editPasswordUser(item)"><span class="fa fa-lock"></span></a> &nbsp; <a href="" @click.prevent="deleteUsers(item)" data-balloon="Hapus User" data-balloon-pos="down"><i class="fa fa-trash"></i></a></td>
                </tr>
              </tbody>
            </table>
            <nav>
                <ul class="pagination">
                   <li v-if="pagination.current_page > 1" class="page-item">
                    <a href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)" class="page-link"><span aria-hidden="true"><i class="fa fa-chevron-left"></i> </span></a>
                   </li>
                   <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']" class="page-item"><a href="#" @click.prevent="changePage(page)" class="page-link">{{ page }}</a>
                   </li>
                   <li v-if="pagination.current_page < pagination.last_page" class="page-item">
                     <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)" class="page-link"><span aria-hidden="true"><i class="fa fa-chevron-right"></i></span></a>
                    </li>
                </ul>
            </nav>
            <div class="modal fade" id="edit-user" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Form Update User</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateUsers(fillItem.id)">
                             <div class="form-group">
                                <label for="nama">Nama Lengkap <sup style="color: red;">*</sup></label>
                                <input type="text" name="nama" class="form-control" v-model="fillItem.nama" v-alphabet-only>
                                <span v-for="error in errors" v-if="error.nama" class="help-block text-danger">{{ error.nama[0] }}</span>
                            </div>
                            <div class="form-group">
                               <label for="tempat_lahir">Tempat Lahir</label>
                               <input type="text" name="tempat_lahir" class="form-control" v-model="fillItem.tempat_lahir">
                               <span v-for="error in errors" v-if="error.tempat_lahir" class="help-block text-danger">{{ error.tempat_lahir[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <br>
                                <date-picker v-model="fillItem.tgl_lahir" lang="en" :not-after="new Date()"></date-picker>
                                <span v-for="error in errors" v-if="error.tgl_lahir" class="help-block text-danger">{{ error.tgl_lahir[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" v-model="fillItem.alamat" class="form-control" maxlength="100" v-maxchars-address="100"></textarea>
                                Maksismal <span class="chars">100</span> karakter
                                <span v-for="error in errors" v-if="error.alamat" class="help-block text-danger">{{ error.alamat[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="no_handphone">No. Handphone</label>
                                <input type="text" name="no_handphone" v-model="fillItem.no_handphone" class="form-control" v-numeric-only>
                                <span v-for="error in errors" v-if="error.no_handphone" class="help-block text-danger">{{ error.no_handphone[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="username">Username <sup style="color: red;">*</sup></label>
                                <input type="text" name="username" class="form-control" v-model="fillItem.username">
                                <input type="hidden" name="username_old" class="form-control" v-model="fillItem.username_old">
                                <span v-for="error in errors" v-if="error.username" class="help-block text-danger">{{ error.username[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="id_level">Level <sup style="color: red;">*</sup></label>
                                <model-select :options="levels"
                                                      v-model="fillItem.id_level"
                                                      placeholder="Pilih">
                                </model-select>
                                <span v-for="error in errors" v-if="error.id_level" class="help-block text-danger">{{ error.id_level[0] }}</span>      
                            </div>
                            <div class="form-group">
                                <label for="active">Aktif <sup style="color: red;">*</sup></label>
                                <model-select :options="aktif"
                                                      v-model="fillItem.active"
                                                      placeholder="Pilih">
                                </model-select>
                                <span v-for="error in errors" v-if="error.active" class="help-block text-danger">{{ error.active[0] }}</span>      
                            </div>
                            <div class="form-group">
                                (<span style="color: red;">*</span>) Wajib diisi
                            </div>
                            <div class="form-group">
                                <div align="right">
                                  <button type="submit" class="btn btn-success">Simpan</button>
                                  <button class="btn btn-default" data-dismiss="modal" @click.prevent="clearErrors()">Batal</button>  
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>

          <div class="modal fade" id="edit-password_user" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Form Change Password User</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updatePasswordUser(fillItem.id)">
                             <div class="form-group">
                                <label for="password">Password Baru <sup style="color: red;">*</sup></label>
                                <input type="password" name="password" class="form-control" v-model="fillItem.password">
                                <span v-for="error in errors" v-if="error.password" class="help-block text-danger">{{ error.password[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="password_confirm">Konfirmasi Password Baru <sup style="color: red;">*</sup></label>
                                <input type="password" name="password_confirm" class="form-control" v-model="fillItem.password_confirm">
                                <span v-for="error in errors" v-if="error.password_confirm" class="help-block text-danger">{{ error.password_confirm[0] }}</span>
                            </div>
                            <div class="form-group">
                                (<span style="color: red;">*</span>) Wajib diisi
                            </div>
                            <div class="form-group">
                                <div align="right">
                                  <button type="submit" class="btn btn-success">Simpan</button>
                                  <button class="btn btn-default" data-dismiss="modal" @click.prevent="clearErrorsChangePassword()">Batal</button>  
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>

          <div class="modal fade" id="create-user" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Form Tambah Users</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createUsers">
                             <div class="form-group">
                                <label for="nama">Nama Lengkap <sup style="color: red;">*</sup></label>
                                <input type="text" name="nama" class="form-control" v-model="newItem.nama" v-alphabet-only>
                                <span v-for="error in errors" v-if="error.nama" class="help-block text-danger">{{ error.nama[0] }}</span>
                            </div>
                            <div class="form-group">
                               <label for="tempat_lahir">Tempat Lahir</label>
                               <input type="text" name="tempat_lahir" class="form-control" v-model="newItem.tempat_lahir">
                               <span v-for="error in errors" v-if="error.tempat_lahir" class="help-block text-danger">{{ error.tempat_lahir[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label><br>
                                <date-picker v-model="newItem.tgl_lahir" lang="en" :not-after="new Date()"></date-picker>
                                <span v-for="error in errors" v-if="error.tgl_lahir" class="help-block text-danger">{{ error.tgl_lahir[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" v-model="newItem.alamat" class="form-control" maxlength="100" v-maxchars-address="100"></textarea>
                                Maksimal <span class="chars">100</span> karakter
                                <span v-for="error in errors" v-if="error.alamat" class="help-block text-danger">{{ error.alamat[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="no_handphone">No. Handphone</label>
                                <input type="text" name="no_handphone" v-model="newItem.no_handphone" class="form-control" v-numeric-only>
                                <span v-for="error in errors" v-if="error.no_handphone" class="help-block text-danger">{{ error.no_handphone[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="username">Username <sup style="color: red;">*</sup></label>
                                <input type="text" name="username" class="form-control" v-model="newItem.username">
                                <span v-for="error in errors" v-if="error.username" class="help-block text-danger">{{ error.username[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password <sup style="color: red;">*</sup></label>
                                <input type="password" name="password" class="form-control" v-model="newItem.password">
                                <span v-for="error in errors" v-if="error.password" class="help-block text-danger">{{ error.password[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="password_confirm">Konfirmasi Password <sup style="color: red;">*</sup></label>
                                <input type="password" name="password_confirm" class="form-control" v-model="newItem.password_confirm">
                                <span v-for="error in errors" v-if="error.password_confirm" class="help-block text-danger">{{ error.password_confirm[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="id_level">Level <sup style="color: red;">*</sup></label>
                                <model-select :options="levels"
                                                      v-model="newItem.id_level"
                                                      placeholder="Pilih">
                                </model-select>
                                <span v-for="error in errors" v-if="error.id_level" class="help-block text-danger">{{ error.id_level[0] }}</span>      
                            </div>
                            <div class="form-group">
                                (<span style="color: red;">*</span>) Wajib diisi
                            </div>
                            <div class="form-group">
                                <div align="right">
                                  <button type="submit" class="btn btn-success">Simpan</button>
                                  <button class="btn btn-default" data-dismiss="modal" @click.prevent="clearErrorsAdd()">Batal</button>  
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
            

          </div>
        </div>
    </div>
</template>

<script>
    import { ModelSelect } from 'vue-search-select';
    import DatePicker from 'vue2-datepicker';
    export default {
        components: {ModelSelect, DatePicker},
        data: () => ({
            items: [],
            pagination: {
                total: 0,
                per_page: 10,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4,
            newItem: {
                'kode_branch': '',
                'nama_branch': '',
                'id_jenis': '',
                'id_parent': ''
            },
            newItem: {
                'nama': '',
                'tempat_lahir': '',
                'tgl_lahir': '',
                'alamat': '',
                'no_handphone': '',
                'username': '',
                'password': '',
                'password_confirm': '',
                'id_level': ''
            },
            fillItem: {
                'nama': '',
                'tempat_lahir': '',
                'tgl_lahir': '',
                'alamat': '',
                'no_handphone': '',
                'username': '',
                'username_old': '',
                'id_level': '',
                'password': '',
                'password_confirm': '',
                'active': '',
                'id': ''
            },
            loading: true,
            errors:{},
            pencarian: '',
            levels: [],
            aktif: [
                     {value: '1', text: 'Ya'},
                     {value: '0', text: 'Tidak'}
            ]
        }),

        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },

        mounted() {
            this.getVueUsers(this.pagination.current_page);
            this.getLevel();
        },

        watch: {
            pencarian: function (q) {
              if (q != '') {
                this.searchUsers()  
              }
              else {
                this.getVueUsers()
              }
              
            }
        },

        methods: {
            countPage(page){
              if(this.pagination.current_page == 1){
                 return page;
              } else {
                 return page + ((this.pagination.current_page - 1) * 10);
              }
              
            },
            urlExport(id){
                window.location = '/pos/admin/exporttoexcel_users';
            },

            initAddUsers()
            {
                this.errors = [];
                $("#create-user").modal("show");
            },

            searchUsers(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              axios.get('/pos/admin/search_users?q='+app.pencarian+'&page='+page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            getLevel(){
                axios.get('/pos/admin/users_level').then(response => {
                    this.levels = response.data.data
                });
            },

            getVueAllUsers() {
                axios.get('/pos/admin/data_all_user').then(response => {
                    this.cabang = response.data.data
                });
            },

            getVueUsers(page) {
                axios.get('/pos/admin/data_users?page=' + page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            createUsers() {
                var input = this.newItem;
                axios.post('/pos/admin/store_users', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'nama': '',
                        'tempat_lahir': '',
                        'tgl_lahir': '',
                        'alamat': '',
                        'no_handphone': '',
                        'username': '',
                        'password': '',
                        'password_confirm': '',
                        'id_level': ''
                    };
                    this.errors = [];
                    $("#create-user").modal('hide');
                    toastr.success('Users baru berhasil dibuat.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            deleteUsers(item) {
                if (confirm("Yakin ingin menghapus user dengan nama : "+item.nama+" ?")) {
                    axios.delete('/pos/admin/delete_users/' + item.id_user).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('Users behasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                    })
                    .catch(function (response) {
                      alert("Could not delete user");
                      return false;
                    });
                  }
            },

            editUsers(item) {
                this.fillItem.id = item.id;
                this.fillItem.nama = item.nama;
                this.fillItem.tempat_lahir = item.tempat_lahir;
                this.fillItem.tgl_lahir = item.tgl_lahir;
                this.fillItem.username = item.username;
                this.fillItem.username_old = item.username;
                this.fillItem.no_handphone = item.no_handphone;
                this.fillItem.alamat = item.alamat;
                this.fillItem.id_level = {value: item.id_level, text: item.nama_level};
                if(item.active == 1){
                  this.fillItem.active = {value: '1', text: 'Ya'};
                } else {
                  this.fillItem.active = {value: '0', text: 'Tidak'};
                }
                
                $("#edit-user").modal("show");
            },

            updateUsers(id) {
                var input = this.fillItem;
                axios.put('/pos/admin/update_users/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nama': '',
                        'tempat_lahir': '',
                        'tgl_lahir': '',
                        'alamat': '',
                        'no_handphone': '',
                        'username': '',
                        'username_old': '',
                        'id_level': '',
                        'active': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#edit-user").modal('hide');
                    toastr.success('Users berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            editPasswordUser(item) {
                this.fillItem.id = item.id;
                this.fillItem.password = '';
                this.fillItem.password_confirm = '';
                $("#edit-password_user").modal("show");
            },

            updatePasswordUser(id) {
                var input = this.fillItem;
                axios.put('/pos/admin/update_password_users/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'password': '',
                        'password_confirm': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#edit-password_user").modal('hide');
                    toastr.success('Ubah password baru berhasil', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            clearErrors(){
                this.errors = [];
                this.fillItem.nama = '';
                this.fillItem.tempat_lahir = '';
                this.fillItem.tgl_lahir = '';
                this.fillItem.alamat = '';
                this.fillItem.no_handphone = '';
                this.fillItem.username = '';
                this.fillItem.id_level = '';
                this.fillItem.active = '';
            },

            clearErrorsAdd(){
                this.errors = [];
                this.newItem.nama = '';
                this.newItem.tempat_lahir = '';
                this.newItem.tgl_lahir = '';
                this.newItem.alamat = '';
                this.newItem.no_handphone = '';
                this.newItem.username = '';
                this.newItem.password = '';
                this.newItem.password_confirm = '';
                this.newItem.id_level = '';
            },

            clearErrorsChangePassword(){
                this.errors = [];
                this.fillItem.password = '';
                this.fillItem.password_confirm = '';
            },

            changePage(page) {
                this.pagination.current_page = page;
                this.searchUsers(page);
            }
        }
    }
</script>
