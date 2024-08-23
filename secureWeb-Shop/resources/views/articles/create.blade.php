<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('Create New Article') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('articleCss/create.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <form action="{{ route('articles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">{{ __('Price') }}</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
                    @error('price')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="boutique_id">{{ __('Select Shop') }}</label>
                    <select id="boutique_id" name="boutique_id" class="form-control" required>
                        <option value="">{{ __('Select a shop') }}</option>
                        @foreach($boutiques as $boutique)
                            <option value="{{ $boutique->id }}" {{ old('boutique_id') == $boutique->id ? 'selected' : '' }}>
                                {{ $boutique->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('boutique_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Create Article') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
