Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-cabang',

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
        fillItem: {
            'id_branch': '',
            'nama_branch': '',
            'kode_branch': '',
            'id_jenis': '',
            'id_parent': ''
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
        this.getVueCabang(this.pagination.current_page);
    },

    watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchCabang()  
          }
          else {
            this.getVueCabang()
          }
          
        }
      },

    methods: {

        getVueCabang: function(page) {
            this.$http.get('/money_changer/management/data_cabang?q=&page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        searchCabang(page){
          var app = this;
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          
          this.$http.get('/money_changer/management/search_cabang?q='+app.pencarian+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createCabang: function() {
                var input = this.newItem;
                this.$http.post('/money_changer/management/simpan_cabang', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'kode_branch': '',
                        'nama_branch': '',
                        'id_jenis': '',
                        'id_parent': ''
                    };
                    this.$set('errors', '');
                    $("#create-cabang").modal('hide');
                    toastr.success('Cabang baru berhasil ditambah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

        editCabang: function(item) {
            this.fillItem.id_branch = item.id_branch;
            this.fillItem.kode_branch = item.kode_branch;
            this.fillItem.nama_branch = item.nama_branch;
            this.fillItem.id_jenis = item.id_jenis;
            this.fillItem.id_parent = item.id_parent;
            $("#edit-cabang").modal('show');
            // alert(item.id_branch);
            // return false;
        },

        updateCabang: function(id) {
            var input = this.fillItem;
            this.$http.put('/money_changer/management/update_cabang/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                    'id_branch': '',
                    'kode_branch': '',
                    'nama_branch': '',
                    'id_jenis': '',
                    'id_parent': ''
                };
                this.$set('errors', '');
                $("#edit-cabang").modal('hide');
                toastr.success('Update cabang berhasil.', 'Success Alert', {
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
            $('.kode_branch').val('');
            $('.nama_branch').val('');
            $('.id_jenis').val('');
            $('.id_parent').val('');
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.searchCabang(page);
        }
    }

});
