<template>
    <div class="row" style="margin-bottom: 7px;">
        <div class="row col-md-12" style="max-width: 70%;">
            <div class="col-md-4">
                <button @click="initAddSupplier()" class="btn btn-success">
                    <i class="fa fa-plus"></i> Supplier Baru
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
                       <th style="text-align: center;">Nama Supplier</th>
                       <th style="text-align: center;">Alamat</th>
                       <th style="text-align: center;">Kontak</th>
                       <th style="text-align: center;" width="80px">Kelola</th>
                    </tr>
                </thead>
                <tbody v-if="items.length">
                    <tr v-for="(item, no) in items">
                      <td>{{ countPage(++no) }}.</td>
                      <td>{{ item.nama_supplier }}</td>
                      <td>{{ item.alamat_supplier }}</span></td>
                      <td>{{ item.kontak_supplier }}</td>
                      <td style="text-align: center;">  
                        <a href="#" @click.prevent="editSupplier(item)" data-balloon="Update Supplier" data-balloon-pos="down"><i class="fa fa-edit"></i></a>
                        <a href="#" @click.prevent="deleteSupplier(item)" data-balloon="Hapus Supplier" data-balloon-pos="down"><i class="fa fa-trash"></i></a>
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

            <div class="modal fade" id="edit-supplier" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h4 class="modal-title">Form Update Supplier</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateSupplier(fillItem.id)">
                            <input name="_method" type="hidden" value="PUT"> 
                            <div class="form-group">
                              <label for="nama_supplier">Nama Supplier</label>
                              <input type="text" name="nama_supplier" class="form-control" v-model="fillItem.nama_supplier">
                              <input type="hidden" name="nama_supplier_old" class="form-control" v-model="fillItem.nama_supplier_old">
                              <span v-for="error in errors" v-if="error.nama_supplier" class="help-block text-danger">{{ error.nama_supplier[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="alamat_supplier">Alamat</label>
                              <textarea name="alamat_supplier" class="form-control" v-model="fillItem.alamat_supplier"></textarea>
                              <span v-for="error in errors" v-if="error.alamat_supplier" class="help-block text-danger">{{ error.alamat_supplier[0] }}</span>
                            </div>
                            <div class="form-group">
                             <label for="kontak_supplier">No. Kontak</label>
                             <input type="text" name="kontak_supplier" class="form-control" v-model="fillItem.kontak_supplier">
                             <span v-for="error in errors" v-if="error.kontak_supplier" class="help-block text-danger">{{ error.kontak_supplier[0] }}</span>
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

           <div class="modal fade" id="create-supplier" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h4 class="modal-title">Form Tambah Supplier</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createSupplier()"> 
                            <div class="form-group">
                              <label for="nama_supplier">Nama Supplier</label>
                              <input type="text" name="nama_supplier" class="form-control" v-model="newItem.nama_supplier">
                              <span v-for="error in errors" v-if="error.nama_supplier" class="help-block text-danger">{{ error.nama_supplier[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="alamat_supplier">Alamat</label>
                              <textarea name="alamat_supplier" class="form-control" v-model="newItem.alamat_supplier"></textarea>
                              <span v-for="error in errors" v-if="error.alamat_supplier" class="help-block text-danger">{{ error.alamat_supplier[0] }}</span>
                            </div>
                            <div class="form-group">
                             <label for="kontak_supplier">No. Kontak</label>
                             <input type="text" name="kontak_supplier" class="form-control" v-model="newItem.kontak_supplier">
                             <span v-for="error in errors" v-if="error.kontak_supplier" class="help-block text-danger">{{ error.kontak_supplier[0] }}</span>
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
    export default {
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
                'nama_supplier': '',
                'alamat_supplier': '',
                'kontak_supplier': ''
            },
            fillItem: {
                'nama_supplier': '',
                'nama_supplier_old': '',
                'alamat_supplier': '',
                'kontak_supplier': '',
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
            this.getVueSupplier(this.pagination.current_page);
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
              if (q != '') {
                this.searchSupplier()  
              }
              else {
                this.getVueSupplier()
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
            initAddSupplier()
            {
                this.errors = [];
                $("#create-supplier").modal("show");
            },

            searchSupplier(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              axios.get('/pos/gudang/search_supplier?q='+app.pencarian+'&page='+page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            getVueSupplier(page) {
                axios.get('/pos/gudang/data_supplier?page=' + page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            createSupplier() {
                var input = this.newItem;
                axios.post('/pos/gudang/simpan_supplier', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'nama_supplier': '',
                        'alamat_supplier': '',
                        'kontak_supplier': ''
                    };
                    this.errors = [];
                    $("#create-supplier").modal('hide');
                    toastr.success('Supplier berhasil dibuat.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            deleteSupplier(item) {
                if (confirm("Yakin ingin menghapus supplier : "+item.nama_supplier+" ?")) {
                    axios.delete('/pos/gudang/destroy_supplier/' + item.id).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('Supplier behasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                    })
                    .catch(function (response) {
                      alert("Could not delete money quality");
                      return false;
                    });
                  }
            },

            editSupplier(item) {
                this.fillItem.nama_supplier = item.nama_supplier;
                this.fillItem.nama_supplier_old = item.nama_supplier;
                this.fillItem.alamat_supplier = item.alamat_supplier;
                this.fillItem.kontak_supplier = item.kontak_supplier;
                this.fillItem.id = item.id;
                $("#edit-supplier").modal("show");
            },

            updateSupplier(id) {
                var input = this.fillItem;
                axios.put('/pos/gudang/update_supplier/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nama_supplier': '',
                        'nama_supplier_old': '',
                        'alamat_supplier': '',
                        'kontak_supplier': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#edit-supplier").modal('hide');
                    toastr.success('Supplier berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            clearErrors(){
                this.errors = [];
                this.fillItem.nama_supplier = '';
                this.fillItem.nama_supplier_old = '';
                this.fillItem.kontak_supplier = '';
                this.fillItem.alamat_supplier = '';
            },

            clearErrorsAdd(){
                this.errors = [];
                this.newItem.nama_supplier = '';
                this.newItem.alamat_supplier = '';
                this.newItem.kontak_supplier = '';
            },

            changePage(page) {
                this.pagination.current_page = page;
                this.searchSupplier(page);
            }
        }
    }
</script>
