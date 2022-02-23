(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/page-components/MealCreate.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/page-components/MealCreate.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      form: new Form({
        title: '',
        sub_title: '',
        description: '',
        time: '',
        servings: '',
        calories: '',
        fat: '',
        carbs: '',
        protein: '',
        image_id: '',
        start_date: '',
        end_date: '',
        sku: '',
        inventory: '',
        premium: '',
        recipes: [{
          step: 1,
          title: '',
          description: ''
        }],
        ingredients: [{
          measurement: '',
          title: ''
        }],
        tools: [{
          title: ''
        }],
        allergens: [{
          title: ''
        }],
        publish: ''
      })
    };
  },
  created: function created() {
    var _this = this;

    Event.listen('imageuploaded', function (value) {
      _this.form.image_id = value;
    });
    Event.listen('imagedeleted', function (value) {
      _this.form.image_id = '';
    });
  },
  methods: {
    onSubmit: function onSubmit() {
      this.form.post('/admin-dashboard/meals').then(window.location.href = "/admin-dashboard/meals");
    },
    publishForm: function publishForm() {
      this.form.publish = 1;
      this.onSubmit();
    },
    saveForm: function saveForm() {
      this.form.publish = 0;
      this.onSubmit();
    },
    addRecipe: function addRecipe() {
      var elem = document.createElement('div');
      this.form.recipes.push({
        step: '',
        title: '',
        description: ''
      });
    },
    removeRecipe: function removeRecipe(index) {
      this.form.recipes.splice(index, 1);
    },
    addIngredient: function addIngredient() {
      var elem = document.createElement('div');
      this.form.ingredients.push({
        title: "",
        measurement: ""
      });
    },
    removeIngredient: function removeIngredient(index) {
      this.form.ingredients.splice(index, 1);
    },
    addTool: function addTool() {
      var elem = document.createElement('div');
      this.form.tools.push({
        title: ""
      });
    },
    removeTool: function removeTool(index) {
      this.form.tools.splice(index, 1);
    },
    addAllergen: function addAllergen() {
      var elem = document.createElement('div');
      this.form.allergens.push({
        title: ""
      });
    },
    removeAllergen: function removeAllergen(index) {
      this.form.allergens.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./resources/js/page-components/MealCreate.vue":
/*!*****************************************************!*\
  !*** ./resources/js/page-components/MealCreate.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MealCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MealCreate.vue?vue&type=script&lang=js& */ "./resources/js/page-components/MealCreate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns




/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _MealCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/page-components/MealCreate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/page-components/MealCreate.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/page-components/MealCreate.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MealCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./MealCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/page-components/MealCreate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MealCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ })

}]);