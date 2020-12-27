@extends('core/main')
@extends('core/navbar')
@extends('core/footer')

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
                            <th scope="col">hwid</th>
                            <th scope="col">operator</th>
                            <th scope="col">atas_nama</th>
                            <th scope="col">via</th>
                            <th scope="col">tanggal transaksi</th>
                            <th scope="col">status</th>
                            <th scope="col">detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $data)
                        @csrf
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $data->hwid }}</td>
                        <td>{{ $data->username }}</td>
                        <td>{{ $data->atas_nama }}</td>
                        <td>{{ $data->via }}</td>
                        <td>{{ $data->created_at }}</td>
                        <td>{{ $data->status == 1 ? 'Terbayar':'Dibatalkan' }}</td>
                        <td>detail</td>
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