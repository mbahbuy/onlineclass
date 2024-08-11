<?php

namespace App\Http\Controllers;

use App\Models\{Siswa, User};
use Illuminate\View\View;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() : View
    {
        return view('siswa.index', [
            'title' => 'Siswa',
            'hal'   => 'siswa/index'
        ]);
    }

    public function json(): mixed
    {
        $siswa = Siswa::with('user')->get();
        return response()->json($siswa);
    }

    public function approve(Siswa $siswa)
    {
        $siswa->status = 1;
        $siswa->save();
    
        $user = $siswa->user;
        $user->is_siswa = true;
        $user->save();

        return response()->json(['bg' => 'bg-success', 'message' => 'Siswa diterima']);
    }

    public function block(Siswa $siswa)
    {
        $siswa->status = 2;
        $siswa->save();
        return response()->json(['bg' => 'bg-success', 'message' => 'Siswa di-block']);
    }
}
