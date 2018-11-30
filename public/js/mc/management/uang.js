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
        errors: [],
        newItem: {
            'simbol': '',
            'mata_uang': '',
            'id_negara': ''
        },
        fillItem: {
            'simbol': '',
            'mata_uang': '',
            'id_negara': '',
            'id_mata_uang': ''
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
            this.$http.get('/money_changer/management/data_matauang?q=&page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        searchUang(page){
          var app = this;
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          
          this.$http.get('/money_changer/management/search_matauang?q='+app.pencarian+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createUang: function() {
            var input = this.newItem;
            this.$http.post('/money_changer/management/simpan_matauang', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'simbol': '',
                    'mata_uang': '',
                    'id_negara': ''
                };
                this.$set('errors', '');
                $("#create-uang").modal('hide');
                toastr.success('Mata uang baru berhasil ditambah.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        deleteUang: function(item) {
            if (confirm("Yakin Ingin Menghapus  "+item.mata_uang+" ?")) {
                this.$http.delete('/money_changer/management/destroy_matauang/' + item.id_mata_uang).then((response) => {
                    this.changePage(this.pagination.current_page);
                    toastr.success('Data mata uang berhasil dihapus.', 'Success Alert', {
                        timeOut: 5000
                    });
                })
                .catch(function (response) {
                  alert("Could not delete money");
                  return false;
                });
              }
        },

        editUang: function(item) {
            this.fillItem.simbol = item.simbol;
            this.fillItem.id_mata_uang = item.id_mata_uang;
            this.fillItem.mata_uang = item.mata_uang;
            this.fillItem.id_negara = item.id_negara;
            $("#edit-uang").modal('show');
        },

        updateUang: function(id) {
            var input = this.fillItem;
            this.$http.put('/money_changer/management/update_matauang/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                    'simbol': '',
                    'id_negara': '',
                    'mata_uang': '',
                    'id_mata_uang': ''
                };
                this.$set('errors', '');
                $("#edit-uang").modal('hide');
                toastr.success('Update mata uang berhasil.', 'Success Alert', {
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
            $('.id_negara').val('');
            $('.simbol').val('');
            $('.mata_uang').val('');
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.searchUang(page);
        }
    }

});
