<!-- resources/views/boutiques/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ $boutique->name }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('boutiqueCss/show.css') }}">

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
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
