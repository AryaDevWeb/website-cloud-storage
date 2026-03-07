@extends('layouts.app')

@section('title', 'Rename File')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 mb-6 text-sm">
        <a href="/beranda/{{ auth()->id() }}" class="text-[#64748b] hover:text-[#2563eb] transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-[#cbd5e1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#0f172a] font-medium">Rename File</span>
    </nav>

    <div class="max-w-lg mx-auto lg:mx-0">
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6">
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-[#e2e8f0]">
                <div class="w-11 h-11 bg-[#eff6ff] rounded-lg flex items-center justify-center text-[#2563eb] border border-[#bfdbfe]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-base font-semibold text-[#0f172a]">Rename File</h1>
                    <p class="text-xs text-[#64748b] mt-0.5 truncate">{{ $ubah_nama->nama_tampilan }}</p>
                </div>
            </div>

            <form action="/rename/{{ $ubah_nama->id }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="ubah_nama" class="block text-xs font-semibold text-[#64748b] uppercase tracking-wider mb-2">Nama Baru</label>
                    <input type="text" name="ubah_nama" id="ubah_nama" value="{{ $ubah_nama->nama_tampilan }}" required
                        class="w-full px-4 py-3 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] focus:outline-none focus:border-[#2563eb] transition-colors placeholder-[#94a3b8]">
                    <p class="text-xs text-[#94a3b8] mt-2">Nama akan otomatis diformat menjadi slug (contoh: nama_file_anda).</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-[#2563eb] hover:bg-[#1d4ed8] text-white text-sm font-medium rounded-lg transition-colors">
                        Simpan Nama Baru
                    </button>
                    <a href="{{ url()->previous() }}" class="block w-full text-center py-3 mt-2 text-sm text-[#64748b] hover:text-[#0f172a] transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection