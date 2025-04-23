<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        return KategoriModel::all();
    }
    public function store(Request $request)
    {
        $level = KategoriModel::create($request->all());
        return response()->json($level, 201);
    }
    
    public function show(KategoriModel $level)
    {
        return KategoriModel::find($level);
    }
    
    public function update(Request $request, KategoriModel $level)
    {
        $level->update($request->all());
        return KategoriModel::find($level);
    }
    
    public function destroy(KategoriModel $user)
    {
        $user->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}    