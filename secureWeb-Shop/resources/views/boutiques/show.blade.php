<!-- resources/views/boutiques/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ $boutique->name }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('boutiqueCss/show.css') }}">
    <link rel="stylesheet" href="{{ asset('boutiqueCss/share.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <div class="boutique-details">
                <h3 class="boutique-name">{{ $boutique->name }}</h3>
                <p class="boutique-description">{{ $boutique->description }}</p>
                
                <h4 class="section-title">{{ __('Articles in this Shop') }}</h4>
                @if($boutique->articles->isEmpty())
                    <p>{{ __("No articles found in this shop.") }}</p>
                @else
                    <ul class="article-list">
                        @foreach($boutique->articles as $article)
                            <li class="article-item">
                                <a href="{{ route('articles.show', $article->id) }}" class="item-link">{{ $article->title }}</a>
                                @if($article->share_type === 'public')
                                    <span>{{ __('Shared publicly') }}</span>
                                @elseif($article->shared_with_user_id)
                                    <span>{{ __('Shared with') }}: {{ $article->sharedWithUser->name }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Share Form -->
            <div class="share-section">
                <h4>{{ __('Share This Shop') }}</h4>
                <form action="{{ route('boutiques.share', $boutique->id) }}" method="POST">
                    @csrf
                    <label>
                        <input type="radio" name="share_type" value="public" {{ $boutique->share_type === 'public' ? 'checked' : '' }}>
                        {{ __('Share Publicly') }}
                    </label>
                    <label>
                        <input type="radio" name="share_type" value="private" {{ $boutique->share_type === 'private' ? 'checked' : '' }}>
                        {{ __('Share with User') }}
                    </label>
                    
                    <div id="user-selection" style="{{ $boutique->share_type === 'private' ? 'display: block;' : 'display: none;' }}">
                        <label for="shared_with_user_id">{{ __('Select User') }}</label>
                        <select name="shared_with_user_id" id="shared_with_user_id">
                            <!-- Dynamically populate this dropdown with users -->
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $boutique->shared_with_user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
