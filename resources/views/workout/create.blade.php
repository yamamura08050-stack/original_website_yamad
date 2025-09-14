@extends('layouts.main')
@section('body-class', 'page-create')
@php
    $page = 'workout-create';
@endphp

@section('content')
<div style="display:flex; align-items:center; justify-content:center; gap:10px;">
    <h1 style="margin-bottom:10px;">Add New Exercise</h1>
</div>

<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
    <button id="back-btn" style="padding: 3px; margin-left:8px;">
        <a href="{{ route('workouts.index') }}" style="text-decoration: none; ">← Back</a>
    </button>
    <h4>{{ $date }}</h4>
    <button type="button" id="add-exercise-btn" style="margin-left: auto; margin-right:8px">＋ Add Exercise</button>
</div>

<form  action="{{ route('workouts.store') }}" method="POST">
    @csrf
    <input type="hidden" name="train_date" value="{{ $date }}">

    <div id="exercises-container">
        <div class="exercise-block" style="margin-bottom:15px;">
            <div class="exercise-label">
                <label>Exercise</label>

                <!--新しく入力する時のテキストボックス-->
                <input type="text" name="custom_name[]" class="exercise-input" placeholder="Add New Item">
                <!-- セレクトボックス（以前登録したエクササイズ） -->
                <select class="exercise-select" name="name[]">
                    <option value="">-- Search History --</option>
                    @foreach($exercises as $exercise)
                        <option value="{{ $exercise }}">{{ $exercise }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sets-container">
                
                    <div class="set-row">
                        <input type="number" name="weight[0][]" value="" placeholder="weight(kg)">
                        <input type="number" name="reps[0][]" value=" " placeholder="reps">
                        <button type="button" class="add-set">＋</button>
                    </div>
            </div>
        </div>
    </div>

    <a href="{{ route('workouts.index') }}"><button type="submit" id="save-btn">save</button></a>
</form>
@endsection

{{--@vite('resources/black-css/create.css')--}}
<script>
    const exercises = @json($exercises); // $exercisesをJS配列に変換
</script>



@push('scripts')
    @vite('resources/js/exercise-form.js')
@endpush

