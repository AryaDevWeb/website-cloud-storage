@extends('layouts.app')

@section('title', 'Rename Folder')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 mb-6 text-sm">
        <a href="/beranda/{{ auth()->id() }}" class="text-[#64748b] hover:text-[#2563eb] transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-[#cbd5e1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#0f172a] font-medium">Rename Folder</span>
    </nav>

    <div class="max-w-lg mx-auto lg:mx-0">
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6">
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-[#e2e8f0]">
                <div class="w-11 h-11 bg-[#fffbeb] rounded-lg flex items-center justify-center text-[#f59e0b] border border-[#fef3c7]">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-base font-semibold text-[#0f172a]">Rename Folder</h1>
                    <p class="text-xs text-[#64748b] mt-0.5 truncate">{{ $cari_folder->nama_folder }}</p>
                </div>
            </div>

            <form action="/rename_f/{{ $cari_folder->id }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="rename" class="block text-xs font-semibold text-[#64748b] uppercase tracking-wider mb-2">Nama Baru</label>
                    <input type="text" name="rename" id="rename" value="{{ $cari_folder->nama_folder }}" required
                        class="w-full px-4 py-3 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] focus:outline-none focus:border-[#2563eb] transition-colors placeholder-[#94a3b8]">
                    <p class="text-xs text-[#94a3b8] mt-2">Nama folder akan otomatis diformat menjadi slug.</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-[#2563eb] hover:bg-[#1d4ed8] text-white text-sm font-medium rounded-lg transition-colors">
                        Simpan Perubahan
                    </button>
                    <a href="{{ url()->previous() }}" class="block w-full text-center py-3 mt-2 text-sm text-[#64748b] hover:text-[#0f172a] transition-colors">
                        Batal
                    </a>
                </div>
            </form>

            @if(session('status'))
                <div class="mt-4 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-xs text-green-600">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

@endsection