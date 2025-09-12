@extends('layouts.main')

@section('title', 'weight')

@php
    $page = 'common';
@endphp

@section('content')
<div class="weight-section">
    <div class="weight-left">
        <div class="weight-input">
            <h3>Daily Weight</h3>
            <form id="weight-form" action="{{ route('weight.store') }}" method="POST">
                @csrf
                <div class="form-group"> <label for="daily-date">Date</label> <input type="date"
                        name="record_date" id="record-date" required> </div>
                <div class="form-group"> <label for="record-weight">Weight</label> <input type="number"
                        id="record-weight" name="weight" step="0.1" required> </div> 
                        <button type="submit" id="save-weight">Save/Show</button>
            </form>
        </div>
        <div class="weight-history">
            <div class="weight-edit">
                <h3>Weight History</h3><button id="edit-btn">edit</button>
            </div>
            <div class="history-list">
                @foreach($weights as $weight)
                    <div class="history-item" data-id="{{ $weight->id }}" data-date="{{ $weight->record_date }}">
                        <div class="date">{{ $weight->record_date }}</div>
                        <div class="weight">{{ $weight->weight }}kg</div>
                        <div class="diff">
                            <span class="diff-text">{{ $weight->diff }}</span>
                            <form class="delete-form" action="{{ route('weight.destroy', $weight->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" type="submit" style="display:none;">－</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>


    <div class="weight-wrapper" style="padding-left:50px">
        <canvas id="weight-chart" style="min-width: 455px; height: 600px; dispay:block;"></canvas> 
    </div>

<script>
const labels = @json($weights->pluck('record_date'));
const data = @json($weights->pluck('weight'));
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/weight.js') }}"></script>

</div>



@push('scripts')
@vite('resources/js/weight.js')
@endpush

@endsection

