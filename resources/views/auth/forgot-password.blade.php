<x-guest-layout>
    <div class="w-full max-w-md overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-white/20">

        <!-- Header -->
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-700 to-sky-500 px-8 pt-10 pb-12 text-center text-white">

            <!-- Decorative Blur -->
            <div class="absolute -left-16 -top-16 h-48 w-48 rounded-full bg-white/20 blur-3xl"></div>
            <div class="absolute -bottom-20 -right-16 h-56 w-56 rounded-full bg-cyan-300/30 blur-3xl"></div>

            <div class="relative z-10">
                <a href="{{ route('dashboard.index') }}"
                   class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl border border-white/30 bg-white/15 shadow-xl backdrop-blur">
                    <img src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}"
                         alt="DKM AL HIKMAH"
                         class="h-14 w-auto">
                </a>

                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-100">
                    Reset Password
                </p>

                <h1 class="mt-3 text-3xl font-extrabold">
                    Lupa Password?
                </h1>

                <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-blue-100">
                    Masukkan email admin Anda. Kami akan mengirimkan link untuk membuat password baru.
                </p>
            </div>
        </div>

        <!-- Form -->
        <div class="px-8 py-8">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-gray-700">
                        Email Admin
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
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="admin@email.com"
                               class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 pl-12 text-sm font-medium text-slate-800 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 hover:border-blue-300 hover:bg-blue-50/30 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10" />
                    </div>

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="group relative flex w-full items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-r from-blue-800 via-blue-600 to-sky-500 px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-blue-500/30 transition duration-200 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">

                    <span class="absolute inset-y-0 left-0 flex items-center pl-5">
                        <svg class="h-5 w-5 text-blue-100 transition duration-200 group-hover:translate-x-1"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </span>

                    Kirim Link Reset Password
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center text-sm font-medium text-gray-500 transition hover:text-blue-600">
                    <svg class="mr-2 h-4 w-4"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>

                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>