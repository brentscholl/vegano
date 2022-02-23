<script>
    export default {
        data() {
            return {
                title: '',
                product_id: ''
            }
        },
        methods: {
            beforeOpen (event) {
                this.title = event.params.title;
                this.product_id = event.params.product_id;
            }
        }
    }
</script>
