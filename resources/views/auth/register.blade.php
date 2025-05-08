<x-guest-layout>
    <!-- Flash Message -->
    @if(session('status'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-600 rounded">
            {{ session('status') }}
        </div>
    @endif

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="role" value="user">
        <input type="hidden" name="status" value="active">

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="Masukkan email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Nomor Telepon -->
        <div>
            <x-input-label for="phone" value="Nomor Telepon" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="08xxxxxxxxxx" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password" name="password_confirmation" required placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Syarat & Ketentuan -->
        <div class="flex items-center">
            <input id="terms" type="checkbox" name="terms" required class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="terms" class="ml-2 block text-sm text-gray-900">
                Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">syarat dan ketentuan</a>
            </label>        
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <!-- Already Have an Account -->
        <div class="text-sm text-center text-gray-600">
            {{ __("Sudah punya akun?") }}
            <a 
                href="{{ route('login') }}" 
                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition duration-150 ease-in-out"
            >
                {{ __('Login di sini') }}
            </a>
        </div>
    </form>
</x-guest-layout>

