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

// Moments
Vue.use(require('vue-moment'));

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
Vue.component('show-box-modal', require('./components/ShowBoxModal.vue').default);

// Page Components ==============================================================
// Vue.component('boxes', require('./page-components/Boxes.vue').default);
Vue.component('sign-up', require('./page-components/SignUp.vue').default);

const app = new Vue({
    el: "#app",

    data: {
        boxLoading: false,
        isReplacing: false,
        meal_id: null,
        meal_title: null,
        meal_img: null,
        boxes: [],
    },

    mounted: function() {
        this.boxes = window.boxes;
    },

    methods: {
        showBox(id, title, img){
            this.meal_id = id;
            this.meal_title = title;
            this.meal_img = img;
            if(id){
                this.isReplacing = true
            }
        },

        replaceMeal(meal_id, item_id){
            this.boxLoading = true;
            var route = '/my-box/replace-meal/' + item_id;
            var meal_id = {
                meal_id: meal_id
            };
            axios.patch(route, meal_id)
            .then(
                response => this.boxes = response.data,
                this.meal_id = null,
                this.isReplacing = false,
            )
            .catch(function (error) {
                console.log(error);
            }).finally(() => {
                this.boxLoading = false
            });
        },

        skipBox(box_id){
            this.boxLoading = true;
            var route = '/my-box/skip-box/' + box_id;
            var box_id = {
                box_id: box_id
            };
            axios.patch(route, box_id)
            .then(
                response => this.boxes = response.data,
            )
            .catch(function (error) {
                console.log(error);
            }).finally(() => {
                this.boxLoading = false
            });
        },

        unSkipBox(box_id){
            this.boxLoading = true;
            var route = '/my-box/unskip-box/' + box_id;
            var box_id = {
                box_id: box_id
            };
            axios.patch(route, box_id)
            .then(
                response => this.boxes = response.data,
            )
            .catch(function (error) {
                console.log(error);
            }).finally(() => {
                this.boxLoading = false
            });
        },

        skippableDate(date){
            var now = new Date();
            var skippableDate = now.setDate(now.getDate() + (4+(7-now.getDay())) % 7);

            var parseDate = Date.parse(date);

            if(parseDate > skippableDate){
                return true
            }else{
                return false
            }
        },
    }
});




