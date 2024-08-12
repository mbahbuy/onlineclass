<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Bimbel, Buying};
use Illuminate\Support\Facades\{Auth, Validator};
use Illuminate\View\View;

class BuyingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('buying.index', [
            'title' => 'Class',
            'hal'   => 'kelas/index'
        ]);
    }

    public function json(): mixed
    {
        $user = Auth::user();

        $data = Bimbel::with(['buyings' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        return response()->json($data);
    }

    public function store(Request $request) : mixed
    {
        $rules = ['bimbel_id' => 'required|numeric|exists:bimbels,id'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'bg' => 'bg-danger',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $buying = new Buying();
        $buying->bimbel_id = $request->bimbel_id;
        $buying->user_id = Auth::user()->id;
        $buying->save();

        return response()->json([
            'bg' => 'bg-success',
            'message' => "Kelas telah dibeli."
        ], 201);
    }

    public function show(Buying $buying, Bimbel $bimbel) : View
    {
        return view('buying.show', [
            'title'     => "kelas $bimbel->title",
            'hal'       => 'kelas/show',
            'buyings'   => $buying,
            'bimbel'    => $bimbel
        ]);
    }

    public function list() : View
    {
        $data = Buying::with(['user', 'bimbel'])->get();
        return view('buying.list', [
            'title'     => 'History Pembelian',
            'hal'       => 'pembelian/list',
            'data'      => $data
        ]);
    }
}
