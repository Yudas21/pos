Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

    new Vue({

        el: '#manage-menu',

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
                'name': '',
                'url': '',
                'parent': ''
            },
            fillItem: {
                'name': '',
                'url': '',
                'parent': '',
                'id': ''
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
            getVueParentMenu: function(page) {
                this.$http.get('/money_changer/admin/data_menu_parent').then((response) => {
                    this.$set('parents', response.data.data);
                });
            },
            
            getVueMenu: function(page) {
                this.$http.get('/money_changer/admin/data_menu?q=&page=' + page).then((response) => {
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                });
            },

            searchMenu(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              this.$http.get('/money_changer/admin/search_menu?q='+app.pencarian+'&page='+page).then((response) => {
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                });
            },

            createMenu: function() {
                var input = this.newItem;
                this.$http.post('/money_changer/admin/simpan_menu', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'name': '',
                        'url': '',
                        'parent': ''
                    };
                    this.$set('errors', '');
                    $("#create-menu").modal('hide');
                    toastr.success('Menu baru berhasil ditambah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

            clearErrors: function(){
                this.$set('errors', '');
            },

            deleteMenu: function(item) {
                if (confirm("Yakin ingin menghapus menu "+item.name+" ?")) {
                    this.$http.delete('/money_changer/admin/destroy_menu/' + item.id).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('Menu berhasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                        this.$set('errors', '');
                    })
                    .catch(function (response) {
                      alert("Tidak dapat menghapus menu");
                      return false;
                    });
                  }
            },

            editMenu: function(item) {
                this.fillItem.name = item.name;
                this.fillItem.url = item.url;
                this.fillItem.parent = item.parent;
                this.fillItem.id = item.id;
                $("#edit-menu").modal('show');
            },

            updateMenu: function(id) {
                var input = this.fillItem;
                this.$http.put('/money_changer/admin/update_menu/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'name': '',
                        'url': '',
                        'parent': '',
                        'id': ''
                    };
                    this.$set('errors', '');
                    $("#edit-menu").modal('hide');
                    toastr.success('Menu berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

            changePage: function(page) {
                this.pagination.current_page = page;
                this.searchMenu(page);
            }
        }

    });