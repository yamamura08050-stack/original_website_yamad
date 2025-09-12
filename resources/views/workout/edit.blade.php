@extends('layouts.main')
@section('body-class', 'page-edit')
@php
    $page = 'workout-create';
@endphp

@section('content')

<form method="POST" action="{{ route('workouts.update', $exercise['id']) }}">
    @csrf
    @method('PUT')
    
<h2 style="text-align:center; margin-bottom:10px;">Edit Exercise</h2>
<button id="back-btn" style="margin-left:5px; padding:3px;><a href="{{ route('workouts.index') }}">← Back</a></button><span style="margin-left:68px; font-size:1.2rem;"> "{{ $exercise->exercise_name}}"</span>

<form>
    <div class="sets-container">
        <div style="display:flex; margin-left:80px; margin-top:10px;">
        <small>weight</small><small style="margin-left:100px;">reps</small>
        </div>
        
        @foreach($exercise->logs as $index => $log)
            <div class="set-row">
                <input type="number" name="weight[]" value="{{ $log->weight }}" placeholder="weight(kg)">
                <input type="number" name="reps[]" value="{{ $log->reps }}" placeholder="reps">
                @if($index === 0)
                    <button type="button" class="add-set">+</button>
                @else
                    <button type="button" class="remove-set">-</button>
                @endif
            </div>
        @endforeach
    </div>
    <button type="submit" style="margin-left:5px; padding:3px;">Save</button>
</form>
@endsection


{{--  @vite('resources/black-css/create.css')--}}
@push('scripts')
    @vite('resources/js/exercise-form.js')
@endpush