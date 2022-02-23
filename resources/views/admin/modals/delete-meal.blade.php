<delete-meal-modal inline-template>
    <modal name="delete-meal" @before-open="beforeOpen" height="auto" classes="modal-content" pivotY="0.1">
        <div class="modal-header">
            <h5 class="modal-title">Delete @{{ title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$modal.hide('delete-meal')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this meal?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$modal.hide('delete-meal')">Cancel</button>
            <form method="POST" action="/admin-dashboard/meals/delete">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="meal_id" :value="meal_id">

                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Meal</button>
            </form>
        </div>
    </modal>
</delete-meal-modal>
