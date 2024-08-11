<?php

namespace App\Http\Controllers;

use App\Models\Bimbel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\{Validator};

class BimbelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('bimbel.index', [
            'title'     => 'Kelas',
            'hal'       => 'class/index',
        ]);
    }

    public function json() : mixed
    {
        $bimbels = Bimbel::all();
        return response()->json($bimbels);
    }

    public function store(Request $request) : mixed
    {
        $rules = [
            'name' => 'required|string|unique:bimbels,title',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'day_start' => 'required|integer|between:0,6',
            'day_end' => 'required|integer|between:0,6',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
        ];

        $messages = [
            'name.unique' => 'Nama harus unique(tidak boleh sama dengan yang lain).',
            'harga.numeric' => 'Harga harus berupa angka.',
            // 'day_end.different' => 'Hari berakhir tidak boleh sama dengan hari mulai.',
            'time_end.after' => 'Waktu berakhir harus setelah waktu mulai.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'bg' => 'bg-danger',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $class = new Bimbel();
        $class->title = $request->name;
        $class->harga = $request->harga;
        $class->description = $request->deskripsi;
        $class->day_start = $request->day_start;
        $class->day_end = $request->day_end;
        $class->time_start = $request->time_start;
        $class->time_end = $request->time_end;

        $class->save();

        return response()->json([
            'bg' => 'bg-success',
            'message' => "Kelas telah ditambahkan."
        ], 201);
    }

    public function update(Request $request, Bimbel $bimbel) : mixed
    {
        $rules = [
            'name' => 'required|string|unique:bimbels,title,' . $bimbel->id,
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'day_start' => 'required|integer|between:0,6',
            'day_end' => 'required|integer|between:0,6',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
        ];

        // Custom error messages (optional)
        $messages = [
            'name.unique' => 'Nama harus unique(tidak boleh sama dengan yang lain).',
            'harga.numeric' => 'Harga harus berupa angka.',
            // 'day_end.different' => 'Hari berakhir tidak boleh sama dengan hari mulai.',
            'time_end.after' => 'Waktu berakhir harus setelah waktu mulai.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'bg' => 'bg-danger',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $bimbel->title = $request->name;
        $bimbel->harga = $request->harga;
        $bimbel->description = $request->deskripsi;
        $bimbel->day_start = $request->day_start;
        $bimbel->day_end = $request->day_end;
        $bimbel->time_start = $request->time_start;
        $bimbel->time_end = $request->time_end;

        $bimbel->save();

        return response()->json([
            'bg' => 'bg-success',
            'message' => "Kelas telah di-update."
        ], 201);
    }

    public function destroy(Bimbel $bimbel) : mixed
    {
        if ($bimbel->delete()) {
            return response()->json(['bg' => 'bg-success', 'message' => 'Kelas berhasil dihapus']);
        } else {
            return response()->json(['bg' => 'bg-danger', 'message' => 'Kelas not found'], 404);
        }

    }
}
