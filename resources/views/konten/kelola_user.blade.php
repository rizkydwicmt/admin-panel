@extends('core/main')
@extends('core/navbar')
@extends('core/footer')

@section('title', 'List Penjadwalan - Admin Panel Pengajuan Webinar')
@section('page-title', 'Kelolah Penjadwalan')
@section('page-subtitle', 'Digunakan untuk mengelolah penjadwalan dari mengkonfirmasi sampai rescedule yang kemudian akan dikirimkan ke email')

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
                            <th scope="col">detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftar as $user)
                        @csrf
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->hwid }}</td>
                        <td>{{ $user->owner }}</td>
                        <td>{{ $user->keperluan }}</td>
                        <td>{{ $user->host }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->expired_date }}</td>
                        <td>{{ $user->status }}</td>
                        <td>
                            @if ($user->status != 1)
                                <a class="btn btn-sm btn-success" data-toggle="tooltip" data-title="Detail Transaksi" href="javascript:void(0)" onclick="konfirmasi({{ $user->id }}, 'konfirmasi', '1')"><i data-feather="check-circle" width="20"></i></a> 
                            @else
                                <a class="btn btn-sm disabled btn-light" data-toggle="tooltip" data-title="Detail Transaksi" href="javascript:void(0)"><i data-feather="check-circle" width="20"></i></a> 
                            @endif

                            <a class="btn btn-sm btn-info" data-toggle="modal" href="#edit_data_{{ $loop->iteration }}" onclick="beforeinputDate({{ $loop->iteration }})"><i data-feather="edit" width="20"></i></a>

                            @if ($user->konfirmasi != 1)
                            <a class="btn btn-sm btn-danger" data-toggle="tooltip" data-title="Detail Transaksi" href="javascript:void(0)" onclick="konfirmasi({{ $user->id }}, 'batalkan', '2')"><i data-feather="trash-2" width="20"></i></a> 
                            @else
                                <a class="btn btn-sm disabled btn-light" data-toggle="tooltip" data-title="Detail Transaksi" href="javascript:void(0)"><i data-feather="trash-2" width="20"></i></a> 
                            @endif

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
                                    <label>*Nama Unit Kerja: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Nama unit kerja" class="form-control" name="nama_pengaju" value="{{ $user->nama_pengaju }}" required>
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                    </div>

                                    <label>*Email: </label>
                                    <div class="form-group">
                                        <input type="email" placeholder="Email Address" class="form-control" name="email" value="{{ $user->email }}" required>
                                    </div>

                                    <label>*Keperluan: </label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Acara / Kegiatan" class="form-control" name="keperluan" value="{{ $user->keperluan }}" required>
                                    </div>

                                    <label>*Host: </label>
                                    <div class="form-group">
                                        <select class="form-select" name="host" required>
                                            <option value="PIPS" 
                                            @if ($user->host == 'PIPS')
                                                selected
                                            @endif >PIPS</option>
                                            <option value="Pribadi" 
                                            @if ($user->host == 'Pribadi')
                                                selected
                                            @endif >Pribadi</option>
                                        </select>
                                    </div>

                                    <label>*Tanggal: </label>
                                    <div class="form-group">
                                    <input class="form-control" type="date" name="tanggal" required>
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

                    {{-- Modal button Edit Edit --}}


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
                    <form id='tembah_user'>
                        <div class="modal-body">
                            <label>---- USER ----</label><br><br>
                            <label>*HWID: </label>
                            <div class="form-group">
                                <input type="text" placeholder="HWID" class="form-control" name="hwid" required>
                            </div>

                            <label>Owner: </label>
                            <div class="form-group">
                                <input type="text" placeholder="owner" class="form-control" name="owner">
                            </div>

                            <label>*Server: </label>
                            <div class="form-group">
                                <select class="form-select" name="server" required>
                                    <option value="0">Semua</option>
                                    <option value="1">Kecuali Atlantica Indonisia</option>
                                </select>
                            </div>

                            <label>*Bulan: </label>
                            <div class="form-group">
                                <input type="number" placeholder="pendaftaran untuk berapa bulan" class="form-control" name="bulan" required>
                            </div>

                            <label>Keterangan: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Keterangan / Rekomendasi" class="form-control" name="keterangan">
                            </div><br>

                            <label>---- PEMBAYARAN ----</label><br><br>

                            <label>*Via: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Bank Mandiri/BCA/Ovo/dkk" class="form-control" name="keterangan">
                            </div>
                            <label>*Atas Nama: </label>
                            <div class="form-group">
                                <select class="form-select" name="atas_nama" required>
                                    <option value="0">Zaenal</option>
                                    <option value="1">Rizky</option>
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

            {{-- Modal button Add Edit --}}

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
            columnDefs: [
                {
                    targets: 9,
                    className: 'dt-body-center'
                }
            ],
            buttons: [
                {
                    text: 'Tambah User',
                    action: function ( e, dt, node, config ) {
                        $('#add_data').modal('show');
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

    /* Send Form */
    $( "form" ).on( "submit", function( e ) {
		e.preventDefault();
        var valid=true;
        var token = $('meta[name="csrf-token"]').attr('content');
		//generalisasi form agar data file bisa masuk
		var form = $(this)[0];
        if($('#tanggal_').val() != ''){
            var url = "{{ url('/Confirmation') }}";
            var status = 'tambahkan';
        }else{
            var url = "{{ url('/Update_Users') }}";
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
                            swal.fire({
                            title:"Data berhasil di"+status,
                            text: "Apakah anda ingin memberitahu pengguna jika jadwal telah di"+status,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: "#1da1f2",
                            confirmButtonText: "Ya",
                            cancelButtonColor: '#d33',
                            cancelButtonText: "Tidak",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            }).then((result) => {
                                if (result.value) {
                                    id = data.replace(/"/g, '');
                                    konfirmasi(id, status, '');
                                }else{
                                    location.reload();
                                }
                            });
						},
						//jika ajax gagal
						error: function (xhr, ajaxOptions, thrownError) {
							setTimeout(function(){
								swal.fire("Error", "Periksa koneksi anda", "error");
							}, 2000);
						}
					});
				}
			})
		}
	});
    /* Send Form End */

    /* Send Email Approval */
    function konfirmasi(id, status, konfirmasi){
            var token = $('meta[name="csrf-token"]').attr('content');
            var title = 'penjadwalan berhasil di'+status;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: "{{ url('/Send_notif') }}",
                type: "POST",
                data: {
                        id: id,
                        status: status,
                        konfirmasi: konfirmasi
                    },
                async : false,
                dataType : 'json',
                //jika ajax sukses
                success: function(data){
                    swal.fire({
                    title: title,
                    html: "notifikasi telah dikirim pada email <br>"+data,
                    icon: "success"
                    }).then((result) => {
                        if (result.value) {
                            location.reload();
                        }
                    })
                },
            });
        }
    /* Send Email Approval End */

</script>
@endsection