{{-- Modal button Ganti Password --}}
<div class="modal fade text-left" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="modal_add">Ubah Password </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i data-feather="x">X</i>
            </button>
            </div>

            {{-- form --}}
            <form action='/akses_admin/change_password' method="post">
                @csrf
                <div class="modal-body">
                    <label>*Username: </label>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder='{{Session::get('username')}}' disabled>
                    </div>
                    <label>*Password Lama: </label>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_lama" required>
                    </div>
                    <label>*Password Baru: </label>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                @if(\Session::has('alert-danger'))
                    <div class="alert alert-danger">
                        <div>
                            {{Session::get('alert-danger')}}
                            {{Session::forget('alert-danger')}}
                        </div>
                    </div>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                </div>
            </form>
            {{-- form End --}}

        </div>
    </div>
</div>

{{-- Modal button Ganti Password End --}}