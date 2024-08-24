<x-app-layout>
    <x-slot name="header">
        <div class="header-content">
            <a href="{{ route('dashboard') }}" class="header-link">
                <h2 class="header-title">{{ __('Dashboard') }}</h2>
            </a>
            <div class="menu-icon" id="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="dropdown-menu hidden" id="dropdown-menu">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">{{ __('Profile') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                    @csrf
                    <button type="submit">{{ __('Logout') }}</button>
                </form>
            </div>
        </div>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

    <!-- Become a Moderator Section (Visible only for non-moderators) -->
    @if(!auth()->user()->isModerator())
    <div class="section become-moderator-section">
        <h3 class="section-title">{{ __('Devenir modérateur') }}</h3>
        
        <form action="{{ route('user.showPromotionForm') }}" method="GET" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">{{ __('Devenir modérateur') }}</button>
        </form>
    </div>

    @endif


    <div class="dashboard-container">
        <div class="content-wrapper">
            <!-- Success message with pop-up -->
            @if (session('success'))
                <div class="status-message success" id="status-message">
                    <div class="status-text">{{ session('success') }}</div>
                </div>
            @endif

            <!-- Welcome message that will be shown as a pop-up -->
            @if (session('welcomeMessage'))
                <div class="status-message" id="status-message">
                    <div class="status-text">{{ __("You're logged in!") }}</div>
                </div>
                <?php session()->forget('welcomeMessage'); ?>
            @endif

            <!-- Boutiques Section -->
            <div class="section boutiques-section">
                <h3 class="section-title">{{ __('My Shops') }}</h3>
                <a href="{{ route('boutiques.create') }}" class="btn btn-primary">{{ __('Create New Shop') }}</a>
                @if($boutiques->isEmpty())
                    <p class="no-items-message">{{ __("You don't have any shops yet. Create your first shop!") }}</p>
                @else
                    <ul class="list boutiques-list">
                        @foreach($boutiques as $boutique)
                            <li class="list-item boutique-item">
                                <a href="{{ route('boutiques.show', $boutique->id) }}" class="item-link">{{ $boutique->name }}</a>
                                <div class="actions">
                                    <a href="{{ route('boutiques.edit', $boutique->id) }}" class="btn btn-secondary">{{ __('Edit') }}</a>
                                    <form action="{{ route('boutiques.destroy', $boutique->id) }}" method="POST" style="display:inline;">
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

            <!-- Articles Section -->
            <div class="section articles-section">
                <h3 class="section-title">{{ __('My Articles') }}</h3>
                <a href="{{ route('articles.create') }}" class="btn btn-primary spacing-bottom" >{{ __('Add New Article') }}</a>
                
                @if($articles->isEmpty())
                    <p class="no-items-message">{{ __("You don't have any articles yet. Add your first article!") }}</p>
                @else
                    <ul class="list articles-list">
                        @foreach($articles as $article)
                            <li class="list-item article-item">
                                <a href="{{ route('articles.show', $article->id) }}" class="item-link">{{ $article->title }}</a>
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


            <!-- Moderation Section (Visible only for moderators) -->
            @if(auth()->user()->isModerator())
            <div class="section moderation-section">
                    <h3 class="section-title">{{ __('Moderation') }}</h3>
                    <a href="{{ route('moderations.index') }}" class="btn btn-warning">{{ __('Go to Moderation') }}</a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
