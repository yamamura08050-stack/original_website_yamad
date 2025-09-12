@extends('layouts.main')

@section('title', 'index')


@php
    $page = 'workout-index';
@endphp

@section('content')
<h1 >Workout Journal</h1>

    <div style="max-width: 600px; margin: 15px auto;">
        <h2 style="text-align: center; font-size: 20px;">
            <a href="?year={{ $currentMonth->copy()->subMonth()->year }}&month={{ $currentMonth->copy()->subMonth()->month }}">&lt;</a>
            {{ $currentMonth->locale('en')->isoFormat('MMMM YYYY') }}
            <a href="?year={{ $currentMonth->copy()->addMonth()->year }}&month={{ $currentMonth->copy()->addMonth()->month }}">&gt;</a>
        </h2>
        
        <div class="calendar-grid">
            <div>日</div>
            <div>月</div>
            <div>火</div>
            <div>水</div>
            <div>木</div>
            <div>金</div>
            <div>土</div>
            
            @foreach($dates as $date)
                <div class="date @if($date->month != $currentMonth->month) outside-month @endif" 
                data-date="{{ $date->toDateString() }}">
                    {{ $date->day }}
                </div>
            @endforeach
        </div>
        <input type="hidden" id="selected-date" value="">

    </div>
    <div class="workout-summary">
        <h3 class="workout-summary--title" style="margin-left:10px;" > Workout Summary </h3>
        <small class="workout-summary--subtitle" style="margin-left:10px"> Today's Log </small>



        <div class="exercise-list">
            
        </div>
    </div>

    <div class="add-exercise">
        <button class="add-exercise-btn" id="add-exercise-btn"><span>+</span>Add New Exercise</button>
    </div>



@push('styles')
{{--@vite('resources/black-css/workout.css')--}}
@endpush
@push('scripts')
@vite('resources/js/workout.js')
@endpush

@endsection