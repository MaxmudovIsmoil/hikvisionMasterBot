<!-- Delete Modal -->
<div class="modal fade modal-danger text-left" id="profileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel"></h5>
            </div>
            <form action="{{ route('user.profile', [auth()->user()->id]) }}" method="post" class="js_profile_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="name">F.I.O</label>
                            <input type="text" class="form-control js_name" id="name" name="name" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}">
                            <div class="invalid-feedback">F.I.O ni kiriting!</div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="username">Login</label>
                            <input type="text" class="form-control js_username" name="username" aria-label="username" value="{{ \Illuminate\Support\Facades\Auth::user()->username }}">
                            <div class="invalid-feedback">Malumotni kiriting!</div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="password">Parol</label>
                            <input type="text" class="form-control js_password" name="password" aria-label="password">
                            <div class="invalid-feedback">Malumotni kiriting!</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Jo'natish</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
</div>
