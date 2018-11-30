Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
// Vue.http.options.credentials = true;
// Vue.config.debug = false;
// Vue.config.devtools = false;

new Vue({

  el: '#manage-pengajuannego',
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
    errors: []
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
      this.getVuePengajuanNego(this.pagination.current_page);
      
  },

  watch: {
        // whenever question changes, this function will run
        pencarian: function (q) {
          if (q != '') {
            this.searchPengajuanNego()  
          }
          else {
            this.getVuePengajuanNego()
          }
          
        }
      },


  methods : {
        getVuePengajuanNego: function(page){
          this.$http.get('/money_changer/management/data_pengajuannego?q=&page='+page).then(function (response){
            this.$set('items', response.data.data.data);
            this.$set('pagination', response.data.pagination);
          });
        },

        searchPengajuanNego(page){
          var app = this;
          
          if (typeof page === 'undefined') {
            page = 1;
          } else {
            page = this.pagination.current_page;
          }
          this.$http.get('/money_changer/management/search_pengajuannego?q='+app.pencarian+'&page='+page).then((response) => {
                this.$set('items', response.data.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        clearErrors: function(){
                this.$set('errors', '');
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.searchPengajuanNego(page);
        }
  }
});