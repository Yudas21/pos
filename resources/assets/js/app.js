
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('adminmenu', require('./components/admin/Menu.vue'));
Vue.component('adminlevel', require('./components/admin/Level.vue'));
Vue.component('adminusers', require('./components/admin/Users.vue'));
Vue.component('adminsupplier', require('./components/admin/Supplier.vue'));
Vue.component('admincustomer', require('./components/admin/Customer.vue'));

Vue.component('gudangsupplier', require('./components/gudang/Supplier.vue'));

Vue.component('kasircustomer', require('./components/kasir/Customer.vue'));

Vue.directive('numeric-only', {
	bind(el) {
				el.addEventListener('keydown', (e) => {
					if ([46, 8, 9, 27, 13, 110, 190].indexOf(e.keyCode) !== -1 ||
						// Allow: Ctrl+A
						(e.keyCode === 65 && e.ctrlKey === true) ||
						// Allow: Ctrl+C
						(e.keyCode === 67 && e.ctrlKey === true) ||
						// Allow: Ctrl+X
						(e.keyCode === 88 && e.ctrlKey === true) ||2
						// Allow: home, end, left, right
						(e.keyCode >= 35 && e.keyCode <= 39)) {
						// let it happen, don't do anything
						return
					}
					// Ensure that it is a number and stop the keypress
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault()
					}
			})
	}
});

Vue.directive('alphabet-only', {
	bind(el) {
		el.addEventListener('keydown', (e) => {
			if (e.keyCode >= 48 && e.keyCode <= 57) {
				e.preventDefault()
			}
		})
	}
});

Vue.directive("maxchars-address", {
  bind: function(el, binding, vnode) {
    var max_chars = binding.expression;
    var handler = function(e) {
      if (e.target.value.length > max_chars) {
        e.target.value = e.target.value.substr(0, max_chars);
      }
    };
    el.addEventListener("input", handler);
  }
});

const app = new Vue({
    el: '#app'
});
