<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weight;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;

class WeightController extends Controller
{

    public function index(Request $request)
    {
        $weights = Weight::where('user_id', Auth::id())
            ->orderBy('record_date', 'desc')
            ->get();

        $weights->transform(function ($weight, $key) {
            $weight->diff = $weight->diffFromPrevious();
            return $weight;
        });

        return view('weight.index', compact('weights'));
    }

    




    public function store(Request $request)
    {
        $weight = Weight::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'record_date' => $request->record_date,
            ],
            [
                'weight' => $request->weight,
            ]
        );

        // diff を再計算
        $weight->diff = $weight->diffFromPrevious();

        // 前後のレコードも取得
        $previous = Weight::where('user_id', auth()->id())
            ->where('record_date', '<', $weight->record_date)
            ->orderBy('record_date', 'desc')
            ->first();

        $next = Weight::where('user_id', auth()->id())
            ->where('record_date', '>', $weight->record_date)
            ->orderBy('record_date', 'asc')
            ->first();

        $updated = [];

        if ($previous) {
            $previous->diff = $previous->diffFromPrevious();
            $updated[] = [
                'id' => $previous->id,
                'record_date' => (string) $previous->record_date,
                'weight' => $previous->weight,
                'diff' => $previous->diff,
            ];
        }

        $updated[] = [
            'id' => $weight->id,
            'record_date' => (string) $weight->record_date,
            'weight' => $weight->weight,
            'diff' => $weight->diff,
        ];

        if ($next) {
            $next->diff = $next->diffFromPrevious();
            $updated[] = [
                'id' => $next->id,
                'record_date' => (string) $next->record_date,
                'weight' => $next->weight,
                'diff' => $next->diff,
            ];
        }

        return response()->json([
            'success' => true,
            'updated' => $updated,
        ]);
    }



    public function destroy($id)
    {
        $weight = Weight::findOrFail($id);

        if ($weight->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => '権限がありません'], 403);
        }

        $weight->delete();

        return response()->json(['success' => true]);
    }
}


