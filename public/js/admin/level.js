Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

    new Vue({

        el: '#manage-level',

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
            parents: [],
            offset: 4,
            errors: [],
            newItem: {
                'deskripsi': ''
            },
            fillItem: {
                'deskripsi': '',
                'deskripsiold': '',
                'id_level': ''
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
            this.getVueLevel(this.pagination.current_page);
        },

        watch: {
            // whenever question changes, this function will run
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

            getVueLevel: function(page) {
                this.$http.get('/money_changer/admin/data_level?q=&page=' + page).then((response) => {
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                });
            },

            searchLevel(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              this.$http.get('/money_changer/admin/search_level?q='+app.pencarian+'&page='+page).then((response) => {
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                });
            },

            createLevel: function() {
                var input = this.newItem;
                this.$http.post('/money_changer/admin/simpan_level', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'deskripsi': ''
                    };
                    this.$set('errors', '');
                    $("#create-level").modal('hide');
                    toastr.success('Level baru berhasil ditambah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

            clearErrors: function(){
                this.$set('errors', '');
            },

            deleteLevel: function(item) {
                if (confirm("Yakin ingin menghapus level "+item.deskripsi+" ?")) {
                    this.$http.delete('/money_changer/admin/destroy_level/' + item.id_level).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('Level berhasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                        this.$set('errors', '');
                    })
                    .catch(function (response) {
                      alert("Data level didapat dihapus");
                      return false;
                    });
                  }
            },

            editLevel: function(item) {
                this.fillItem.deskripsi = item.deskripsi;
                this.fillItem.deskripsiold = item.deskripsi;
                this.fillItem.id_level = item.id_level;
                $("#edit-level").modal('show');
            },

            updateLevel: function(id) {
                var input = this.fillItem;
                this.$http.put('/money_changer/admin/update_level/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'deskripsi': '',
                        'deskripsiold': '',
                        'id_level': ''
                    };
                    this.$set('errors', '');
                    $("#edit-level").modal('hide');
                    toastr.success('Level berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

            changePage: function(page) {
                this.pagination.current_page = page;
                this.searchLevel(page);
            }
        }

    });