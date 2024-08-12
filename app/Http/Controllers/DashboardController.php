<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{Request,RedirectResponse};
use Illuminate\Support\Facades\{Auth, Validator};

class DashboardController extends Controller
{
    public function index() : View
    {
        return view('index', [
            'title' => 'Dashboard',
            'hal' => 'dashboard/index'
        ]);
    }

    public function daftarsiswa(Request $request) : RedirectResponse
    {
        $rules = [
            'phone' => 'required|string',
            'school' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withInput()->with(['error' => $validator->errors()->first()]);
        }

        $siswa = new Siswa();
        $siswa->user_id = $request->user()->id;
        $siswa->phone = $request->phone;
        $siswa->school = $request->school;
        $siswa->save();

        return redirect('/')->with('message', 'Anda sudah mendaftar, tunggu konfirmasi dari admin!!!.');
    }
}
