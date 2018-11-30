<template>
    <div class="row" style="margin-bottom: 7px;">
        <div class="col-md-12" style="margin-bottom: 7px;">
            <div class="row" style="max-width: 700px;">
                <div class="col-md-4">
                  <button @click="initAddLevel()" class="btn btn-success">
                    <i class="fa fa-plus"></i> Level Baru
                  </button>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div align="right" style="margin-right: -18px;">
                        <input type="text" class="form-control" name="pencarian" placeholder="Pencarian" v-model="pencarian">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 7px;">
            <table class="table table-striped table-hover table-bordered" style="max-width: 700px;">
              <thead>
                <tr>
                  <th style="text-align: center;width: 70px;">No.</th>
                  <th style="text-align: center;">Deskripsi</th>
                  <th style="text-align: center;" width="120px">Kelola</th>
                </tr>
              </thead>
              <tbody v-if="items.length">
                <tr v-for="(item, no) in items">
                  <td>{{ countPage(++no) }}.</td>
                  <td>{{ item.nama_level }}</td>
                  <td style="text-align: center;">  
                    <a href="#" @click="urlLevelAccess(item.id)" data-balloon="Level User Access" data-balloon-pos="down"><i class="fas fa-user-cog"></i></a> &nbsp;  
                    <a href="#" @click.prevent="editLevel(item)" data-balloon="Update Level" data-balloon-pos="down"><i class="fa fa-edit"></i></a> &nbsp; <a href="#" @click.prevent="deleteLevel(item)" data-balloon="Hapus Level" data-balloon-pos="down"><i class="fa fa-trash"></i></a>
                  </td>
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
            <div class="modal fade" id="edit-level" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Form Update Level</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateLevel(fillItem.id)">
                             <div class="form-group">
                                <label for="nama_level">Nama Level</label>
                                <input type="text" name="nama_level" class="form-control" v-model="fillItem.nama_level">
                                <input type="hidden" name="nama_level_old" class="form-control" v-model="fillItem.nama_level_old">
                                <span v-for="error in errors" v-if="error.nama_level" class="help-block text-danger">{{ error.nama_level[0] }}</span>
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

          <div class="modal fade" id="delete-level" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Hapus Data Level</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="pdeleteLevel(fillItem.id)">
                             <div class="form-group">
                                Yakin akan menghapus level <strong>{{ fillItem.nama_level }}</strong> ?
                            </div>
                            <div class="form-group">
                                <div align="right">
                                  <button type="submit" class="btn btn-danger">Hapus</button>
                                  <button class="btn btn-default" data-dismiss="modal" @click.prevent="clearErrors()">Batal</button>  
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>

          <div class="modal fade" id="create-level" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Form Tambah Level</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createLevel">
                             <div class="form-group">
                                <label for="nama_level">Nama Level</label>
                                <input type="text" name="nama_level" class="form-control" v-model="newItem.nama_level">
                                <span v-for="error in errors" v-if="error.nama_level" class="help-block text-danger">{{ error.nama_level[0] }}</span>
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
    import vSelect from 'vue-select';
    export default {
        components: {vSelect},
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
                'nama_level': ''
            },
            fillItem: {
                'nama_level': '',
                'nama_level_old': '',
                'id': ''
            },
            loading: true,
            errors:{},
            pencarian: ''
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
            this.getVueLevel(this.pagination.current_page);
        },

        watch: {
            pencarian: function (q) {
              if (q != '') {
                this.searchLevel()  
              }
              else {
                this.getVueLevel()
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
            urlLevelAccess(id){
                window.location = '/pos/admin/access_level/'+id;
            },

            initAddLevel()
            {
                this.errors = [];
                $("#create-level").modal("show");
            },

            searchLevel(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              axios.get('/pos/admin/search_level?q='+app.pencarian+'&page='+page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            getVueLevel(page) {
                axios.get('/pos/admin/data_level?page=' + page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            createLevel() {
                var input = this.newItem;
                axios.post('/pos/admin/simpan_level', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'nama_level': ''
                    };
                    this.errors = [];
                    $("#create-level").modal('hide');
                    toastr.success('Level baru berhasil dibuat.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            deleteLevel(item) {
                this.fillItem.id = item.id;
                this.fillItem.nama_level = item.nama_level;
                $("#delete-level").modal("show");
            },


            pdeleteLevel(id) {
                var input = this.fillItem;
                axios.post('/pos/admin/destroy_level/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nama_level': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#delete-level").modal('hide');
                    toastr.success('Level berhasil dihapus.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },



            editLevel(item) {
                this.fillItem.nama_level = item.nama_level;
                this.fillItem.nama_level_old = item.nama_level;
                this.fillItem.id = item.id;
                $("#edit-level").modal("show");
            },

            updateLevel(id) {
                var input = this.fillItem;
                axios.put('/pos/admin/update_level/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nama_level': '',
                        'nama_level_old': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#edit-level").modal('hide');
                    toastr.success('Level berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            clearErrors(){
                this.errors = [];
                this.fillItem.nama_level = '';
                this.fillItem.id = '';
            },

            clearErrorsAdd(){
                this.errors = [];
                this.newItem.nama_level = '';
            },

            changePage(page) {
                this.pagination.current_page = page;
                this.searchLevel(page);
            }
        }
    }
</script>
