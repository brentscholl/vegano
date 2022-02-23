<script>
    export default {
        data() {
            return {
                title: '',
                meal_id: ''
            }
        },
        methods: {
            beforeOpen (event) {
                this.title = event.params.title;
                this.meal_id = event.params.meal_id;
            }
        }
    }
</script>
