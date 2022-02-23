<script>
    export default {
        data() {
            return {
                meal_id: 'test',
                boxes: [],
            }
        },
        mounted() {
            this.boxes = window.boxes;
        },
        methods: {
            beforeOpen (event) {
                this.meal_id = event.params.meal_id;
            }
        }
    }
</script>
