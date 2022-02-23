<script>
    export default {
        name: "chef-create",

        mounted() {
            if(chef){
                this.isUpdating = true;
                this.chef_id = window.chef['id'];
                this.form.name = window.chef['name'];
                this.form.description = window.chef['description'];
            }
        },

        data() {
            return {
                isUpdating: false,
                chef_id: '',
                form: new Form({
                    name: '',
                    description: '',
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
                    var route = '/admin-dashboard/chefs/' + this.chef_id;
                    axios.patch(route, this.form)
                    .then(window.location.href = "/admin-dashboard/chefs/" + this.chef_id)
                    .catch(function (error) {
                        console.log(error);
                    });
                }else{
                    this.form.post('/admin-dashboard/chefs')
                    .then(
                        window.location.href = "/admin-dashboard/chefs"
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
        }
    };
</script>
