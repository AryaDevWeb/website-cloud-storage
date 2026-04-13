<<<<<<< HEAD
@php
  $pageTitle = 'Recent Files';
  $pageDesc  = "Files you've recently uploaded or accessed";
  $section   = 'recent';
  $emptyTitle = 'No recent files';
  $emptyDesc  = 'Upload your first file to see it here.';
  $emptyIcon  = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>';
@endphp
@include('file_explorer')
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent</title>
</head>
<body>

    @foreach ($file as $file_terbaru )
        <p>Nama: {{ $file_terbaru->nama_tampilan }}</p>
        <p>Tanggal: {{ \Carbon\Carbon::parse($file_terbaru->riwayat)->diffForHumans() }}</p>    
    @endforeach
    
</body>
</html>
>>>>>>> fcda812ca39614fe3dae046315c4083724966d22
