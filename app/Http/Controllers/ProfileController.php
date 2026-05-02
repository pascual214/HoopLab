<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Exercise;
use App\Models\Training;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $trainings = Training::where('id_user', $request->user()->id_user)
            ->orderBy('id_training', 'desc')
            ->get();

        $exercises = Exercise::where('id_user', $request->user()->id_user)
            ->orderBy('id_exercise', 'desc')
            ->get();

        return Inertia::render('Profile/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'trainings' => $trainings,
            'exercises' => $exercises,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profiles', 'public');
            $user->picture = $path;
            $user->save();
        }

        return back();
    }
}
