@extends('admin/core/main')
@extends('admin/core/navbar')
@extends('admin/core/footer')

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
    <link href="{{ asset('/vendor/date_picker/css/docs.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/date_picker/css/bootstrap-datepicker3.css') }}" rel="stylesheet">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/timepicker/jquery.timepicker.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/timepicker/documentation-assets/site.css') }}" />
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
                            <th scope="col">Unit Kerja</th>
                            <th scope="col">Email</th>
                            <th scope="col">keperluan</th>
                            <th scope="col">Host</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Pukul</th>
                            <th scope="col">Surat</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftar as $user)
                        @csrf
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->nama_pengaju }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->keperluan }}</td>
                        <td>{{ $user->host }}</td>
                        <td>{{ $user->tanggal }}</td>
                        <?php
                            list($masuk_hours, $masuk_minutes, $a) = explode(':', $user->jam_masuk);
                            list($keluar_hours, $keluar_minutes, $b) = explode(':', $user->jam_keluar);
                            $tanggal = date("d/m/Y", strtotime($user->tanggal));
                        ?>
                        <td>{{ $masuk_hours.':'.$masuk_minutes }} - {{ $keluar_hours.':'.$keluar_minutes }}</td>
                        <td>
                            @if ($user->file_rekap != null)
                                <a href="{{ url('file_rekap/'.$user->file_rekap) }}" download>
                                    <i data-feather="file"></i>
                                </a>
                            @else
                                <i data-feather="file"></i>
                            @endif
                        </td>
                        <td>
                            @if ($user->konfirmasi == 1)
                                <span class="badge bg-success">Sudah dikonfirmasi</span>
                            @elseif ($user->konfirmasi == 0)
                                <span class="badge bg-warning">Belum dikonfirmasi</span>
                            @else
                               <span class="badge bg-danger">Konfirmasi ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->konfirmasi != 1)
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
                                    <input class="form-control" type="text" id="tanggal_{{ $loop->iteration }}" name="tanggal" placeholder="dd/mm/yyyy" value="{{ $tanggal }}" onchange="beforeinputJam({{ $loop->iteration }})" required>
                                    </div>

                                    <label>*Pukul: </label>
                                    <div id="timePicker_{{ $loop->iteration }}" class="form-group" style="text-align: -webkit-center;">
                                        <input type="text" style="text-align: -webkit-center;" class="time start ui-timepicker-input" id="jam_masuk_{{ $loop->iteration }}" name="jam_masuk" value="{{ $masuk_hours.':'.$masuk_minutes }}" autocomplete="off"  readonly required> -
                                        <input type="text" style="text-align: -webkit-center;" class="time end ui-timepicker-input" id="jam_keluar_{{ $loop->iteration }}" name="jam_keluar" value="{{ $keluar_hours.':'.$keluar_minutes }}" autocomplete="off" readonly required>
                                    </div>

                                    <label>Rekap E-Office: </label>
                                    <div  class="form-group">
                                        <input type="file" class="form-control" name="file" id="file_{{ $loop->iteration }}" placeholder="Masukkan rekap surat e-office" onchange="AlertFilesize(this.id,10000,'KB', '{{ $loop->iteration }}' )">
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
                    <h4 class="modal-title" id="modal_add">Add penjadwalan </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                    </div>

                    {{-- form --}}
                    <form id='tembah_penjadwalan'>
                        <div class="modal-body">
                            <label>*Nama Unit Kerja: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama unit kerja" class="form-control" name="nama_pengaju" required>
                            </div>

                            <label>*Email: </label>
                            <div class="form-group">
                                <input type="email" placeholder="Email Address" class="form-control" name="email" required>
                            </div>

                            <label>*Keperluan: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Acara / Kegiatan" class="form-control" name="keperluan" required>
                            </div>

                            <label>*Host: </label>
                            <div class="form-group">
                                <select class="form-select" name="host" required>
                                    <option value="PIPS">PIPS</option>
                                    <option value="Pribadi">Pribadi</option>
                                </select>
                            </div>

                            <label>*Tanggal: </label>
                            <div class="form-group">
                            <input class="form-control" type="text" id="tanggal_" name="tanggal" placeholder="dd/mm/yyyy" onchange="beforeinputJam('')" required>
                            </div>

                            <label>*Pukul: </label>
                            <div id="timePicker_" class="form-group" style="text-align: -webkit-center;">
                                <input type="text" style="text-align: -webkit-center;" class="time start ui-timepicker-input" id="jam_masuk_" name="jam_masuk" autocomplete="off"  readonly required> -
                                <input type="text" style="text-align: -webkit-center;" class="time end ui-timepicker-input" id="jam_keluar_" name="jam_keluar" autocomplete="off" readonly required>
                            </div>

                            <label>Rekap E-Office: </label>
                            <div  class="form-group">
                                <input type="file" class="form-control" name="file" id="file_" placeholder="Masukkan rekap surat e-office" onchange="AlertFilesize(this.id,10000,'KB', '' )" required>
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
    <script src="{{ asset('/vendor/date_picker/js/bootstrap-datepicker.js') }}"></script>
	<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.id.min.js" charset="UTF-8"></script>
<!--===============================================================================================-->
    <script type="text/javascript" src="{{ asset('/vendor/timepicker/jquery.timepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/vendor/timepicker/documentation-assets/site.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/vendor/timepicker/Datepair.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/vendor/timepicker/jquery.datepair.js') }}"></script>
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
                    text: 'Tambah penjadwalan',
                    action: function ( e, dt, node, config ) {
                        beforeinputDate('');
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
    $('#timePicker_ .time').timepicker({
		'minTime': '8:00',
		'maxTime': '18:00',
		'timeFormat': 'H:i',
	});

    /* Function date-picker and time-picker */
	function beforeinputJam(id){
		var tanggal = $("#tanggal_"+id).val();
		var tanggal_split = tanggal.split("/");
		var tanggal_db = tanggal_split[2]+'-'+tanggal_split[1]+'-'+tanggal_split[0];
		var token = $('meta[name="csrf-token"]').attr('content');
		var array = [];

		$("#jam_masuk_"+id).prop('readonly', false);
		$("#jam_keluar_"+id).prop('readonly', false);
        $("#jam_masuk_"+id).val('');
		$("#jam_keluar_"+id).val('');
        
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': token
			},
			url: "{{ url('/Ketersediaan') }}",
			type: "GET",
			data: {
					tanggal : tanggal_db
				},
			async : false,
			dataType : 'json',
			//jika ajax sukses
			success: function(data){
				//console.log(data);
				$('#timePicker_'+id+' .time').timepicker('remove').timepicker({
					 'minTime': '8:00',
					 'maxTime': '18:00',
					 'timeFormat': 'H:i',
					 'disableTimeRanges' : data,
				});
                var timePickerEl = document.getElementById('timePicker_'+id);
	            var timeDatepair = new Datepair(timePickerEl);
			}
		});

	}

	function beforeinputDate(id) {
		var num=1;
		var toolip, tanggal_split, tanggal_datepicker = '';
		var tanggal = [];
		var tanggal_disabled = [];
		var token = $('meta[name="csrf-token"]').attr('content');
        $('#tanggal_').val('');
        
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': token
			},
			url: "{{ url('/Tanggal') }}",
			type: "GET",
			data: {
				},
			async : false,
			dataType : 'json',
			//jika ajax sukses
			success: function(data){
				for(i=0; i<data.tanggal.length; i++){
				    
					tanggal.push(data.tanggal[i].tanggal);
					
					if(data.tanggal[i].count_tanggal > 1){
					    tanggal_split = data.tanggal[i].tanggal.split("-");
    		            tanggal_datepicker = tanggal_split[2]+'/'+tanggal_split[1]+'/'+tanggal_split[0];
    		            tanggal_disabled.push(tanggal_datepicker);   
					}
				}

				$("#tanggal_"+id).datepicker('destroy').datepicker({
					format: "dd/mm/yyyy",
					language: "id",
					startDate: new Date(),
					todayHighlight: true,
					//autoclose: true,
					beforeShowDay: function(date) {
						dmy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
						if (~tanggal.indexOf(dmy)) {
							toolip = data.jam[num];
							num++;
							return {
								classes: 'highlighted', 
								tooltip: toolip
								};
						}
					},
					datesDisabled: tanggal_disabled,
				});
			}
		});
	}
    /* Function date-picker and time-picker End */

    /* validasi file size dan extension */
	function AlertFilesize(cid,sz,a,id){
        var controllerID = cid;
        var fileSize = sz;
        var extation = a;
        if(window.ActiveXObject){
            var fso = new ActiveXObject("Scripting.FileSystemObject");
            var filepath = document.getElementById('file_'+id).value;
            var thefile = fso.getFile(filepath);
            var sizeinbytes = thefile.size;
        }else{
            var sizeinbytes = document.getElementById('file_'+id).files[0].size;
        }
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
        fSize = sizeinbytes; i=0;while(fSize>900){fSize/=1024;i++;}
        var fup = document.getElementById('file_'+id);
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        if(ext == "pdf" || ext == "PDF")
        {   
            var fs = Math.round(fSize);
            if(fs < fileSize && fSExt[i] == extation)
            {
                return true;
            }else{
                alert("silahkan masukkan file kurang dari "+fileSize+extation);
                document.getElementById('file_'+id).value='';
                return false;
            }
        }else{
        alert("silahkan masukkan file pdf");
        document.getElementById('file_'+id).value='';
        return false;
        }
    }
    /* validasi file size dan extension End */

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