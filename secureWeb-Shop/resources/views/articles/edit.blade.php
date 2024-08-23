<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('Edit Article') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('articleCss/edit.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <form action="{{ route('articles.update', $article->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $article->title) }}" required>
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $article->description) }}</textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">{{ __('Price') }}</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price', $article->price) }}" required>
                    @error('price')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="boutique_id">{{ __('Select Shop') }}</label>
                    <select id="boutique_id" name="boutique_id" class="form-control" required>
                        @foreach($boutiques as $boutique)
                            <option value="{{ $boutique->id }}" {{ $article->boutique_id == $boutique->id ? 'selected' : '' }}>
                                {{ $boutique->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('boutique_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Update Article') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
