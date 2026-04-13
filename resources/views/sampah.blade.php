<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Sampah</title>
</head>
<body>

    <h1>Tempat Sampah: </h1>
    @foreach ($file_sampah as $sampah )
        <button>{{ $sampah->nama_tampilan }}</button>
        <p>Tanggal: {{ $sampah->deleted_at->diffForHumans() }}</p>
    
    @endforeach


    
</body>
</html>