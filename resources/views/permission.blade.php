@extends('layouts.app')

@section('title', 'Perizinan File')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 mb-6 text-sm">
        <a href="/beranda/{{ auth()->id() }}" class="text-[#64748b] hover:text-[#2563eb] transition-colors">Beranda</a>
        <svg class="w-4 h-4 text-[#cbd5e1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#0f172a] font-medium">Perizinan File</span>
    </nav>

    <div class="max-w-lg mx-auto lg:mx-0">
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6">
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-[#e2e8f0]">
                <div class="w-11 h-11 bg-[#eff6ff] rounded-lg flex items-center justify-center text-[#2563eb] border border-[#bfdbfe]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-base font-semibold text-[#0f172a] truncate">{{ $isi_file->nama_tampilan }}</h1>
                    <p class="text-xs text-[#64748b] mt-0.5">
                        Status Saat Ini: 
                        <span class="px-2 py-0.5 rounded-full {{ $isi_file->izin == 1 ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }} font-medium">
                            {{ $isi_file->izin == 1 ? 'Public' : 'Private' }}
                        </span>
                    </p>
                </div>
            </div>

            <form action="/ubah_perizinan/{{ $isi_file->id }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-3">
                    <label class="relative flex items-center gap-4 px-5 py-4 bg-[#f8fafc] border border-[#e2e8f0] rounded-lg cursor-pointer hover:border-[#2563eb] transition-colors group">
                        <input type="radio" name="izin" value="0" {{ $isi_file->izin == 0 ? 'checked' : '' }}>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-[#0f172a] group-hover:text-[#2563eb] transition-colors">Private</p>
                            <p class="text-xs text-[#64748b]">Hanya Anda yang dapat melihat dan mendownload file ini.</p>
                        </div>
                    </label>

                    <label class="relative flex items-center gap-4 px-5 py-4 bg-[#f8fafc] border border-[#e2e8f0] rounded-lg cursor-pointer hover:border-[#2563eb] transition-colors group">
                        <input type="radio" name="izin" value="1" {{ $isi_file->izin == 1 ? 'checked' : '' }}>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-[#0f172a] group-hover:text-[#2563eb] transition-colors">Public</p>
                            <p class="text-xs text-[#64748b]">Siapa pun dengan link dapat melihat dan mendownload file ini.</p>
                        </div>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-[#2563eb] hover:bg-[#1d4ed8] text-white text-sm font-medium rounded-lg transition-colors">
                        Simpan Perubahan
                    </button>
                    <a href="{{ url()->previous() }}" class="block w-full text-center py-3 mt-2 text-sm text-[#64748b] hover:text-[#0f172a] transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection