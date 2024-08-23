<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('My Articles') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('articleCss/index.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <!-- Success message -->
            @if (session('success'))
                <div class="status-message success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('articles.create') }}" class="btn btn-primary">{{ __('Create New Article') }}</a>

            @if($articles->isEmpty())
                <p>{{ __("You don't have any articles yet. Create your first article!") }}</p>
            @else
                <ul class="articles-list">
                    @foreach($articles as $article)
                        <li class="article-item">
                            <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                            <p class="boutique-info">
                                <strong>{{ __('Shop:') }}</strong> {{ $article->boutique->name }}
                            </p>
                            <div class="actions">
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-secondary">{{ __('Edit') }}</a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
