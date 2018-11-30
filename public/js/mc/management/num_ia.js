Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
// Vue.http.options.credentials = true;
// Vue.config.debug = false;
// Vue.config.devtools = false;
var id_cabang = $('#id_branch').val();id_cabang
new Vue({

  el: '#manage-ia',
  data: {
    items: [],
    pagination: {
        total: 0, 
        per_page: 10,
        from: 1, 
        to: 0,
        current_page: 1
      },
    options: [{text:'Pilih', value:null}, {text:'Aktiva', value:'0'},{text:'Passiva', value:'1'} ],
    pencarian:[],
    moneys: [],
    offset: 4,
    errors: [],
    newItem : {'id_branch': id_cabang,'id_mata_uang':'','num_ia':'','is_passiva':''},
    fillItem : {'id_branch': id_cabang,'id_mata_uang':'','num_ia':'','is_passiva':'', 'id_num_ia':''}
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
      this.getVueIA(this.pagination.current_page);
      this.getVueMoney();
      
  },

  watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchIA()  
          }
          else {
            this.getVueIA()
          }
          
        }
      },


  methods : {


        getVueIA: function(page){
          this.$http.get('/money_changer/management/data_ia?q=&b='+id_cabang+'&page='+page).then(function (response){
            this.$set('items', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        getVueMoney: function(){
          this.$http.get('/money_changer/management/data_money').then(function (response){
            this.$set('moneys', response.data.data);
          });
        },

        searchIA(page){
          var app = this;
          
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          this.$http.get('/money_changer/management/search_ia?q='+app.pencarian+'&b='+id_cabang+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        createIA: function(){
            var input = this.newItem;
            this.$http.post('/money_changer/management/simpan_ia',input).then((response) => {
              this.changePage(this.pagination.current_page);
              this.newItem = {'id_branch': id_cabang,'id_mata_uang':'','num_ia':'','is_passiva':''};
              this.$set('errors', '');
              $("#create-ia").modal('hide');
              toastr.success('Register IA berhasil disimpan.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        deleteIA: function(item) {
                if (confirm("Yakin ingin menghapus IA dengan nomor : "+item.num_ia+" ?")) {
                    this.$http.delete('/money_changer/management/destroy_ia/' + item.id_num_ia).then((response) => {
                        this.changePage(this.pagination.current_page);
                        toastr.success('IA berhasil dihapus.', 'Success Alert', {
                            timeOut: 5000
                        });
                        this.$set('errors', '');
                    })
                    .catch(function (response) {
                      alert("Could not delete IA");
                      return false;
                    });
                  }
        },

        editIA: function(item){
            this.fillItem.id_branch = item.id_branch;
            this.fillItem.id_mata_uang = item.id_mata_uang;
            this.fillItem.num_ia = item.num_ia;
            this.fillItem.is_passiva = item.is_passiva;
            this.fillItem.id_num_ia = item.id_num_ia;
            //alert(this.fillItem.is_passiva);
            $("#edit-ia").modal('show');
        },

        updateIA: function(id){
          var input = this.fillItem;
          this.$http.put('/money_changer/management/update_ia/'+id,input).then((response) => {
              this.changePage(this.pagination.current_page);
              this.fillItem = {'id_branch': id_cabang,'id_mata_uang':'','num_ia':'','is_passiva':'', 'id_num_ia':''};
              this.$set('errors', '');
              $("#edit-ia").modal('hide');
              toastr.success('IA berhasil diubah.', 'Success Alert', {timeOut: 5000});
            }, (response) => {
                this.$set('errors', response.data.errors);
            });
        },

        clearErrors: function(){
                this.$set('errors', '');
        },

        clearErrorsAdd: function(){
                this.$set('errors', '');
                $('.id_mata_uang').val('');
                $('.num_ia').val('');
                $('.is_passiva').val('');
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.searchIA(page);
        }
  }
});