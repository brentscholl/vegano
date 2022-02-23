<delete-product-modal inline-template>
    <modal name="delete-product" @before-open="beforeOpen" height="auto" classes="modal-content" pivotY="0.1">
        <div class="modal-header">
            <h5 class="modal-title">Delete @{{ title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$modal.hide('delete-product')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this product?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$modal.hide('delete-product')">Cancel</button>
            <form method="POST" action="/admin-dashboard/products/delete">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="product_id" :value="product_id">

                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Product</button>
            </form>
        </div>
    </modal>
</delete-product-modal>
