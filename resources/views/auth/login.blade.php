<x-guest-layout>
    <div class="w-full max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-white/20">

        <div class="grid min-h-[620px] grid-cols-1 lg:grid-cols-2">

            <!-- Left Branding Panel -->
            <div class="relative hidden overflow-hidden p-10 text-white lg:flex lg:flex-col lg:justify-between"
                style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">
                <!-- Decorative Blur -->
                <div class="absolute -left-20 -top-20 h-72 w-72 rounded-full bg-white/20 blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-sky-300/20 blur-3xl"></div>
                <div class="absolute left-24 top-1/2 h-40 w-40 rounded-full bg-blue-200/15 blur-2xl"></div>

                <div class="relative z-10">
                    <a href="{{ route('dashboard.index') }}" class="inline-flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-white/30 bg-white/15 shadow-xl backdrop-blur">
                            <img src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}"
                                alt="DKM AL HIKMAH"
                                class="h-11 w-auto">
                        </div>

                        <div>
                            <h1 class="text-xl font-extrabold tracking-wide">
                                DKM AL HIKMAH
                            </h1>
                            <p class="text-sm text-blue-100">
                                Admin Management Portal
                            </p>
                        </div>
                    </a>
                </div>

                <div class="relative z-10">
                    <div class="mb-6 inline-flex rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-blue-50 backdrop-blur">
                        Portal Internal Pengurus
                    </div>

                    <h2 class="max-w-md text-4xl font-extrabold leading-tight">
                        Kelola data DKM dengan mudah, rapi, dan aman.
                    </h2>

                    <p class="mt-5 max-w-md text-sm leading-7 text-blue-100">
                        Masuk ke dashboard untuk mengelola kegiatan, laporan keuangan,
                        infaq, musala, serta konten informasi DKM AL HIKMAH.
                    </p>
                </div>

                <div class="relative z-10">
                    <p class="text-sm text-blue-100">
                        © {{ date('Y') }} DKM AL HIKMAH
                    </p>
                </div>
            </div>

            <!-- Right Login Panel -->
            <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-14">
                <div class="w-full max-w-md">

                    <!-- Mobile Logo -->
                    <div class="mb-8 text-center lg:hidden">
                        <a href="{{ route('dashboard.index') }}" class="inline-flex flex-col items-center">
                            <div class="flex h-20 w-20 items-center justify-center rounded-3xl shadow-lg shadow-blue-500/30"
                                style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">
                                <img src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}"
                                     alt="DKM AL HIKMAH"
                                     class="h-14 w-auto">
                            </div>

                            <h1 class="mt-4 text-xl font-extrabold text-gray-900">
                                DKM AL HIKMAH
                            </h1>
                        </a>
                    </div>

                    <div class="mb-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-600">
                            Admin Login
                        </p>

                        <h2 class="mt-3 text-3xl font-extrabold text-gray-900">
                            Selamat Datang
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Silakan masuk menggunakan akun admin untuk melanjutkan ke dashboard.
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-gray-700">
                                Email atau NRP
                            </label>

                            <div class="group relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="h-5 w-5 text-slate-400 transition group-focus-within:text-blue-600"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>

                                <input id="email"
                                    type="text"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="admin@email.com atau 123456"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 pl-12 text-sm font-medium text-slate-800 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 hover:border-blue-300 hover:bg-blue-50/30 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10" />
                            </div>

                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-gray-700">
                                Password
                            </label>

                            <div class="group relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="h-5 w-5 text-slate-400 transition group-focus-within:text-blue-600"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6A2.25 2.25 0 0117.25 21H6.75A2.25 2.25 0 014.5 18.75v-6A2.25 2.25 0 016.75 10.5z" />
                                    </svg>
                                </div>

                                <input id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 pl-12 text-sm font-medium text-slate-800 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 hover:border-blue-300 hover:bg-blue-50/30 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10" />
                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me + Forgot Password -->
                        <div class="flex items-center justify-between gap-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me"
                                       type="checkbox"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                       name="remember">

                                <span class="ms-2 text-sm text-gray-600">
                                    Ingat saya
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-blue-600 transition hover:text-blue-800"
                                   href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="group relative flex w-full items-center justify-center overflow-hidden rounded-2xl px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-blue-500/30 transition duration-200 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">

                            <span class="absolute inset-y-0 left-0 flex items-center pl-5">
                                <svg class="h-5 w-5 text-blue-100 transition duration-200 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                            </span>

                            Masuk Dashboard
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard.index') }}"
                           class="inline-flex items-center justify-center text-sm font-medium text-gray-500 transition hover:text-blue-600">
                            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>

                            Kembali ke halaman utama
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>