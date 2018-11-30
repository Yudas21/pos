Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
// Vue.http.options.credentials = true;
// Vue.config.debug = false;
// Vue.config.devtools = false;

new Vue({

  el: '#manage-limitkascabang',
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
    fillItem : {'id_branch':'','nama_branch':'','kode_branch':'','limit_kas':''}
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
      this.getVueLimitKasCabang(this.pagination.current_page);
      this.formatCurrency(limit);
  },

  watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchLimitKasCabang()  
          }
          else {
            this.getVueLimitKasCabang()
          }
          
        }
      },


  methods : {

        formatCurrency: function(value) {
          let val = (value/1).toFixed(2).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

        getVueLimitKasCabang: function(page){
          this.$http.get('/money_changer/management/data_limitkascabang?q=&page='+page).then(function (response){
            this.$set('items', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        searchLimitKasCabang(page){
          var app = this;
          
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          this.$http.get('/money_changer/management/search_limitkascabang?q='+app.pencarian+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        editLimitKasCabang: function(item){
            this.fillItem.id_branch = item.id_branch;
            this.fillItem.nama_branch = item.nama_branch;
            this.fillItem.kode_branch = item.kode_branch;
            this.fillItem.limit_kas = item.limit_kas;
            //alert(this.fillItem.is_passiva);
            $("#edit-limitkascabang").modal('show');
        },

        updateLimitKasCabang: function(id){
          var input = this.fillItem;
          this.$http.put('/money_changer/management/update_limitkascabang/'+id,input).then((response) => {
              this.changePage(this.pagination.current_page);
              this.fillItem = {'id_branch':'','nama_branch':'','kode_branch':'','limit_kas':''};
              this.$set('errors', '');
              $("#edit-limitkascabang").modal('hide');
              toastr.success('Limit Kas Cabang berhasil diubah.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        clearErrors: function(){
                this.$set('errors', '');
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.searchLimitKasCabang(page);
        }
  }
});