@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h2 class="text-lg font-semibold text-[#0f172a] mb-6">Masuk ke Akun</h2>

    <form action="/masuk" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-[#64748b] mb-1.5">Email</label>
            <input name="email" placeholder="nama@email.com" type="email"
                class="w-full px-3 py-2.5 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors">
        </div>
        <div>
            <label class="block text-sm text-[#64748b] mb-1.5">Password</label>
            <input name="password" placeholder="••••••••" type="password"
                class="w-full px-3 py-2.5 bg-white border border-[#e2e8f0] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#2563eb] transition-colors">
        </div>
        <div class="flex items-center gap-2">
            <input name="ingat" type="checkbox" id="ingat"
                class="w-4 h-4 bg-white border border-[#e2e8f0] rounded text-[#2563eb] focus:ring-0">
            <label for="ingat" class="text-sm text-[#64748b]">Ingat Saya</label>
        </div>
        <button type="submit"
            class="w-full py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white text-sm font-medium rounded-lg transition-colors">
            Login
        </button>
    </form>

    <div class="mt-5 pt-5 border-t border-[#e2e8f0] text-center">
        <p class="text-sm text-[#64748b]">Belum punya akun?</p>
        <a href="/" class="inline-block mt-2 text-sm text-[#2563eb] hover:text-[#1d4ed8] transition-colors font-medium">
            Daftar Sekarang
        </a>
    </div>

    @error('email')
        <p class="mt-3 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @error('password')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @if (session('error') && !session('status'))
        <p class="mt-3 text-sm text-red-500">{{ session('error') }}</p>
    @endif
@endsection