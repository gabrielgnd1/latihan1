<!DOCTYPE html>
<html>
<head>
    <title>Kategori</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
    <h2>Daftar Kategori</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Hitung</th>
        </tr>
        @foreach($dataKats as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->nama }}</td>
            <td><a href="#" onclick="$.get('/hitung-barang/{{$item->id}}',d=>$(this).text(d.count));return false">Hitung</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
    </script>
</body>
</html>