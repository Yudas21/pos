Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-pengumuman',

    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 10,
            from: 1,
            to: 0,
            current_page: 1
        },
        levels: [],
        pencarian: '',
        offset: 4,
        errors: [],
        newItem: {
            'id_level': '',
            'teks': ''
        },
        fillItem: {
            'id_level': '',
            'teks': '',
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
        this.getVuePengumuman(this.pagination.current_page);
        this.getVueLevel();
    },

    watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchPengumuman()  
          }
          else {
            this.getVuePengumuman()
          }
          
        }
      },

    methods: {
        getVueLevel: function() {
            this.$http.get('/money_changer/management/data_level').then((response) => {
                this.$set('levels', response.data.data);
            });
        },

        getVuePengumuman: function(page) {
            this.$http.get('/money_changer/management/data_pengumuman?q=&page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        searchPengumuman(page){
          var app = this;
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          
          this.$http.get('/money_changer/management/search_pengumuman?q='+app.pencarian+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createPengumuman: function() {
            var input = this.newItem;
            this.$http.post('/money_changer/management/simpan_pengumuman', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'id_level': '',
                    'teks': ''
                };
                $("#create-pengumuman").modal('hide');
                toastr.success('Pengumuman baru berhasil ditambah.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.errors = response.data;
            });
        },

        clearErrors: function(){
            this.$set('errors', '');
        },

        clearErrorsAdd: function(){
            this.$set('errors', '');
            $('.id_level').val('');
            $('.teks').val('');
        },

        deletePengumuman: function(item) {
            if (confirm("Yakin Ingin Menghapus pengumuman ?")) {
                this.$http.delete('/money_changer/management/destroy_pengumuman/' + item.id).then((response) => {
                    this.changePage(this.pagination.current_page);
                    toastr.success('Pengumuman berhasil dihapus.', 'Success Alert', {
                        timeOut: 5000
                    });
                })
                .catch(function (response) {
                  alert("Could not delete caution");
                  return false;
                });
              }
        },

        editPengumuman: function(item) {
            this.fillItem.id_level = item.id_level;
            this.fillItem.teks = item.teks;
            this.fillItem.id = item.id;
            $("#edit-pengumuman").modal('show');
        },

        updatePengumuman: function(id) {
            var input = this.fillItem;
            this.$http.put('/money_changer/management/update_pengumuman/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                   'id_level': '',
                    'teks': '',
                    'id': ''
                };
                $("#edit-pengumuman").modal('hide');
                toastr.success('Ubah pengumuman berhasil.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.errors = response.data;
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.searchPengumuman(page);
        }
    }

});
