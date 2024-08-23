<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('Edit Shop') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('boutiqueCss/edit.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <form action="{{ route('boutiques.update', $boutique->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">{{ __('Shop Name') }}</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $boutique->name) }}" required>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $boutique->description) }}</textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Update Shop') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
