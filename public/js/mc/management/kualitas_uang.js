Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-kualitas_uang',

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
        newItem: {
            'kualitas': '',
            'persentase': ''
        },
        fillItem: {
            'kualitas': '',
            'persentase': '',
            'id': ''
        },
        loading: true,
        errors: []
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
        this.getVueKualitasUang(this.pagination.current_page);
    },

    // watch: {
    //     // whenever question changes, this function will run
    //     pencarian: function (q) {
    //       if (q != '') {
    //         this.searchUang()  
    //       }
    //       else {
    //         this.getVueUang()
    //       }
          
    //     }
    //   },

    methods: {

        getVueKualitasUang: function(page) {
            this.$http.get('/money_changer/management/data_kualitasuang?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        // searchUang(page){
        //   var app = this;
        //   if (typeof page === 'undefined') {
        //     page = 1;
        //   } else {
        //     page = this.pagination.current_page;
        //   }
          
        //   this.$http.get('/money_changer/management/search_matauang?q='+app.pencarian+'&page='+page).then((response) => {
        //     app.items = response.data;
        //   });
        // },

        createKualitasUang: function() {
            var input = this.newItem;
            this.$http.post('/money_changer/management/simpan_kualitasuang', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'kualitas': '',
                    'persentase': ''
                };
                this.$set('errors', '');
                $("#create-kualitas_uang").modal('hide');
                toastr.success('Kualitas uang berhasil dibuat.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        deleteKualitasUang: function(item) {
            if (confirm("Yakin ingin menghapus kualitas uang  "+item.mata_uang+" ?")) {
                this.$http.delete('/money_changer/management/destroy_kualitasuang/' + item.id).then((response) => {
                    this.changePage(this.pagination.current_page);
                    toastr.success('Kualitas uang behasil dihapus.', 'Success Alert', {
                        timeOut: 5000
                    });
                })
                .catch(function (response) {
                  alert("Could not delete money quality");
                  return false;
                });
              }
        },

        editKualitasUang: function(item) {
            this.fillItem.kualitas = item.kualitas;
            this.fillItem.id = item.id;
            this.fillItem.persentase = item.persentase;
            $("#edit-kualitas_uang").modal('show');
        },

        updateKualitasUang: function(id) {
            var input = this.fillItem;
            this.$http.put('/money_changer/management/update_kualitasuang/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                    'kualitas': '',
                    'persentase': '',
                    'id_mata_uang': ''
                };
                this.$set('errors', '');
                $("#edit-kualitas_uang").modal('hide');
                toastr.success('Kualitas uang berhasil diubah.', 'Success Alert', {
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
            $('.kualitas').val('');
            $('.persentase').val('');
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueKualitasUang(page);
        }

    }

});
