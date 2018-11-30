Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

    new Vue({

        el: '#manage-users',

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
                'nama_lengkap': '',
                'tempat_lahir': '',
                'tgl_lahir': '',
                'alamat': '',
                'mobile': '',
                'username': '',
                'password': '',
                'password_confirm': '',
                'id_level': '',
                'user_type': '',
                'id_branch': ''
            },
            fillItem: {
                'nama_lengkap': '',
                'tempat_lahir': '',
                'tgl_lahir': '',
                'alamat': '',
                'mobile': '',
                'username': '',
                'usernameold': '',
                'id_level': '',
                'user_type': '',
                'id_branch': '',
                'password': '',
                'password_confirm': '',
                'active': '',
                'id_user': ''
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
            this.getVueUser(this.pagination.current_page);
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
              if (q != '') {
                this.searchUser()  
              }
              else {
                this.getVueUser()
              }
              
            }
          },

        methods: {
            
            getVueUser: function(page) {
                this.$http.get('/money_changer/admin/data_users?q=&page=' + page).then((response) => {
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                });
            },

            searchUser(page){
              var app = this;
              if (typeof page === 'undefined') {
                page = 1;
              } else {
                page = this.pagination.current_page;
              }
              
              this.$http.get('/money_changer/admin/search_users?q='+app.pencarian+'&page='+page).then((response) => {
                    this.$set('items', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                });
            },

            clearErrors: function(){
                this.$set('errors', '');
            },

            createUser: function() {
                var input = this.newItem;
                this.$http.post('/money_changer/admin/store_users', input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.newItem = {
                        'nama_lengkap': '',
                        'tempat_lahir': '',
                        'tgl_lahir': '',
                        'alamat': '',
                        'mobile': '',
                        'username': '',
                        'password': '',
                        'password_confirm': '',
                        'id_level': '',
                        'user_type': '',
                        'id_branch': ''
                    };
                    this.$set('errors', '');
                    $("#create-user").modal('hide');
                    toastr.success('User baru berhasil ditambah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },


            deleteUser: function(item) {
                if (confirm("Yakin ingin menghapus User "+item.nama_lengkap+" ?")) {
                    this.$http.delete('/money_changer/admin/delete_users/' + item.id_user).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('User berhasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                        this.$set('errors', '');
                    })
                    .catch(function (response) {
                      alert("Could not delete User");
                      return false;
                    });
                  }
            },

            editUser: function(item) {
                this.fillItem.nama_lengkap = item.nama_lengkap;
                this.fillItem.tempat_lahir = item.tempat_lahir;
                this.fillItem.tgl_lahir = item.tgl_lahir;
                this.fillItem.alamat = item.alamat;
                this.fillItem.mobile = item.mobile;
                this.fillItem.username = item.username;
                this.fillItem.usernameold = item.username;
                this.fillItem.id_level = item.id_level;
                this.fillItem.user_type = item.user_type;
                this.fillItem.id_branch = item.id_branch;
                this.fillItem.active = item.active;
                this.fillItem.id_user = item.id_user;
                $("#edit-user").modal('show');
            },

            updateUser: function(id) {
                var input = this.fillItem;
                this.$http.put('/money_changer/admin/update_users/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'nama_lengkap': '',
                        'tempat_lahir': '',
                        'tgl_lahir': '',
                        'alamat': '',
                        'mobile': '',
                        'username': '',
                        'usernameold': '',
                        'id_level': '',
                        'user_type': '',
                        'id_branch': '',
                        'active': '',
                        'id_user': ''
                    };
                    this.$set('errors', '');
                    $("#edit-user").modal('hide');
                    toastr.success('User berhasil diubah.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

            editPasswordUser: function(item) {
                this.fillItem.id_user = item.id_user;
                this.fillItem.password = '';
                this.fillItem.password_confirm = '';
                $("#edit-password-user").modal('show');
            },

            updatePasswordUser: function(id) {
                var input = this.fillItem;
                this.$http.put('/money_changer/admin/update_password_users/' + id, input).then((response) => {
                    this.changePage(this.pagination.current_page);
                    this.fillItem = {
                        'password': '',
                        'password_confirm': '',
                        'id_user': ''
                    };
                    this.$set('errors', '');
                    $("#edit-password-user").modal('hide');
                    toastr.success('Ubah password baru berhasil.', 'Success Alert', {
                        timeOut: 5000
                    });
                }, (response) => {
                    this.$set('errors', response.data.errors);
                });
            },

            changePage: function(page) {
                this.pagination.current_page = page;
                this.searchUser(page);
            }
        }

    });