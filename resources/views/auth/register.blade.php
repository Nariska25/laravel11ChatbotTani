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

        <!-- Name Field -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input 
                id="name" 
                class="block mt-1 w-full" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                placeholder="Masukkan nama lengkap"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Field -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="email" 
                placeholder="Masukkan email"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number Field -->
        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input 
                id="phone" 
                class="block mt-1 w-full" 
                type="text" 
                name="phone" 
                :value="old('phone')" 
                placeholder="Masukkan nomor telepon (opsional)"
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password Field with Eye Toggle -->
        <div class="relative">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                id="password" 
                class="block mt-1 w-full pr-10" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
                placeholder="Minimal 8 karakter"
            />
            <button 
                type="button" 
                onclick="togglePasswordVisibility()" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                aria-label="Toggle password visibility"
            >
                <svg id="password-eye" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="password-eye-slash" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
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

    <!-- Password Toggle Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('password-eye');
            const eyeSlashIcon = document.getElementById('password-eye-slash');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>
