<div class="modal fade" id="resumeSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="resumeSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.resume-subscription', Auth::user()->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="resumeSubscriptionModalLabel">Would you like to resume your subscription?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Your subscription has been canceled. Would you like to resume it and continue receiving vegan meals?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-accent">Yes, Resume My Subscription</button>
                </div>
            </form>
        </div>
    </div>
</div>
