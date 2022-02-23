<script>
    export default {
        name: "meal-create",

        mounted() {
            this.form.chefs = window.chefs;

            if(meal){
                this.isUpdating = true;
                this.meal_id = window.meal['id'];
                this.form.title = window.meal['title'];
                this.form.sub_title = window.meal['sub_title'];
                this.form.description = window.meal['description'];
                this.form.time = window.meal['time'];
                this.form.servings = window.meal['servings'];
                this.form.calories = window.meal['calories'];
                this.form.fat = window.meal['fat'];
                this.form.carbs = window.meal['carbs'];
                this.form.protein = window.meal['protein'];
                this.form.image_id = window.meal['image_id'];
                this.form.start_date = window.meal['start_date'];
                this.form.end_date = window.meal['end_date'];
                this.form.sku = window.meal['sku'];
                this.form.inventory = window.meal['inventory'];
                this.form.premium = window.meal['premium'];
                this.form.country = window.meal['premium'];
                this.form.chef_id = window.meal['chef_id'];

                this.form.recipes = window.meal['recipe_steps'];
                this.form.ingredients = window.meal['ingredients'];
                this.form.tools = window.meal['tools'];
                this.form.allergens = window.meal['allergens'];

                this.form.countries = window.countries;
            }
        },

        data() {
            return {
                isUpdating: false,
                meal_id: '',
                form: new Form({
                    title: '',
                    sub_title: '',
                    description: '',
                    time: '',
                    servings: '2',
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
                    chef_id: '',
                    chefs: [],

                    countries: [],

                    recipes: [{
                        step: 1,
                        title: '',
                        description: '',
                    }],

                    ingredients: [{
                        pivot: {
                            measurement: '',
                        },
                        name: '',
                    }],

                    tools: [{
                        name: '',
                    }],

                    allergens: [{
                        name: '',
                    }],

                    publish: '0',
                }),
            };
        },
        created() {
            Event.listen('imageuploaded', (value) => {
                this.form.image_id = value;
            });
            Event.listen('imagedeleted', (value) => {
                this.form.image_id = '';
            });
        },

        methods: {
            onSubmit() {
                if(this.isUpdating){
                    var route = '/admin-dashboard/meals/' + this.meal_id;
                    axios.patch(route, this.form)
                    .then(window.location.href = "/admin-dashboard/meals/" + this.meal_id)
                    // .then()
                    .catch(function (error) {
                        console.log(error);
                    });
                }else{
                    this.form.post('/admin-dashboard/meals')
                    .then(
                        window.location.href = "/admin-dashboard/meals"
                    );
                }
            },

            publishForm() {
                this.form.publish = 1;
                this.onSubmit();
            },
            saveForm() {
                this.form.publish = 0;
                this.onSubmit();
            },

            addRecipe: function() {
                var elem = document.createElement('div');
                this.form.recipes.push({
                    step: '',
                    title: '',
                    description: '',
                });
            },
            removeRecipe: function(index) {
                this.form.recipes.splice(index, 1);
            },

            addIngredient: function() {
                var elem = document.createElement('div');
                this.form.ingredients.push({
                    title: "",
                    pivot:{
                        measurement: ""
                    },
                });
            },
            removeIngredient: function(index) {
                this.form.ingredients.splice(index, 1);
            },

            addTool: function() {
                var elem = document.createElement('div');
                this.form.tools.push({
                    title: "",
                });
            },
            removeTool: function(index) {
                this.form.tools.splice(index, 1);
            },

            addAllergen: function() {
                var elem = document.createElement('div');
                this.form.allergens.push({
                    title: "",
                });
            },
            removeAllergen: function(index) {
                this.form.allergens.splice(index, 1);
            },
        }
    };
</script>
