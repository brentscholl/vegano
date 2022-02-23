<script>
    export default {
        name: "product-create",

        mounted() {
            if(product){
                this.isUpdating = true;
                this.product_id = window.product['id'];
                this.form.title = window.product['title'];
                this.form.sub_title = window.product['sub_title'];
                this.form.description = window.product['description'];
                this.form.weight = window.product['weight'];
                this.form.price = window.product['price'];
                this.form.calories = window.product['calories'];
                this.form.fat = window.product['fat'];
                this.form.carbs = window.product['carbs'];
                this.form.protein = window.product['protein'];
                this.form.image_id = window.product['image_id'];
                this.form.sku = window.product['sku'];
                this.form.inventory = window.product['inventory'];
                this.form.allergens = window.product['allergens'];
            }
        },

        data() {
            return {
                isUpdating: false,
                product_id: '',
                form: new Form({
                    title: '',
                    sub_title: '',
                    description: '',
                    weight: '',
                    price: '',
                    calories: '',
                    fat: '',
                    carbs: '',
                    protein: '',
                    image_id: '',
                    sku: '',
                    inventory: '',

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
                    var route = '/admin-dashboard/products/' + this.product_id;
                    axios.patch(route, this.form)
                    .then(
                        window.location.href = "/admin-dashboard/products/" + this.product_id
                    )
                    .catch(function (error) {
                        console.log(error);
                    });
                }else{
                    this.form.post('/admin-dashboard/products')
                    .then(
                        window.location.href = "/admin-dashboard/products"
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
