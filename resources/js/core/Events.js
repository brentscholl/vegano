class Events {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.vue = new Vue();
    }

    /**
     * Fire an Event
     * @param event
     * @param data
     */
    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    /**
     * Listen for an event
     * @param event
     * @param callback
     */
    listen(event, callback){
        this.vue.$on(event, callback);
    }
}

export default Events;
