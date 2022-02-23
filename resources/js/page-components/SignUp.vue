<script>
    export default {
        name: "sign-up",
        mounted() {
            if(price){
                this.form.price = window.price;
            }
        },
        data() {
            return {
                form: new Form({
                    coupon_code: '',
                    price: '',
                    weeks: '',
                    valid: false,
                    error: false,
                }),
            };
        },
        created() {
        },

        methods: {
            onSubmit() {
                this.form.post('/coupon-check')
                .then(
                    response => {
                        if(response.id > 0){
                            this.form.valid = true;
                            this.form.price = 0;
                            this.form.weeks = response.amount;
                            this.form.coupon_code = response.token;
                            this.form.error = false;
                        }else{
                            this.form.error = true;
                            this.form.valid = false;
                            this.form.price = window.price;
                        }
                    }
                );
            },
        }
    };
</script>
