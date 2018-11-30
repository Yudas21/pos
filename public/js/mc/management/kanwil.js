Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-kanwil',

    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 10,
            from: 1,
            to: 0,
            current_page: 1
        },
        pencarian: '',
        offset: 4,
        errors: [],
        newItem: {
            'kode_kanwil': '',
            'nama_kanwil': '',
            'kode_branch': '',
            'nama_branch': ''
        },
        fillItem: {
            'kode_kanwil': '',
            'nama_kanwil': '',
            'kode_branch': '',
            'nama_branch': '',
            'id': ''
        },
        loading: true
    },

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

    ready: function() {
        this.getVueKanwil(this.pagination.current_page);
    },

    watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchKanwil()  
          }
          else {
            this.getVueKanwil()
          }
          
        }
      },

    methods: {

        getVueKanwil: function(page) {
            this.$http.get('/money_changer/management/data_kanwil?q=&page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        searchKanwil(page){
          var app = this;
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          
          this.$http.get('/money_changer/management/search_kanwil?q='+app.pencarian+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createKanwil: function() {
            var input = this.newItem;
            this.$http.post('/money_changer/management/simpan_kanwil', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'kode_kanwil': '',
                    'nama_kanwil': '',
                    'kode_branch': '',
                    'nama_branch': ''
                };
                this.$set('errors', '');
                $("#create-kanwil").modal('hide');
                toastr.success('Kantor wilayah baru berhasil ditambah.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        deleteKanwil: function(item) {
            if (confirm("Yakin Ingin Menghapus  "+item.nama_kanwil+" ?")) {
                this.$http.delete('/money_changer/management/destroy_kanwil/' + item.id).then((response) => {
                    this.changePage(this.pagination.current_page);
                    toastr.success('Data kantor wilayah berhasil dihapus.', 'Success Alert', {
                        timeOut: 5000
                    });
                })
                .catch(function (response) {
                  alert("Could not delete kantor wilayah");
                  return false;
                });
              }
        },

        editKanwil: function(item) {
            this.fillItem.kode_kanwil = item.kode_kanwil;
            this.fillItem.nama_kanwil = item.nama_kanwil;
            this.fillItem.kode_branch = item.kode_branch;
            this.fillItem.id = item.id;
            $("#edit-kanwil").modal('show');
        },

        updateKanwil: function(id) {
            var input = this.fillItem;
            this.$http.put('/money_changer/management/update_kanwil/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                    'kode_kanwil': '',
                    'nama_kanwil': '',
                    'kode_branch': '',
                    'nama_branch': '',
                    'id': ''
                };
                this.$set('errors', '');
                $("#edit-kanwil").modal('hide');
                toastr.success('Update kantor wilayah berhasil.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        clearErrors: function(){
                this.$set('errors', '');
        },
        clearErrorsAdd: function(){
            this.$set('errors', '');
            $('.kode_kanwil').val('');
            $('.nama_kanwil').val('');
            $('.kode_branch').val('');
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.searchKanwil(page);
        }
    }

});
