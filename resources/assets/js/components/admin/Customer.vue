<template>
    <div class="row" style="margin-bottom: 7px;">
        <div class="row col-md-12" style="max-width: 70%;">
            <div class="col-md-4">
                <button @click="initAddCustomer()" class="btn btn-success">
                    <i class="fa fa-plus"></i> Customer Baru
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
                       <th style="text-align: center;">Nomor Kartu</th>
                       <th style="text-align: center;">Nama</th>
                       <th style="text-align: center;">Tanggal Lahir</th>
                       <th style="text-align: center;">Kontak</th>
                       <th style="text-align: center;" width="80px">Kelola</th>
                    </tr>
                </thead>
                <tbody v-if="items.length">
                    <tr v-for="(item, no) in items">
                      <td>{{ countPage(++no) }}.</td>
                      <td>{{ item.nomor_kartu }}</td>
                      <td>{{ item.nama_customer }}</td>
                      <td>{{ item.tgl_lahir_customer }}</span></td>
                      <td>{{ item.kontak_customer }}</td>
                      <td style="text-align: center;">  
                        <a href="#" @click.prevent="editCustomer(item)" data-balloon="Update Customer" data-balloon-pos="down"><i class="fa fa-edit"></i></a>
                        <a href="#" @click.prevent="deleteCustomer(item)" data-balloon="Hapus Customer" data-balloon-pos="down"><i class="fa fa-trash"></i></a>
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

            <div class="modal fade" id="edit-customer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h4 class="modal-title">Form Update Customer</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateCustomer(fillItem.id)">
                            <input name="_method" type="hidden" value="PUT"> 
                            <div class="form-group">
                              <label for="nama_customer">Nomor Kartu</label>
                              <input type="text" name="nomor_kartu" class="form-control" v-model="fillItem.nomor_kartu">
                              <input type="hidden" name="nomor_kartu_old" class="form-control" v-model="fillItem.nomor_kartu_old">
                              <span v-for="error in errors" v-if="error.nomor_kartu" class="help-block text-danger">{{ error.nomor_kartu[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="nama_customer">Nama Customer</label>
                              <input type="text" name="nama_customer" class="form-control" v-model="fillItem.nama_customer">
                              <span v-for="error in errors" v-if="error.nama_customer" class="help-block text-danger">{{ error.nama_customer[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="tgl_lahir_customer">Tanggal Lahir</label>
                              <date-picker v-model="fillItem.tgl_lahir_customer" lang="en" :not-after="new Date()"></date-picker>
                              <span v-for="error in errors" v-if="error.tgl_lahir_customer" class="help-block text-danger">{{ error.tgl_lahir_customer[0] }}</span>
                            </div>
                            <div class="form-group">
                             <label for="kontak_customer">No. Kontak</label>
                             <input type="text" name="kontak_customer" class="form-control" v-model="fillItem.kontak_customer">
                             <span v-for="error in errors" v-if="error.kontak_customer" class="help-block text-danger">{{ error.kontak_customer[0] }}</span>
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

           <div class="modal fade" id="create-customer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h4 class="modal-title">Form Tambah Customer</h4>
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createCustomer()"> 
                            <div class="form-group">
                              <label for="nama_customer">Nomor Kartu</label>
                              <input type="text" name="nomor_kartu" class="form-control" v-model="newItem.nomor_kartu" disabled="disabled">
                              <span v-for="error in errors" v-if="error.nomor_kartu" class="help-block text-danger">{{ error.nomor_kartu[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="nama_customer">Nama Customer</label>
                              <input type="text" name="nama_customer" class="form-control" v-model="newItem.nama_customer">
                              <span v-for="error in errors" v-if="error.nama_customer" class="help-block text-danger">{{ error.nama_customer[0] }}</span>
                            </div>
                            <div class="form-group">
                              <label for="tgl_lahir_customer">Tanggal Lahir</label>
                              <date-picker v-model="newItem.tgl_lahir_customer" lang="en" :not-after="new Date()"></date-picker>
                              <span v-for="error in errors" v-if="error.tgl_lahir_customer" class="help-block text-danger">{{ error.tgl_lahir_customer[0] }}</span>
                            </div>
                            <div class="form-group">
                             <label for="kontak_customer">No. Kontak</label>
                             <input type="text" name="kontak_customer" class="form-control" v-model="newItem.kontak_customer">
                             <span v-for="error in errors" v-if="error.kontak_customer" class="help-block text-danger">{{ error.kontak_customer[0] }}</span>
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
    import DatePicker from 'vue2-datepicker';
    export default {
        components: {DatePicker},
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
                'nomor_kartu': '',
                'nama_customer': '',
                'tgl_lahir_customer': '',
                'kontak_customer': ''
            },
            fillItem: {
                'nomor_kartu': '',
                'nomor_kartu_old': '',
                'nama_customer': '',
                'tgl_lahir_customer': '',
                'kontak_customer': '',
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
            this.getVueCustomer(this.pagination.current_page);
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
              if (q != '') {
                this.searchCustomer()  
              }
              else {
                this.getVueCustomer()
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
            initAddCustomer()
            {
                this.errors = [];
                var no_kartu = $('#no_kartu').val();
                this.newItem.nomor_kartu = no_kartu;
                $("#create-customer").modal("show");
            },

            searchCustomer(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              axios.get('/pos/admin/search_customer?q='+app.pencarian+'&page='+page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            getVueCustomer(page) {
                axios.get('/pos/admin/data_customer?page=' + page).then(response => {
                    this.items = response.data.data.data,
                    this.pagination = response.data.pagination
                });
            },

            createCustomer() {
                var input = this.newItem;
                axios.post('/pos/admin/simpan_customer', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'nomor_kartu': '',
                        'nama_customer': '',
                        'tgl_lahir_customer': '',
                        'kontak_customer': ''
                    };
                    this.errors = [];
                    $("#create-customer").modal('hide');
                    toastr.success('Customer berhasil dibuat.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            deleteCustomer(item) {
                if (confirm("Yakin ingin menghapus customer : "+item.nama_customer+" ?")) {
                    axios.delete('/pos/admin/destroy_customer/' + item.id).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('Customer behasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                    })
                    .catch(function (response) {
                      alert("Could not delete money quality");
                      return false;
                    });
                  }
            },

            editCustomer(item) {
                this.fillItem.nomor_kartu = item.nomor_kartu;
                this.fillItem.nomor_kartu_old = item.nomor_kartu;
                this.fillItem.nama_customer = item.nama_customer;
                this.fillItem.tgl_lahir_customer = item.tgl_lahir_customer;
                this.fillItem.kontak_customer = item.kontak_customer;
                this.fillItem.id = item.id;
                $("#edit-customer").modal("show");
            },

            updateCustomer(id) {
                var input = this.fillItem;
                axios.put('/pos/admin/update_customer/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nomor_kartu': '',
                        'nomor_kartu_old': '',
                        'nama_customer': '',
                        'tgl_lahir_customer': '',
                        'kontak_customer': '',
                        'id': ''
                    };
                    this.errors = [];
                    $("#edit-customer").modal('hide');
                    toastr.success('Customer berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (error) => {
                    this.errors = error.response.data;
                });
            },

            clearErrors(){
                this.errors = [];
                this.fillItem.nomor_kartu = '';
                this.fillItem.nomor_kartu_old = '';
                this.fillItem.nama_customer = '';
                this.fillItem.kontak_customer = '';
                this.fillItem.tgl_lahir_customer = '';
            },

            clearErrorsAdd(){
                this.errors = [];
                this.newItem.nomor_kartu = '';
                this.newItem.nama_customer = '';
                this.newItem.tgl_lahir_customer = '';
                this.newItem.kontak_customer = '';
            },

            changePage(page) {
                this.pagination.current_page = page;
                this.searchCustomer(page);
            }
        }
    }
</script>
