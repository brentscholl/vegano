require('./bootstrap');

window.Vue = require('vue');


import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Vue Modal
import Vmodal from 'vue-js-modal'
Vue.use(Vmodal);


window.events = new Vue();

window.flash = function (message, level) {
    window.events.$emit('flash', [message, level]);
};
window.flashoverlay = function (message, title) {
    window.events.$emit('flashoverlay', [message, title]);
};

// Import Core Classes
import Form from './core/Form';
window.Form = Form;

window.Event = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback){
        this.vue.$on(event, callback);
    }
}

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('file-upload', require('./components/FileUpload.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('flashoverlay', require('./components/FlashOverlay.vue').default);

// Modals
Vue.component('delete-meal-modal', require('./components/DeleteMealModal.vue').default);
Vue.component('delete-product-modal', require('./components/DeleteProductModal.vue').default);
Vue.component('delete-chef-modal', require('./components/DeleteChefModal.vue').default);


// Page Components ==============================================================
Vue.component('meal-create', require('./page-components/MealCreate.vue').default);
Vue.component('product-create', require('./page-components/ProductCreate.vue').default);
Vue.component('chef-create', require('./page-components/ChefCreate.vue').default);

const adminapp = new Vue({
    el: "#app",

    // components: {
    //     'mealCreate': require('./page-components/MealCreate.vue'),
    // }
});




