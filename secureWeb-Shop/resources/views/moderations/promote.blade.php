<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('Become a Moderator') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('moderationCss/promote.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <form action="{{ route('user.promote') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="code">{{ __('Enter Promotion Code') }}</label>
                    <input type="text" id="code" name="code" class="form-control" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Submit Code') }}</button>
                </div>

                @if(session('error'))
                    <p class="text-danger">{{ session('error') }}</p>
                @endif

                @if(session('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
