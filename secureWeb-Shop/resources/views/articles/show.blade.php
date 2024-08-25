<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ $article->title }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('articleCss/show.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <div class="article-details">
                <h3 class="article-title">{{ $article->title }}</h3>
                <p class="article-description">{{ $article->description }}</p>
                <p class="article-price">{{ __('Price') }}: ${{ $article->price }}</p>
                <p class="article-boutique">{{ __('Shop') }}: <a href="{{ route('boutiques.show', $article->boutique->id) }}" class="item-link">{{ $article->boutique->name }}</a></p>
                <p class="article-creator">{{ __('Created by') }}: {{ $article->user->name }}</p>

                <!-- Affichage de l'image décryptée -->
                @if($imageUrl)
                    <h4>{{ __('Image') }}</h4>
                    <img src="{{ $imageUrl }}" alt="Article Image" style="max-width: 50%; height: auto;">
                @else
                    <p>{{ __('No image available') }}</p>
                @endif
            </div>

            <!-- Share Form -->
            <div class="share-section">
                <h4>{{ __('Share This Article') }}</h4>
                <form action="{{ route('articles.share', $article->id) }}" method="POST">
                    @csrf
                    <label>
                        <input type="radio" name="share_type" value="public" checked>
                        {{ __('Share Publicly') }}
                    </label>
                    <label>
                        <input type="radio" name="share_type" value="private">
                        {{ __('Share with User') }}
                    </label>
                    
                    <div id="user-selection" style="display: none;">
                        <label for="shared_with_user_id">{{ __('Select User') }}</label>
                        <select name="shared_with_user_id" id="shared_with_user_id">
                            <!-- Dynamically populate this dropdown with users -->
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">{{ __('Share') }}</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="share_type"]').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('user-selection').style.display = this.value === 'private' ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
