<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function showPromotionForm()
    {
        return view('moderations.promote');
    }

    public function promote(Request $request)
    {
        $user = Auth::user();
        $code = $request->input('code');

        // Code secret stocké dans le fichier .env ou config
        $secretCode = config('app.moderator_code');

        if ($code === $secretCode) {
            $user->role = 'moderator';
            $user->save();

            return redirect()->back()->with('success', 'You are now a moderator.');
        } else {
            return redirect()->back()->with('error', 'Invalid code. Please try again.');
        }
    }
}
