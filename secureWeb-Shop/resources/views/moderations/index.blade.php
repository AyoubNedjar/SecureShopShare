<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('Pending Moderation') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('moderationCss/index.css') }}">


    <div class="container">
        <div class="content-wrapper">
            <h3>{{ __('Shops Pending Approval') }}</h3>
            @if($boutiques->isEmpty())
                <p>{{ __('No shops pending approval.') }}</p>
            @else
                <ul class="moderation-list">
                    @foreach($boutiques as $boutique)
                        <li class="moderation-item">
                            <div>
                                <strong>{{ $boutique->name }}</strong>
                                <p>{{ __('Created by') }}: {{ $boutique->user->name }}</p>
                            </div>
                            <div class="actions">
                                <form action="{{ route('moderations.update', $boutique->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="type" value="boutique">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
                                </form>

                                <form action="{{ route('moderations.update', $boutique->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="type" value="boutique">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <h3>{{ __('Articles Pending Approval') }}</h3>
            @if($articles->isEmpty())
                <p>{{ __('No articles pending approval.') }}</p>
            @else
                <ul class="moderation-list">
                    @foreach($articles as $article)
                        <li class="moderation-item">
                            <div>
                                <strong>{{ $article->title }}</strong>
                                <p>{{ __('Created by') }}: {{ $article->user->name }}</p>
                                <p>{{ __('In shop') }}: {{ $article->boutique->name }}</p>
                            </div>
                            <div class="actions">
                                <form action="{{ route('moderations.update', $article->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="type" value="article">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
                                </form>

                                <form action="{{ route('moderations.update', $article->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="type" value="article">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
