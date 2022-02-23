<script>
    export default {
        data() {
            return {
                name: '',
                chef_id: ''
            }
        },
        methods: {
            beforeOpen (event) {
                this.name = event.params.name;
                this.chef_id = event.params.chef_id;
            }
        }
    }
</script>
