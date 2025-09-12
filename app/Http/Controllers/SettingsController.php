<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('settings');
    }

    public function updateTheme(Request $request)
    {

        $user = Auth::user();

        $theme = $request->input('theme', 'light');

        // テーマ切り替え
        $user->theme = $theme;
        $user->save();

        // 即時反映用にセッション更新
        session(['theme' => $theme]);


        return back()->with('status', 'Theme update!');
    }

    
    
}
