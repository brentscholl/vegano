<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.destroy') }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Are you sure you want to delete your Vegano Account?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Your account will be deleted from Vegano. If you are subscribed, your subscription will be canceled. All of you data will be removed.<br><br>
                    Are you sure you wish to continue?
                    <div class="form-group mt-2">
                        <label for="password">Enter your password to confirm:</label>
                        <input id="password" type="text" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
