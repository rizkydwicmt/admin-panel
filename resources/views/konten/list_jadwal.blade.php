@extends('admin/core/main')
@extends('admin/core/navbar')
@extends('admin/core/footer')

@section('title', 'List Penjadwalan - Admin Panel Pengajuan Webinar')
@section('page-title', 'List Penjadwalan')
@section('page-subtitle', 'Ini adalah list penjadwalan webinar')

@section('css')
<!--===============================================================================================-->
    <link href="{{ asset('/vendors/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
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
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@endsection

@section('js_asset')

    <!-- Datatable -->
    <script src="{{ asset('/vendors/datatables/jquery.dataTables.min.js') }}"></script>
    
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script>
        $('#tabel').DataTable( {
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, 100 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows' ]
            ],
            buttons: [
                'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
            ],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });
    </script>

@endsection

@section('js_script')
    
@endsection