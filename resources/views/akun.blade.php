@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')

    <div class="max-w-2xl mx-auto lg:mx-0">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-[#0f172a]">Profil Akun</h1>
            <p class="text-sm text-[#64748b] mt-1">Informasi akun dan pengaturan keamanan.</p>
        </div>

        @if(isset($lihat_akun))
        <div class="space-y-6">
            {{-- User Info Card --}}
            <div class="bg-white border border-[#e2e8f0] rounded-lg p-8">
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="w-16 h-16 bg-[#2563eb] rounded-lg flex items-center justify-center text-white text-2xl font-semibold">
                        {{ strtoupper(substr($lihat_akun->name, 0, 1)) }}
                    </div>
                    <div class="text-center sm:text-left">
                        <h2 class="text-xl font-semibold text-[#0f172a]">{{ $lihat_akun->name }}</h2>
                        <div class="flex items-center gap-2 mt-3 text-[#64748b]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs">Bergabung sejak {{ $lihat_akun->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-[#e2e8f0]">
                    <div class="p-4 bg-[#f8fafc] rounded-lg border border-[#e2e8f0]">
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-medium mb-1">Total File</p>
                        <p class="text-lg font-semibold text-[#0f172a]">{{ $lihat_akun->galleries->count() }}</p>
                    </div>
                    <div class="p-4 bg-[#f8fafc] rounded-lg border border-[#e2e8f0]">
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-medium mb-1">Total Folder</p>
                        <p class="text-lg font-semibold text-[#0f172a]">{{ $lihat_akun->folders->count() }}</p>
                    </div>
                </div>

                {{-- Storage --}}
                <div class="mt-6 p-4 bg-[#eff6ff] rounded-lg border border-[#bfdbfe]">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <p class="text-xs text-[#2563eb] uppercase tracking-wider font-medium">Penggunaan Penyimpanan</p>
                            <p class="text-lg font-semibold text-[#0f172a] mt-1">{{ number_format($lihat_akun->storage_used / 1024 / 1024, 2) }} <span class="text-sm font-normal text-[#64748b]">MB digunakan</span></p>
                        </div>
                        <p class="text-xs font-medium text-[#64748b]">{{ number_format(($lihat_akun->storage_quota - $lihat_akun->storage_used) / 1024 / 1024, 1) }} MB Tersisa</p>
                    </div>
                    <div class="h-2 w-full bg-[#bfdbfe] rounded-full overflow-hidden">
                        @php
                            $percentage = ($lihat_akun->storage_used / $lihat_akun->storage_quota) * 100;
                        @endphp
                        <div class="h-full bg-[#2563eb] rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white border border-[#e2e8f0] rounded-lg p-6 space-y-3">
                <h3 class="text-sm font-semibold text-[#0f172a] mb-4 px-2">Aksi Pengguna</h3>
                <a href="/beranda/{{ auth()->id() }}"
                    class="flex items-center justify-between w-full px-4 py-3 bg-[#f8fafc] hover:bg-[#f1f5f9] rounded-lg text-sm text-[#0f172a] transition-colors group border border-[#e2e8f0]">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#64748b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-2 0h2"/>
                        </svg>
                        Kembali ke Dashboard
                    </div>
                    <svg class="w-4 h-4 text-[#94a3b8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-between w-full px-4 py-3 bg-[#f8fafc] hover:bg-orange-50 hover:text-orange-600 rounded-lg text-sm text-[#0f172a] transition-colors group border border-[#e2e8f0]">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#64748b] group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar dari Sesi
                        </div>
                    </button>
                </form>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-center gap-2 text-red-600 mb-4 px-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Zona Bahaya</h3>
                </div>
                <div class="px-2">
                    <p class="text-xs text-[#64748b] leading-relaxed mb-6">Menghapus akun Anda akan menghapus semua file dan data secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                    <a href="/hapus_akun/{{ auth()->id() }}" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Akun Selamanya
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection