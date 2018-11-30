Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
// Vue.http.options.credentials = true;
// Vue.config.debug = false;
// Vue.config.devtools = false;
var id_cabang = $('#id_branch').val();

new Vue({

  el: '#manage-reg_teller',
  data: {
    items: [],
    pagination: {
        total: 0, 
        per_page: 10,
        from: 1, 
        to: 0,
        current_page: 1
      },
    pencarian:[],
    offset: 4,
    errors: [],
    newItem : {'id_branch': id_cabang, 'id_teller':'','jumlah':''},
    fillItem : {'id_kas_idr':'','id_branch': id_cabang,'id_teller':'','jumlah':''}
  },

  computed: {
        isActived: function () {
            return this.pagination.current_page;
        },

        pagesNumber: function () {
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

  ready : function(){
      this.getVueTeller(this.pagination.current_page);
  },

  watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchTeller()  
          }
          else {
            this.getVueTeller()
          }
          
        }
      },


  methods : {


        getVueTeller: function(page){
          
          this.$http.get('/money_changer/management/data_teller?q=&b='+id_cabang+'&page='+page).then(function (response){
            this.$set('items', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        searchTeller(page){
          var app = this;
          
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          this.$http.get('/money_changer/management/search_teller?q='+app.pencarian+'&b='+id_cabang+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createTeller: function(){
            var input = this.newItem;
            this.$http.post('/money_changer/management/simpan_teller',input).then((response) => {
              this.changePage(this.pagination.current_page);
              this.newItem = {'id_branch': id_cabang,'id_teller':'','jumlah':''};
              this.$set('errors', '');
              $("#create-teller").modal('hide');
              toastr.success('Register Teller berhasil disimpan.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        deleteTeller: function(item) {
          if (confirm("Yakin Ingin Menghapus  ID Teller "+item.id_teller+" ?")) {
              this.$http.delete('/money_changer/management/destroy_teller/' + item.id_kas_idr).then((response) => {
                  this.changePage(this.pagination.current_page);
                  toastr.success('Data Teller berhasil dihapus.', 'Success Alert', {
                      timeOut: 5000
                  });
              })
              .catch(function (response) {
                alert("Could not teller");
                return false;
              });
            }
        },

        editTeller: function(item) {
          this.fillItem.id_kas_idr = item.id_kas_idr;
          this.fillItem.id_branch = item.id_branch;
          this.fillItem.id_teller = item.id_teller;
          this.fillItem.jumlah = item.jumlah;
          $("#edit-teller").modal('show');
        },

        updateTeller: function(id) {
          var input = this.fillItem;
          this.$http.put('/money_changer/management/update_teller/' + id, input).then((response) => {
              this.changePage(this.pagination.current_page);
              this.fillItem = {
                  'id_kas_idr': '',
                  'id_teller': '',
                  'jumlah': ''
              };
              this.$set('errors', '');
              $("#edit-teller").modal('hide');
              toastr.success('Update Teller berhasil.', 'Success Alert', {
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
          $('.id_teller').val('');
          $('.jumlah').val('');
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.searchTeller(page);
        }
  }
});