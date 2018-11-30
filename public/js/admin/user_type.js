Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-user_type',

    data: {
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
            'tipe': ''
        },
        fillItem: {
            'tipe': '',
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
        this.getVueUserType(this.pagination.current_page);
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

        getVueUserType: function(page) {
            this.$http.get('/money_changer/admin/data_usertype?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createUserType: function() {
            var input = this.newItem;
            this.$http.post('/money_changer/admin/simpan_usertype', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'tipe': ''
                };
                this.$set('errors', '');
                $("#create-user_type").modal('hide');
                toastr.success('User type baru berhasil dibuat.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },
        
        editUserType: function(item) {
            this.fillItem.tipe = item.tipe;
            this.fillItem.id = item.id;
            $("#edit-user_type").modal('show');
        },

        updateUserType: function(id) {
            var input = this.fillItem;
            this.$http.put('/money_changer/admin/update_usertype/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                    'tipe': '',
                    'id': ''
                };
                this.$set('errors', '');
                $("#edit-user_type").modal('hide');
                toastr.success('User type berhasil diubah.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueUserType(page);
        }

    }

});
