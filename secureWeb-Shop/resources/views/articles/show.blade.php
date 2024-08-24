<!-- resources/views/articles/show.blade.php -->
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
            </div>
        </div>
    </div>
</x-app-layout>
