/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/Flash.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


import Modal from "./plugins/modal/ModalPlugin";
Vue.use(Modal)

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('thread-view', require('./components/pages/Thread.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications').default);
Vue.component('scroll-link',require('./components/ScrollLink').default)
Vue.component('dropdown',require('./components/Dropdown').default)
Vue.component('confirm-dialog',require('./components/ConfirmDialog').default)
Vue.component('confirm-button',require('./components/ConfirmButton').default)

import Visible from "./components/Visible";
Vue.component('visible',Visible)




Vue.directive('scroll-to',{
    bind(el,binding){
        el.addEventListener('click',function(){
            document.querySelector(binding.value).scrollIntoView({behavior:'smooth'})
        })
    }
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    methods:{
        confirm(message){
            this.$modal.dialog(message)
                .then(confirmed =>{
                    if(confirmed){
                        alert('Proceed')
                    }else{
                        alert('Cancel')
                    }
                })
        }
    }
});
