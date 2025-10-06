<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
        </tr>
        @foreach($dataKats as $key => $item)
        <tr>
            <td>{{($key+1)}}</td>
            <td>{{$item->nama}}</td>
        </tr>
        @endforeach
</body>
</html>