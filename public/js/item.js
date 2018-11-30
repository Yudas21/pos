Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({

    el: '#manage-vue',

    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: {
            'title': '',
            'description': ''
        },
        fillItem: {
            'title': '',
            'description': '',
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
        this.getVueItems(this.pagination.current_page);
    },

    methods: {

        getVueItems: function(page) {
            this.$http.get('/exam/public/vueitems?page=' + page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        searchItems(page){
          var app = this;
          if (typeof page === 'undefined') {
            page = 1;
          }
          this.$http.get('/exam/public/vueitems/search?q='+app.pencarian+'&page='+page)
          .then(function (resp) {
            app.items = resp.data;
            app.itemsData = [];
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Could not load Items");
          });
        },

        createItem: function() {
            var input = this.newItem;
            this.$http.post('/exam/public/vueitems', input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.newItem = {
                    'title': '',
                    'description': ''
                };
                $("#create-item").modal('hide');
                toastr.success('Item Created Successfully.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.formErrors = response.data;
            });
        },

        deleteItem: function(item) {
            this.$http.delete('/exam/public/vueitems/' + item.id).then((response) => {
                this.changePage(this.pagination.current_page);
                toastr.success('Item Deleted Successfully.', 'Success Alert', {
                    timeOut: 5000
                });
            });
        },

        editItem: function(item) {
            this.fillItem.title = item.title;
            this.fillItem.id = item.id;
            this.fillItem.description = item.description;
            $("#edit-item").modal('show');
        },

        updateItem: function(id) {
            var input = this.fillItem;
            this.$http.put('/exam/public/vueitems/' + id, input).then((response) => {
                this.changePage(this.pagination.current_page);
                this.fillItem = {
                    'title': '',
                    'description': '',
                    'id': ''
                };
                $("#edit-item").modal('hide');
                toastr.success('Item Updated Successfully.', 'Success Alert', {
                    timeOut: 5000
                });
            }, (response) => {
                this.formErrorsUpdate = response.data;
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }

    }

});