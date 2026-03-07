@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-[#0f172a]">Beranda</h1>
            <p class="text-sm text-[#64748b] mt-1">Kelola file dan folder Anda</p>
        </div>

        {{-- Search --}}
        <form action="/pencarian" class="flex gap-2">
            <input name="cari" placeholder="Cari file atau folder..." type="text"
                class="px-3 py-2 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors w-full sm:w-64">
            <button class="px-4 py-2 bg-[#f1f5f9] hover:bg-[#e2e8f0] text-sm text-[#0f172a] rounded-lg transition-colors flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    {{-- Search Results --}}
    @if (isset($folders) && isset($files) && ($folders->count() || $files->count()))
    <div class="mb-6">
        <h2 class="text-sm font-medium text-[#64748b] mb-3">Hasil Pencarian</h2>
        <div class="space-y-2">
            @foreach ($folders as $isi_folder)
                <div class="flex items-center justify-between px-4 py-3 bg-white border border-[#e2e8f0] rounded-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#f59e0b]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                        </svg>
                        <span class="text-sm text-[#0f172a]">{{ $isi_folder->nama_folder }}</span>
                    </div>
                    <a href="/hapus_folder/{{ $isi_folder->id }}" class="text-xs text-red-500 hover:text-red-600 transition-colors">Hapus</a>
                </div>
            @endforeach

            @foreach ($files as $isi_file)
                <div class="flex items-center justify-between px-4 py-3 bg-white border border-[#e2e8f0] rounded-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#2563eb]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-[#0f172a]">{{ $isi_file->nama_tampilan }}</span>
                    </div>
                    <a href="/hapus/{{ $isi_file->id }}" class="text-xs text-red-500 hover:text-red-600 transition-colors">Hapus</a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(isset($folders) && isset($files) && $files->isEmpty() && $folders->isEmpty())
        <div class="mb-6 px-4 py-3 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#64748b] text-center">
            Data tidak ditemukan
        </div>
    @endif

    @if (isset($status_rename))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-600">
            {{ $status_rename }}
        </div>
    @endif

    {{-- Action Buttons (Desktop Only) --}}
    <div class="hidden lg:flex flex-wrap items-center justify-between gap-4 mb-8 bg-white p-4 rounded-lg border border-[#e2e8f0]">
        <div class="flex items-center gap-4">
            {{-- Upload File --}}
            <form action="/upload" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $current_folder->id ?? '' }}">
                <label class="cursor-pointer px-4 py-2 bg-[#2563eb] hover:bg-[#1d4ed8] text-sm font-medium text-white rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                    </svg>
                    Upload File
                    <input type="file" name="upload" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <div class="h-8 w-px bg-[#e2e8f0]"></div>

            {{-- New Folder --}}
            <form action="/folder" method="POST" class="flex items-center gap-3">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $current_folder->id ?? '' }}">
                <input type="text" name="nama" placeholder="Nama folder..." required
                    class="px-3 py-2 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] focus:outline-none focus:border-[#2563eb] transition-colors w-48">
                <button type="submit" class="px-4 py-2 bg-[#f1f5f9] hover:bg-[#e2e8f0] text-sm font-medium text-[#0f172a] rounded-lg transition-colors flex items-center gap-2 border border-[#e2e8f0]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Folder
                </button>
            </form>
        </div>

        <div class="flex items-center gap-2 text-[#94a3b8]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <span class="text-xs font-medium">Drag & Drop di sini</span>
        </div>
    </div>

    {{-- Mobile Version of Action Buttons --}}
    <div class="lg:hidden mb-6">
        <form action="/folder" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $current_folder->id ?? '' }}">
            <input type="text" name="nama" placeholder="Tambah folder baru..." required
                class="flex-1 px-4 py-3 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] focus:outline-none focus:border-[#2563eb] transition-colors">
            <button type="submit" class="p-3 bg-[#f1f5f9] text-[#2563eb] rounded-lg border border-[#e2e8f0]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </button>
        </form>
    </div>

    {{-- Folders Section --}}
    @if($folders->count())
    <div class="mb-8">
        <h2 class="text-xs font-semibold text-[#64748b] uppercase tracking-wider mb-4">Folder</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($folders as $folder)
            <div class="group bg-white border border-[#e2e8f0] rounded-lg p-4 hover:border-[#2563eb] transition-colors">
                <div class="flex items-start justify-between mb-3">
                    <a href="{{ route('folder.show', $folder->id) }}" class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 bg-[#fffbeb] rounded-lg flex items-center justify-center text-[#f59e0b]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-[#0f172a] truncate group-hover:text-[#2563eb] transition-colors">{{ $folder->nama_folder }}</p>
                            <p class="text-xs text-[#94a3b8]">{{ $folder->created_at->format('d M Y') }}</p>
                        </div>
                    </a>
                </div>
                <div class="flex items-center justify-end gap-1 pt-3 border-t border-[#f1f5f9]">
                    <a href="/rename_folder/{{ $folder->id }}" class="p-1.5 text-[#94a3b8] hover:text-[#2563eb] transition-colors" title="Rename">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <a href="/permissions_folder/{{ $folder->id }}" class="p-1.5 text-[#94a3b8] hover:text-[#2563eb] transition-colors" title="Izin">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </a>
                    <a href="/hapus_folder/{{ $folder->id }}" class="p-1.5 text-[#94a3b8] hover:text-red-500 transition-colors" title="Hapus" onclick="return confirm('Hapus folder ini?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Files Section --}}
    @if($files->count())
    <div>
        <h2 class="text-xs font-semibold text-[#64748b] uppercase tracking-wider mb-4">File</h2>
        <div class="bg-white border border-[#e2e8f0] rounded-lg overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f8fafc] text-[#64748b] text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-medium">Nama File</th>
                        <th class="px-6 py-3 font-medium hidden sm:table-cell">Ukuran</th>
                        <th class="px-6 py-3 font-medium hidden md:table-cell">Tgl Upload</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @foreach ($files as $file)
                    <tr class="hover:bg-[#f8fafc] transition-colors">
                        <td class="px-6 py-4">
                            <a href="/open_file/{{ $file->id }}" class="flex items-center gap-3 group">
                                @php
                                    $ext = strtolower(pathinfo($file->nama_tampilan, PATHINFO_EXTENSION));
                                @endphp
                                <div class="w-8 h-8 bg-[#f1f5f9] rounded-lg flex items-center justify-center
                                    @if(in_array($ext, ['jpg','jpeg','png','gif','svg','webp'])) text-[#8b5cf6]
                                    @elseif(in_array($ext, ['mp4','webm','mov','avi'])) text-[#f59e0b]
                                    @elseif($ext === 'pdf') text-[#ef4444]
                                    @else text-[#2563eb]
                                    @endif">
                                    @if(in_array($ext, ['jpg','jpeg','png','gif','svg','webp']))
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @elseif(in_array($ext, ['mp4','webm','mov','avi']))
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    @elseif($ext === 'pdf')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-[#0f172a] group-hover:text-[#2563eb] transition-colors truncate max-w-[150px] sm:max-w-xs">{{ $file->nama_tampilan }}</span>
                            </a>
                        </td>
                        <td class="px-6 py-4 text-[#64748b] hidden sm:table-cell">{{ $file->ukuran_format }}</td>
                        <td class="px-6 py-4 text-[#64748b] hidden md:table-cell">{{ $file->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="/rename_file/{{ $file->id }}" class="text-[#94a3b8] hover:text-[#2563eb] transition-colors" title="Rename">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="/permissions_file/{{ $file->id }}" class="text-[#94a3b8] hover:text-[#2563eb] transition-colors" title="Izin">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </a>
                                <a href="/download/{{ $file->id }}" class="text-[#94a3b8] hover:text-green-600 transition-colors" title="Download">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                                <a href="/hapus_file/{{ $file->id }}" class="text-[#94a3b8] hover:text-red-500 transition-colors" title="Hapus" onclick="return confirm('Hapus file ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if(!$folders->count() && !$files->count())
    <div class="flex flex-col items-center justify-center py-20 bg-white border border-[#e2e8f0] rounded-lg text-center">
        <div class="w-14 h-14 bg-[#f1f5f9] rounded-lg flex items-center justify-center mb-4">
            <svg class="w-7 h-7 text-[#94a3b8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <h3 class="text-[#0f172a] font-medium mb-1">Penyimpanan Kosong</h3>
        <p class="text-sm text-[#64748b]">Belum ada file atau folder di sini.</p>
    </div>
    @endif

@endsection