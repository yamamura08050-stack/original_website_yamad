@extends('layouts.main')

@section('title', 'dash')

@php
$page = 'common';
@endphp

@section('content')
<div class="dash-section">
    <div class="dash-content">
        <div class="TDEE">
            <h4 >TDEE-Chart</h4> <canvas id="TDEE-chart" width="250" height="250"></canvas>
        </div>
        <div class="weight-loss">
            <h4 style="margin-left:10px;">weight loss</h4>
            <div class="mild-loss">
                <div class="mild-loss-left">
                    <div class="mild-weight-loss">Mild weight loss</div>
                    <div class="mild-ex">0.25 kg/week</div>
                </div>
                <div class="mild-loss-cal">
                    <div><strong id="mild-loss-cal">....</strong> <small>/%</small></div>
                    <span>Calories/day</span>
                </div>
            </div>
            <div class="loss">
                <div class="loss-left">
                    <div class="weightloss">Weight loss</div>
                    <div class="mild-ex">0.5 kg/week</div>
                </div>
                <div class="loss-cal">
                    <div><strong id="loss-cal">....</strong> <small>/%</small></div>
                    <span>Calories/day</span>
                </div>
            </div>
            <div class="extreme-loss">
                <div class="extreme-loss-left">
                    <div class="extreme-weight-loss">EXtreme Weight loss</div>
                    <div class="mild-ex">1 kg/week</div>
                </div>
                <div class="extreme-loss-cal">
                    <div><strong id="extreme-loss-cal">....</strong> <small>/%</small></div>
                    <span>Calories/day</span>
                </div>
            </div>
        </div>
        <div class="weight-gain">
            <h4 style="margin-left:10px;">weight gain</h4>
            <div class="mild-gain">
                <div class="mild-gain-left">
                    <div class="mild-weight-gain">Mild weight gain</div>
                    <div class="mild-ex">0.25 kg/week</div>
                </div>
                <div class="mild-gain-cal">
                    <div><strong id="mild-gain-cal">....</strong> <small>/%</small></div>
                    <span>Calories/day</span>
                </div>
            </div>
            <div class="gain">
                <div class="gain-left">
                    <div class="weightgain">Weight gain</div>
                    <div class="mild-ex">0.5 kg/week</div>
                </div>
                <div class="gain-cal">
                    <div><strong id="gain-cal">....</strong> <small>/%</small></div>
                    <span>Calories/day</span>
                </div>
            </div>
            <div class="fast-gain">
                <div class="fast-gain-left">
                    <div class="weightgain">Extreme weight gain </div>
                    <div class="mild-ex">1 kg/week</div>
                </div>
                <div class="fast-gain-cal">
                    <div><strong id="fast-gain-cal">....</strong> <small>/%</small></div>
                    <span>Calories/day</span>
                </div>
            </div>
        </div>
    </div>
    <div class="data-input">
        <h2 style="text-align:center;">TDEE Calculator </h2>
        <hr class="underTDEE">
        <div class="paramater">
            <div class="upper">
                <form> <label for="gender">gender</label> <select id="gender" name="gender">
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select> </form>
                <form> <label for="age">age</label> <input type="number" id="age"> </form>
                <form> <label for="wei">weight</label> <input type="number" id="wei"> </form>
                <form> <label for="height">height</label> <input type="number" id="height"> </form>
            </div>
            <div class="middle">
                <form> <label for="activity-level">activity</label> <select id="activity-level"
                        name="activity-level">
                        <option value="1.2">little or no exercise</option>
                        <option value="1.375">light:exercise(1-2times/week)</option>
                        <option value="1.55">Moderate:exercise(3-5times/week)</option>
                        <option value="1.725">Very Active:intense exercise(6-7times/week)</option>
                        <option value="1.9">Extra Active:intense exercise(twice/day)</option>
                    </select> </form>
            </div>
            <div class="lower"> <button type="button" class="calc">Caluculate</button> <button
                    class="clear">Clear</button> </div>
        </div>
        <div class="result">
            <div class="left">
                <h3 id="BMR">BMR</h3>
                <h5><span id="BMR-val">/</span>kcal</h5>
            </div>
            <div class="right">
                <h3 id="TDEE">TDEE</h3>
                <h5><span id="TDEE-val">/</span>kcal</h5>
            </div>
        </div>
        <div class="pfc-data">
            <h2 style="text-align:center;">Macronutrient balance<span class="pfc-detail"></span></h2>
            <hr class="pfc-hr">
            <div class="pfc-data-upper">
                <div class="protein">
                    <h4>Protein</h4> <input type="number" id="protein-val" placeholder="g">
                </div>
                <div class="fat">
                    <h4>Fat</h4> <input type="number" id="fat-val" placeholder="g">
                </div>
            </div>
            <div class="pfc-data-lower">
                <div class="carb">
                    <h4>Carbohydrate</h4> <input type="number" id="carb-val" placeholder="g">
                </div>
                <div class="pfc-ratio"> <button id="pfc-button"> Caluculate</button>
                    <h2><span id="pfc-ratio"></span>/P:F:C</h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    @vite('resources/js/dash.js')
@endpush


