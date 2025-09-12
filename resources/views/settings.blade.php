@extends('layouts.main')

@section('title', 'Settings')

@php
    $page = 'settings';
@endphp

@section('content')
<div class="settings-section">
    <h1>Settings</h1>
    <div class="setting">
        <div class=theme-setting>
            <h3>Theme Color</h3>
            <form action="{{ route('settings.theme') }}" method="POST">
            @csrf
            <label>
                <input type="radio" name="theme" value="dark" {{ session('theme') === 'dark' ? 'checked' : '' }}>
                dark
            </label>
            <label>
                <input type="radio" name="theme" value="light" {{ session('theme') === 'light' ? 'checked' : '' }}>
                light
            </label>
            
        </div>
        <button type="submit" class=theme-save-btn>Save</button>
        </form>
            
    </div>
    {{--<div class="setting-unit">
        <h3>Weight Unit</h3>
        <form action="{{ route('settings.unit') }}" method="POST">
        @csrf
        <label>
            <input type="radio" name="unit" value="kg" {{ auth()->user()->unit === 'kg' ? 'checked' : '' }}>
            kg
        </label>
        <label>
            <input type="radio" name="unit" value="lbs" {{ auth()->user()->unit === 'lbs' ? 'checked' : '' }}>
            lbs
        </label>
        <button type="submit">Save</button>
        </form>
    </div>--}}

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn" style="padding:5px; margin:10px 0 0 8px ;">
            logout
        </button>
    </form>
</div>
@endsection

@push('styles')
{{--@vite('resources/black-css/settings.css')--}}
@endpush