@extends('core/main')
@extends('core/navbar')
@extends('core/footer')

@section('title', 'Kelola User - Admin Panel')
@section('page-title', 'Kelola User')
@section('page-subtitle', '')

@section('css')
<!--===============================================================================================-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!--===============================================================================================-->
    <link href="{{ asset('/vendors/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<!--===============================================================================================-->
@endsection



@section('konten')

    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table class='table table-striped' id="tabel">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                            <th scope="col">hwid</th>
                            <th scope="col">owner</th>
                            <th scope="col">sisa hari</th>
                            <th scope="col">tgl input</th>
                            <th scope="col">expired</th>
                            <th scope="col">status</th>
                            <th scope="col">edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftar as $user)
                        @csrf
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->hwid }}</td>
                        <td>{{ $user->owner }}</td>
                        <td>
                            {{ 
                                Carbon\Carbon::now()->diffInDays($user->expired_date, false)>0 ? 
                                Carbon\Carbon::now()->diffInDays($user->expired_date, false) : 0
                            }}
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->expired_date }}</td>
                        <td>{{ $user->status == 1 ? 'Aktif':'Nonaktif' }}</td>
                        <td>
                            @if ($user->status != 1)
                                <a class="btn btn-sm btn-success" data-toggle="tooltip" data-title="Detail Transaksi" href="javascript:void(0)" onclick="change_status({{ $user->id }}, 1)"><i data-feather="check-circle" width="20"></i></a> 
                            @else
                                <a class="btn btn-sm btn-danger" data-toggle="tooltip" data-title="Detail Transaksi" href="javascript:void(0)" onclick="change_status({{ $user->id }}, 0)"><i data-feather="check-circle" width="20"></i></a> 
                            @endif

                            <a class="btn btn-sm btn-info" data-toggle="modal" href="#edit_data_{{ $loop->iteration }}"><i data-feather="edit" width="20"></i></a>

                        </td>

                    </tr>
                    
                    {{-- Modal button Edit --}}

                    <div class="modal fade text-left" id="edit_data_{{ $loop->iteration }}" tabindex="-1" role="dialog"
                        aria-labelledby="modal_edit" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal_edit">Edit penjadwalan </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                            </div>

                            {{-- form --}}
                            <form>
                                <div class="modal-body">
                                    <label>*HWID: </label>
                                    <div class="form-group">
                                        <input type="text" value="{{ $user->hwid }}" class="form-control" name="hwid" minlength="36" required>
                                        <input type="hidden" value="{{ $user->id }}" class="form-control" name="id" required>
                                    </div>
        
                                    <label>Owner: </label>
                                    <div class="form-group">
                                        <input type="text" value="{{ $user->owner }}" class="form-control" name="owner">
                                    </div>
        
                                    <label>*Server: </label>
                                    <div class="form-group">
                                        <select class="form-select" name="server_ao" required>
                                            {{-- hardcode --}}
                                            <option value="0">Semua</option>
                                            <option value="1">Kecuali Atlantica Indonisia</option>
                                        </select>
                                    </div>
        
                                    <label>*expired date: </label>
                                    <div class="form-group">
                                        <input type="datetime-local" value="{{ Carbon\Carbon::parse($user->expired_date)->format('Y-m-d\TH:i') }}" class="form-control" name="expired_date" required>
                                    </div>
        
                                    <label>Keterangan: </label>
                                    <div class="form-group">
                                        <input type="text" value="{{ $user->keterangan }}" class="form-control" name="keterangan">
                                    </div><br>
                                </div>
        
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

                    {{-- Modal button Edit End --}}


                    @endforeach
                </tbody>
            </table>

            {{-- Modal button Add --}}

            <div class="modal fade text-left" id="add_data" tabindex="-1" role="dialog"
                aria-labelledby="modal_add" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="modal_add">Tambah User </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                    </div>

                    {{-- form --}}
                    <form id='tambah_user'>
                        <div class="modal-body">
                            <label>---- USER ----</label><br><br>
                            <label>*HWID: </label>
                            <div class="form-group">
                                <input type="text" placeholder="HWID" class="form-control" name="hwid" minlength="36" id='tambah_hwid' required>
                            </div>

                            <label>Owner: </label>
                            <div class="form-group">
                                <input type="text" placeholder="owner" class="form-control" name="owner">
                            </div>

                            <label>*Server: </label>
                            <div class="form-group">
                                <select class="form-select" name="server_ao" required>
                                    {{-- hardcode --}}
                                    <option value="0">Semua</option>
                                    <option value="1">Kecuali Atlantica Indonisia</option>
                                </select>
                            </div>

                            <label>*Bulan: </label>
                            <div class="form-group">
                                <input type="number" placeholder="pendaftaran untuk berapa bulan" class="form-control" name="bulan" min=1 required>
                            </div>

                            <label>Keterangan: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Keterangan / Rekomendasi" class="form-control" name="keterangan">
                            </div><br>

                            <label>---- PEMBAYARAN ----</label><br><br>

                            <label>*Via: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Bank Mandiri/BCA/Ovo/dkk" class="form-control" name="via" required>
                            </div>
                            <label>*Atas Nama: </label>
                            <div class="form-group">
                                <select class="form-select" name="atas_nama" required>
                                    {{-- hardcode --}}
                                    <option value="zaenal">Zaenal</option>
                                    <option value="rizky">Rizky</option>
                                </select>
                            </div>
                        </div>

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

            {{-- Modal button Add End --}}

            {{-- Modal button Perpanjangan Bot --}}

            <div class="modal fade text-left" id="perpanjangan_bot" tabindex="-1" role="dialog"
                aria-labelledby="modal_add" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="modal_add">Tambah User </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                    </div>

                    {{-- form --}}
                    <form id='tembah_user'>
                        <div class="modal-body">
                            <label>---- USER ----</label><br><br>
                            <label>*HWID: </label>
                            <div class="form-group">
                                <select class="form-select" name="id" required>
                                    @foreach ($pendaftar as $user)
                                        <option value="{{$user->id}}">{{$user->hwid}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label>*Bulan: </label>
                            <div class="form-group">
                                <input type="number" placeholder="perpanjangan untuk berapa bulan" class="form-control" name="bulan" min=1 required>
                            </div><br>

                            <label>---- PEMBAYARAN ----</label><br><br>

                            <label>*Via: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Bank Mandiri/BCA/Ovo/dkk" class="form-control" name="via" required>
                            </div>
                            <label>*Atas Nama: </label>
                            <div class="form-group">
                                <select class="form-select" name="atas_nama" required>
                                    {{-- hardcode --}}
                                    <option value="zaenal">Zaenal</option>
                                    <option value="rizky">Rizky</option>
                                </select>
                            </div>
                        </div>

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

            {{-- Modal button Perpanjangan Bot End --}}

        </div>
    </div>
    
@endsection

@section('js_asset')
<!--===============================================================================================-->
    <script src="{{ asset('/vendors/datatables/jquery.dataTables.min.js') }}"></script>
    
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>

<!--===============================================================================================-->
    <script>
        $('#tabel').DataTable( {
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, 100 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows' ]
            ],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            buttons: [
                'pageLength',
                {
                    text: 'Tambah User',
                    action: function ( e, dt, node, config ) {
                        $('#add_data').modal('show');
                    }
                },
                {
                    text: 'Perpanjangan Bot',
                    action: function ( e, dt, node, config ) {
                        $('#perpanjangan_bot').modal('show');
                    }
                }
            ],
            responsive: true
        });
    </script>
<!--===============================================================================================-->

@endsection

@section('js_script')
<script>

    /* Send Form Add */
    $( "form" ).on( "submit", function( e ) {
		e.preventDefault();
        var valid=true;
        var token = $('meta[name="csrf-token"]').attr('content');
		//generalisasi form agar data file bisa masuk
		var form = $(this)[0];
        if($('#tambah_hwid').val() != ''){
            var url = "{{ url('/add_users') }}";
            var status = 'tambah';
        }else{
            var url = "{{ url('/update_users') }}";
            var status = 'ubah';
        }
		//mengambil semua data di dalam form
		var formData = new FormData(form);
		//fitur swal
		$(this).find('.textbox').each(function(){
			if (! $(this).val()){
				get_error_text(this);
				valid = false;
				$('html,body').animate({scrollTop: 0},"slow");
			} 
			if ($(this).hasClass('no-valid')){
				valid = false;
				$('html,body').animate({scrollTop: 0},"slow");
			}
		});
		if (valid){
			Swal.fire({
				title: 'Konfirmasi simpan data',
				text: "Data akan di simpan ke database",
				icon: 'info',
				showCancelButton: true,
				confirmButtonColor: "#1da1f2",
				confirmButtonText: "Yakin, dong!",
				cancelButtonColor: '#d33',
				closeOnConfirm: false,
				showLoaderOnConfirm: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
						url: url,
						type: "POST",
						data: formData,
						dataType: "html",
						contentType: false,
						processData: false,
						//jika ajax sukses
						success: function(data){
                            location.reload();
						},
						//jika ajax gagal
						error: function () {
                            if(status == 'tambah'){
                                swal.fire("Error", "HWID Telah Digunakan", "error");
                            }else{
                                swal.fire("Error", "Periksa koneksi anda", "error");
                            }
						}
					});
				}
			})
		}
    });
    /* Send Form End */
    
    /* Change Status Start */
    function change_status(id,status){
        let token = $('meta[name="csrf-token"]').attr('content');
        let status_success = status == 1 ? 'aktif' : 'Nonaktif';
        Swal.fire({
            title: 'Konfirmasi perubahan status',
            text: "status akan dirubah menjadi "+status_success,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: "#1da1f2",
            confirmButtonText: "Yakin, dong!",
            cancelButtonColor: '#d33',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: "{{ url('/update_users') }}",
                    type: "POST",
                    data: {
                            id: id,
                            status: status,
                        },
                    async : false,
                    dataType : 'json',
                    //jika ajax sukses
                    success: function(data){
                        swal.fire({
                            title: 'Status berhasil dirubah',
                            text: "Status user sekarang "+status_success,
                            icon: "success"
                            }).then((result) => {
                                location.reload();
                        })
                    },
                    //jika ajax gagal
                    error: function () {
                        swal.fire("Error", "Periksa koneksi anda", "error");
                    }
                });
            }
        })
    }
    /* Change Status End */
</script>
@endsection