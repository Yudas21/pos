<template>
    <div class="row" style="margin-bottom: 7px;">
        <div class="row col-md-12" style="max-width: 70%;">
            <div class="col-md-4">
                <button @click="initAddMenu()" class="btn btn-success">
                    <i class="fa fa-plus"></i> Menu Baru
                </button>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div style="float: right;margin-right: -19px">
                   <input type="text" class="form-control" name="pencarian" placeholder="Pencarian" v-model="pencarian">
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 7px;">
            <table class="table table-striped table-hover table-bordered" style="max-width: 70%;">
                <thead>
                    <tr>
                       <th style="text-align: center;width: 70px;">No.</th>
                       <th style="text-align: center;">Nama Menu</th>
                       <th style="text-align: center;">Parent</th>
                       <th style="text-align: center;">Url</th>
                       <th style="text-align: center;" width="80px">Kelola</th>
                    </tr>
                </thead>
                <tbody v-if="items.length">
                    <tr v-for="(item, no) in items">
                      <td>{{ countPage(++no) }}.</td>
                      <td>{{ item.nama_menu }}</td>
                      <td><span v-if="item.parent_menu == 0">as Parent</span><span v-else>{{ item.menu_parent.nama_menu }}</span></td>
                      <td>{{ item.url_menu }}</td>
                      <td style="text-align: center;">  
                        <a href="#" @click.prevent="editMenu(item)" data-balloon="Update Menu" data-balloon-pos="down"><i class="fa fa-edit"></i></a>
                        <a href="#" @click.prevent="deleteMenu(item)" data-balloon="Hapus Menu" data-balloon-pos="down"><i class="fa fa-trash"></i></a>
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

            <div class="modal fade" id="edit-menu" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h4 class="modal-title">Form Update Menu</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateMenu(fillItem.id)">
                            <input name="_method" type="hidden" value="PUT"> 
                            <div class="form-group">
                              <label for="nama_menu">Nama Menu</label>
                              <input type="text" name="nama_menu" class="form-control" v-model="fillItem.nama_menu">
                              <span v-for="error in errors" v-if="error.nama_menu" class="help-block text-danger">{{ error.nama_menu[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="url_menu">URL</label>
                              <input type="text" name="url_menu" class="form-control" v-model="fillItem.url_menu">
                              <span v-for="error in errors" v-if="error.url_menu" class="help-block text-danger">{{ error.url_menu[0] }}</span>
                            </div>
                            <div class="form-group">
                             <label for="parent_menu">Parent</label>
                             <model-select :options="parents"
                                                      v-model="fillItem.parent_menu"
                                                      placeholder="Pilih">
                             </model-select>
                             <span v-for="error in errors" v-if="error.parent_menu" class="help-block text-danger">{{ error.parent_menu[0] }}</span>
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
           </div>

           <div class="modal fade" id="create-menu" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h4 class="modal-title">Form Tambah Menu</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createMenu()"> 
                            <div class="form-group">
                              <label for="nama_menu">Nama Menu</label>
                              <input type="text" name="nama_menu" class="form-control" v-model="newItem.nama_menu">
                              <span v-for="error in errors" v-if="error.nama_menu" class="help-block text-danger">{{ error.nama_menu[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="url_menu">URL</label>
                              <input type="text" name="url_menu" class="form-control" v-model="newItem.url_menu">
                              <span v-for="error in errors" v-if="error.url_menu" class="help-block text-danger">{{ error.url_menu[0] }}</span>
                            </div>
                            <div class="form-group">
                             <label for="parent_menu">Parent</label>
                             <model-select :options="parents"
                                                      v-model="newItem.parent_menu"
                                                      placeholder="Pilih">
                             </model-select>
                             <span v-for="error in errors" v-if="error.parent_menu" class="help-block text-danger">{{ error.parent_menu[0] }}</span>
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
    </div>
</template>

<script>
    import { ModelSelect } from 'vue-search-select';
    export default {
        components: {ModelSelect},
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
                'nama_menu': '',
                'url_menu': '',
                'parent_menu': ''
            },
            fillItem: {
                'nama_menu': '',
                'url_menu': '',
                'parent_menu': '',
                'id': ''
            },
            loading: true,
            errors:{},
            parents: [],
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
            this.getVueMenu(this.pagination.current_page);
            this.getVueParentMenu();
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
              if (q != '') {
                this.searchMenu()  
              }
              else {
                this.getVueMenu()
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
            initAddMenu()
            {
                this.errors = [];
                $("#create-menu").modal("show");
            },

            searchMenu(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              axios.get('/pos/admin/search_menu?q='+app.pencarian+'&page='+page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            getVueParentMenu() {
                axios.get('/pos/admin/data_menu_parent').then(response => {
                    this.parents = response.data.data
                });
            },

            getVueMenu(page) {
                axios.get('/pos/admin/data_menu?page=' + page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            createMenu() {
                var input = this.newItem;
                axios.post('/pos/admin/simpan_menu', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'nama_menu': '',
                        'url_menu': '',
                        'parent_menu': ''
                    };
                    this.errors = [];
                    $("#create-menu").modal('hide');
                    toastr.success('Menu berhasil dibuat.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            deleteMenu(item) {
                if (confirm("Yakin ingin menghapus menu : "+item.nama_menu+" ?")) {
                    axios.delete('/pos/admin/destroy_menu/' + item.id).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('Menu behasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                    })
                    .catch(function (response) {
                      alert("Could not delete money quality");
                      return false;
                    });
                  }
            },

            editMenu(item) {
                this.fillItem.nama_menu = item.nama_menu;
                this.fillItem.url_menu = item.url_menu;
                if(item.parent_menu == 0){
                  this.fillItem.parent_menu = {value: '0', text: 'as Parent'};
                } else {
                  this.fillItem.parent_menu = {value: item.parent_menu, text: item.menu_parent.nama_menu};
                }
                this.fillItem.id = item.id;
                $("#edit-menu").modal("show");
            },

            updateMenu(id) {
                var input = this.fillItem;
                axios.put('/pos/admin/update_menu/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nama_menu': '',
                        'url_menu': '',
                        'parent_menu': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#edit-menu").modal('hide');
                    toastr.success('Menu berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            clearErrors(){
                this.errors = [];
                this.fillItem.nama_menu = '';
                this.fillItem.url_menu = '';
                this.fillItem.parent_menu = '';
            },

            clearErrorsAdd(){
                this.errors = [];
                this.newItem.nama_menu = '';
                this.newItem.url_menu = '';
                this.newItem.parent_menu = '';
            },

            changePage(page) {
                this.pagination.current_page = page;
                this.searchMenu(page);
            }
        }
    }
</script>
