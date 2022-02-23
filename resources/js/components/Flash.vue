<template>
    <transition name="fade">
        <div class="alert" :class="level" role="alert" v-show="show">
            {{ body }}
        </div>
    </transition>
</template>

<script>
    export default {
        props: ['message', 'level'],

        data() {
            return {
                body: '',
                level:'alert-info',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message, this.level);
            }

            window.events.$on('flash', message => this.flash(message[0], message[1]));
        },

        methods: {
            flash(message, level) {
                this.body = message;
                this.show = true;
                this.level = 'alert-' + level;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>
