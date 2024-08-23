<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- reCAPTCHA -->
        <div class="mt-4">
            <div id="recaptcha-container"></div>
            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
        </div>

        <!-- Verification Code -->
        <div id="verification-code-div" class="mt-4" style="display: none;">
            <x-input-label for="verification_code" :value="__('Verification Code')" />
            <x-text-input id="verification_code" class="block mt-1 w-full" type="text" name="verification_code" required />
            <x-input-error :messages="$errors->get('verification_code')" class="mt-2" />
            <p>{{ __('Enter the following code:') }} <strong id="verification-code" class="no-select"></strong></p>
            <input type="hidden" id="encrypted-code" value="{{ $encryptedCode }}">
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
        <style>
            .no-select {
                user-select: none;
                -webkit-user-select: none; /* Safari */
                -moz-user-select: none; /* Firefox */
                -ms-user-select: none; /* Internet Explorer/Edge */
                pointer-events: none; /* Disable click events */
            }
        </style>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script>
            function onSubmit(token) {
                document.getElementById("registerForm").submit();
            }

            function showVerificationCode() {
                document.getElementById("verification-code-div").style.display = "block";
                const encryptedCode = document.getElementById("encrypted-code").value;
                const decodedCode = atob(encryptedCode);
                document.getElementById("verification-code").textContent = decodedCode;
            }

            // reCAPTCHA callback
            var onloadCallback = function() {
                grecaptcha.render('recaptcha-container', {
                    'sitekey': "{{ config('services.recaptcha.site_key') }}",
                    'callback': showVerificationCode
                });
            };

            // Disable right-click on the verification code
            document.addEventListener('contextmenu', function(e) {
                if (e.target.id === 'verification-code') {
                    e.preventDefault();
                }
            });
        </script>
    @endpush
</x-guest-layout>
