<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'User Profile',
            'list' => ['Home', 'Profil']
        ];

        $activeMenu = 'profile';
        $user = Auth::user();

        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateFoto()
    {
        $user = auth()->user();
        return view('profile.update_foto', compact('user'));
    }

    public function simpanFoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        if ($request->hasFile('foto_profile')) {
            // Delete old file if exists
            if ($user->foto_profile && Storage::exists('public/pfp/' . $user->foto_profile)) {
                Storage::delete('public/pfp/' . $user->foto_profile);
            }

            // Store new file
            $file = $request->file('foto_profile');
            $filename = 'pfp_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads/pfp', $filename);

            // Update database
            $user->foto_profil = $filename;
            $user->save();

            return response()->json(['message' => 'Foto profil berhasil diperbarui.']);
        }

        return response()->json(['error' => 'Tidak ada file yang diupload.'], 400);
    }
}