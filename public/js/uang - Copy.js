Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-uang',

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
        formErrors: {},
        formErrorsUpdate: {},
        newUang: {
            'simbol': '',
            'mata_uang': '',
            'negara': ''
        },
        fillUang: {
            'simbol': '',
            'mata_uang': '',
            'negara': '',
            'id_mata_uang': ''
        }
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
        this.getVueUang(this.pagination.current_page);
    },

    watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchUang()  
          }
          else {
            this.getVueUang()
          }
          
        }
      },

    methods: {

        getVueUang: function(page) {
            this.$http.get('/exam/public/management/tambahmatauang?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        searchUang(page){
          var app = this;
          if (typeof page === 'undefined') {
            page = 1;
          }
          this.$http.get('/exam/public/management/search_matauang?q='+app.pencarian+'&page='+page).then((response) => {
            app.items = response.data;
            // app.pagination = response.data.pagination;
          });
        },

        createUang: function() {
            var input = this.newUang;
            this.$http.post('/exam/public/management/simpan_matauang', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newUang = {
                    'simbol': '',
                    'mata_uang': '',
                    'negara': ''
                };
                $("#create-uang").modal('hide');
                toastr.success('Tambah mata uang berhasil.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.formErrors = response.data;
            });
        },

        deleteUang: function(item) {
            this.$http.delete('/exam/public/management/destroy_matauang/' + item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Hapus mata uang berhasil.', 'Success Alert', {
                    timeOut: 5000
                });
            });
        },

        editUang: function(item) {
            this.fillUang.simbol = item.simbol;
            this.fillUang.negara = item.negara;
            this.fillUang.id_mata_uang = item.id_mata_uang;
            this.fillUang.mata_uang = item.mata_uang;
            $("#edit-uang").modal('show');
        },

        updateUang: function(id) {
            var input = this.fillUang;
            this.$http.put('/exam/public/management/update_matauang/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillUang = {
                    'simbol': '',
                    'mata_uang': '',
                    'negara': '',
                    'id_mata_uang': ''
                };
                $("#edit-uang").modal('hide');
                toastr.success('Mata uang berhasil diubah.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.formErrorsUpdate = response.data;
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
        }

    }

});
