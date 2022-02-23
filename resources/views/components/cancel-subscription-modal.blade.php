<div class="modal fade" id="cancelSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="cancelSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.unsubscribe', Auth::user()->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelSubscriptionModalLabel">Are you sure you want to cancel your Vegano Subscription?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You will no longer be able to order our vegan meals and your credit card will no longer be charged. Your subscription will expire at the end of your last paid week.<br><br>
                    Are you sure you wish to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes, Unsubscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>
