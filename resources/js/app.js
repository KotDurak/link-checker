/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
$('[data-toggle="tooltip"]').tooltip();
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* const app = new Vue({
    el: '#app',
}); */


$('#main-checkbox').on('change', function (e) {
   let _this = $(this);

   _this.parents('table').find('.table-checkbox').each(function() {
       let current = $(this);
       if (_this.is(':checked')) {
           current.prop('checked', true);
       } else {
           current.prop('checked', false);
       }
   });
});

$('#remove-select').on('click', function() {
    let ids = [];

    $('.table-checkbox:checked').each(function() {
        ids.push($(this).val());
    });

    $.ajax({
        url:'/project/links-delete',
        type:'post',
        data:{
            ids:ids,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success:function() {
            for (var i = 0; i < ids.length; i++) {
                $('[data-key="' + ids[i] +'"]').remove();
            }
        }
    });
});