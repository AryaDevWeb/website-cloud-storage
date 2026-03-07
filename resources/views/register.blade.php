@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    @isset($pesan)
        <div class="mb-4 px-4 py-3 bg-[#eff6ff] border border-[#bfdbfe] rounded-lg text-sm text-[#2563eb]">
            {{ $pesan }}
        </div>
    @endisset

    <h2 class="text-lg font-semibold text-[#0f172a] mb-6">Buat Akun Baru</h2>

    <form action="/register" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-[#64748b] mb-1.5">Nama</label>
            <input name="nama" placeholder="Nama lengkap" type="text"
                class="w-full px-3 py-2.5 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors">
        </div>
        <div>
            <label class="block text-sm text-[#64748b] mb-1.5">Email</label>
            <input name="email" placeholder="nama@email.com" type="email"
                class="w-full px-3 py-2.5 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors">
        </div>
        <div>
            <label class="block text-sm text-[#64748b] mb-1.5">Password</label>
            <input name="password" placeholder="Minimal 8 karakter" type="password"
                class="w-full px-3 py-2.5 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors">
        </div>
        <div>
            <label class="block text-sm text-[#64748b] mb-1.5">Konfirmasi Password</label>
            <input name="password_confirmation" placeholder="Ulangi password" type="password"
                class="w-full px-3 py-2.5 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors">
        </div>
        <button type="submit"
            class="w-full py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white text-sm font-medium rounded-lg transition-colors">
            Register
        </button>
    </form>

    <div class="mt-5 pt-5 border-t border-[#e2e8f0] text-center">
        <p class="text-sm text-[#64748b]">Sudah punya akun?</p>
        <a href="/login" class="inline-block mt-2 text-sm text-[#2563eb] hover:text-[#1d4ed8] transition-colors font-medium">
            Login Sekarang
        </a>
    </div>

    @if(session('status'))
        <p class="mt-3 text-sm text-green-600">{{ session('status') }}</p>
    @endif

    @error('email')
        <p class="mt-3 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @error('password')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @error('nama')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
@endsection