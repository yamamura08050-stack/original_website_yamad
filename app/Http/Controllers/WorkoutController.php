<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Exercise;
use App\Models\ExerciseLog;


class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        // 表示する月を取得（デフォルトは現在月）
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        // Carbonで現在の月を作成
        $date = Carbon::createFromDate($year, $month, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // カレンダーの日付データを生成
        $dates = [];
        $day = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY); // 最初の週の日曜日から開始

        while ($day->lte($endOfMonth->copy()->endOfWeek(Carbon::SATURDAY))) {
            $dates[] = $day->copy();
            $day->addDay();
        }

        $selectedDate = $request->input('date', Carbon::now()->toDateString());


        $workouts = Exercise::where('user_id', auth()->id())
            ->where('train_date', $selectedDate)
            ->withCount(['logs as logs_count' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->get(['id', 'exercise_name']);


        return view('workout.index', [
            'currentMonth' => $date,
            'dates' => $dates,
            'workouts' => $workouts
        ]);
}

    public function dayExercises(Request $request)
    {
        $date = $request->input('date');

        $exercises = Exercise::where('user_id', auth()->id())
            ->where('train_date', $date)
            ->withCount('logs')
            ->get(['id', 'exercise_name']);

        return response()->json($exercises);
    }


    public function create(Request $request)
    {
        $date = $request->query('date');


        $exercises = Exercise::where('user_id',auth()->id())
                            ->distinct()
                            ->pluck('exercise_name');

        $logs = [];

        return view('workout.create', compact('date', 'exercises', 'logs'));
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'train_date' => 'required|date',
            'weight.*.*' => 'nullable|numeric',
            'reps.*.*' => 'required|integer',
        ]);

        $exerciseName = $request->custom_name[0] ?? $request->name[0] ?? null;

        if(!$exerciseName){
            return back()->withErrors(['error' => '種目名を入力してください']);
        }
        $exercise = Exercise::create([
            'train_date'   => $request->train_date,
            'user_id'      => auth()->id(),
            'exercise_name'=> $exerciseName,
        ]);

        if($request->weight && $request->reps){
            foreach ($request->weight[0] as $index => $weight){
                ExerciseLog::create([
                    'user_id'       => auth()->id(),
                    'exercise_id'   => $exercise->id,
                    'weight'        => $weight,
                    'reps'          =>$request->reps[0][$index],
                ]);
            }
        }


        return redirect() -> route('workouts.index')->with('success','種目を保存しました!');
    }

    public function edit($id)
    {
        $exercise = Exercise::with('logs')->findOrFail($id);

        // Bladeでセットごとに使えるようにログを配列化
        $logs = $exercise->logs()->orderBy('id', 'asc')->get();

        // train_date を $date として渡す
        $date = $exercise->train_date;

        return view('workout.edit', compact('exercise', 'logs', 'date'));
    }


    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);

        // 名前を更新したい場合はコメントアウト解除
        // $exercise->exercise_name = $request->exercise_name;
        $exercise->save();

        // 古いログを全部消す
        $exercise->logs()->delete();

        // 新しいログを保存
        foreach ($request->weight as $i => $w) {
            $r = $request->reps[$i] ?? null;

            if ($w !== null || $r !== null) {
                $exercise->logs()->create([
                    'weight' => $w,
                    'reps'   => $r,
                    'user_id' => auth()->id(), // 必要なら
                ]);
            }
        }
        return redirect()->route('workouts.index')->with('success', '更新しました');
    }

    public function destroy($id)
    {
        try {
            $exercise = Exercise::where('user_id', auth()->id())->findOrFail($id);

            $exercise->logs()->delete();
            $exercise->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
