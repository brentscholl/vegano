<delete-chef-modal inline-template>
    <modal name="delete-chef" @before-open="beforeOpen" height="auto" classes="modal-content" pivotY="0.1">
        <div class="modal-header">
            <h5 class="modal-title">Delete @{{ name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$modal.hide('delete-chef')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this chef?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$modal.hide('delete-chef')">Cancel</button>
            <form method="POST" action="/admin-dashboard/chefs/delete">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="chef_id" :value="chef_id">

                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Chef</button>
            </form>
        </div>
    </modal>
</delete-chef-modal>
