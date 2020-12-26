<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title> Panel Admin </title>
  </head>
  <body>
      
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1>Pendaftar</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">keperluan</th>
                            <th scope="col">Host</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Pukul</th>
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
                                ?>
                                <td>{{ $masuk_hours.':'.$masuk_minutes }} - {{ $keluar_hours.':'.$keluar_minutes }}</td>
                                <td>
                                    @if ($user->konfirmasi == 0)
                                    <button class="badge badge-success" onclick="konfirmasi({{ $user->id }})">konfirmasi</button>
                                    @endif
                                </td>
                            </tr>
                            
                            @endforeach
                    </tbody>
                </table>
                    <div class="alert alert-success" role="alert" style="display: none;" id="alert">
                        Data Berhasil ditambahkan
                    </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <!--===============================================================================================-->
	    <script src="{{ asset('/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('/vendor/bootstrap/js/popper.js') }}"></script>
        <script src="{{ asset('/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('/js/main.js') }}"></script>
    <!--===============================================================================================-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        function konfirmasi(id){
            var token = $("[name='_token']").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: "{{ url('/Send_notif') }}",
                type: "POST",
                data: {
                        id: id
                    },
                async : false,
                dataType : 'json',
                //jika ajax sukses
                success: function(data){
                    swal.fire({
                    title:"Berhasil Konfirmasi Pendaftaran",
                    html: "notifikasi telah dikirim pada email <br>"+data,
                    icon: "success"
                    }).then((result) => {
                        if (result.value) {
                            window.location="{{ url('/Akses_Admin') }}";
                        }
                    })
                },
            });
        }
    </script>
  </body>
</html>