<html>
<head>
    <title>Daftar Kategori</title>
</head>
<body>
    <h1>Daftar Kategori</h1>
    <table border="1" style="border-color: red;">
        <tr>
            <th>Nama</th>
        </tr>
        @foreach ($dataKats as $key => $item)
            <tr>
                <td>{{ $item->name }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>