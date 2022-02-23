<template>
    <transition name="fade">
        <div id="flash-overlay-modal" class="modal fade" :class="{ 'show' : show == true}" tabindex="-1" role="dialog" aria-labelledby="flash-overlay-modalLabel" style="display: block; padding-right: 17px;" aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="flash-overlay-modalLabel">{{ title }}</h5>
                        <button type="button" @click="dismiss" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ message }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="dismiss" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: ['title', 'message'],

        data() {
            return {
                title:'',
                message: '',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.title, this.message);
            }

            window.events.$on('flashoverlay', message => this.flash(message[0], message[1]));
        },

        methods: {
            flash(title, message) {
                this.title = title;
                this.message = message;
                this.show = true;
            },

            dismiss() {
                this.show = false;
            }
        }
    };
</script>
