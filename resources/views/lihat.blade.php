@extends('layouts.app')

@section('title', 'Lihat File')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 mb-6 text-sm">
        <a href="/beranda/{{ auth()->id() }}" class="text-[#64748b] hover:text-[#2563eb] transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-[#cbd5e1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#0f172a] font-medium truncate max-w-xs">{{ $file->nama_tampilan }}</span>
    </nav>

    {{-- File Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-[#eff6ff] rounded-lg flex items-center justify-center text-[#2563eb] border border-[#bfdbfe]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <h1 class="text-xl font-semibold text-[#0f172a] truncate max-w-sm">{{ $file->nama_tampilan }}</h1>
                <p class="text-sm text-[#64748b] mt-1">{{ $file->ukuran_format }} · Uploaded {{ $file->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="/download/{{ $file->id }}" class="px-4 py-2 bg-[#2563eb] hover:bg-[#1d4ed8] text-sm text-white font-medium rounded-lg transition-colors">
                Download
            </a>
            <a href="/hapus_file/{{ $file->id }}" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-sm text-red-600 font-medium rounded-lg transition-colors" onclick="return confirm('Hapus file ini?')">
                Hapus
            </a>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white border border-[#e2e8f0] rounded-lg overflow-hidden">
        <div class="px-6 py-3 border-b border-[#e2e8f0] flex items-center justify-between bg-[#f8fafc]">
            <span class="text-xs font-semibold text-[#64748b] uppercase tracking-wider">Preview Konten</span>
            <span class="text-xs text-[#94a3b8] font-mono">{{ strtoupper($extension) }}</span>
        </div>
        <div class="p-4 sm:p-8 flex justify-center">
            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                <img src="data:{{ $mime }};base64,{{ $base64 }}" alt="{{ $file->nama_tampilan }}" class="max-w-full h-auto rounded-lg border border-[#e2e8f0]">
            @elseif($extension == 'pdf')
                <iframe src="data:{{ $mime }};base64,{{ $base64 }}" class="w-full h-[600px] rounded-lg border border-[#e2e8f0]" frameborder="0"></iframe>
            @elseif(in_array($extension, ['mp4', 'webm']))
                <video controls class="max-w-full h-auto rounded-lg border border-[#e2e8f0]">
                    <source src="data:{{ $mime }};base64,{{ $base64 }}" type="{{ $mime }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <div class="w-full bg-[#f8fafc] border border-[#e2e8f0] rounded-lg p-6 text-sm text-[#475569] font-mono whitespace-pre-wrap break-all min-h-[300px]">
                    {{ base64_decode($base64) }}
                </div>
            @endif
        </div>
    </div>

@endsection