<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <img :src="image" class="img-responsive">
            </div>
        </div>
        <div v-show="!imageSet">
            <div class="form-group row align-items-center">
                            <div class="col-md-12">
                    <div class="custom-file b-form-file">
                        <input type="file" v-on:change="onFileChange" class="custom-file-input" id="__BVID__5">
                        <label data-browse="Browse" class="custom-file-label" for="__BVID__5">{{ filePlaceholder }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <button @click.prevent="upload" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-upload"></i>
                    </span>
                        <span class="text">Upload</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-show="imageSet">
            <button @click.prevent="deleteImage" class="btn btn-danger btn-icon-split">
                <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                    </span>
                <span class="text">Delete Image</span>
            </button>
        </div>
    </div>
</template>

<style scoped>
    img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }
</style>
<script>
    export default {
        data() {
            return {
                image_id: '',
                imageTemp: '',
                image: '',
                filePlaceholder: 'Choose a file or drop it here...',
                imageSet: false,
            };
        },
        mounted() {
            if (window.meal) {
                if(window.meal['image']){
                    this.image = window.meal['image']['src'] + window.meal['image']['filename'];
                    this.imageTemp = window.meal['image']['src'] + window.meal['image']['filename'];
                    this.image_id = window.meal['image']['id'];
                    this.imageSet = true;
                }
            }
        },

        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.imageTemp = e.target.result;
                    vm.filePlaceholder = file.name;
                };
                reader.readAsDataURL(file);
            },
            upload() {
                axios.post('/admin-dashboard/images/create', {image: this.imageTemp}).then(response => {
                    this.image = this.imageTemp;
                    Event.fire('imageuploaded', response.data.id);
                    this.image_id = response.data.id;
                    this.imageSet = true;
                });
            },

            deleteImage() {
                axios.delete('/admin-dashboard/images/' + this.image_id, {image_id: this.image_id}).then(response => {
                    this.image = '';
                    this.filePlaceholder = 'Choose a file or drop it here...';
                    Event.fire('imagedeleted', response.data.id);
                    this.imageSet = false;
                });
            }
        }
    };
</script>
