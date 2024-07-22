<!-- Modal -->
<div class="modal fade text-left static" id="elonModal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">E'lon yuborishh</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('elon.store') }}" method="post" class="js_elon_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">Guruhlar</p>
                            <div class="check-list">
                                <div class="form-check check0">
                                    <input class="form-check-input jsCheckAll" type="checkbox" id="check0">
                                    <label class="form-check-label" for="check0">
                                        Barcha guruhlar
                                    </label>
                                </div>
                                @foreach($groups as $g)
                                    <div class="form-check">
                                        <input class="form-check-input jsCheckOne" type="checkbox" name="group[]" value="{{ $g->id }}" id="check{{ $g->id }}">
                                        <label class="form-check-label" for="check{{ $g->id }}">
                                            {{ $g->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="text" class="form-label mb-0">Text</label>
                            <textarea class="form-control" name="message" id="text" rows="12"></textarea>
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

