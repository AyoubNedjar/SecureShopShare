<!-- resources/views/boutiques/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">{{ __('My Shops') }}</h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('boutiqueCss/index.css') }}">

    <div class="container">
        <div class="content-wrapper">
            <!-- Success message -->
            @if (session('success'))
                <div class="status-message success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('boutiques.create') }}" class="btn btn-primary">{{ __('Create New Shop') }}</a>

            @if($boutiques->isEmpty())
                <p>{{ __("You don't have any shops yet. Create your first shop!") }}</p>
            @else
                <ul class="boutiques-list">
                    @foreach($boutiques as $boutique)
                        <li class="boutique-item">
                            <a href="{{ route('boutiques.show', $boutique->id) }}">{{ $boutique->name }}</a>
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
    </div>
</x-app-layout>
