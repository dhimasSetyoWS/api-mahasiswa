<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    //

    public function index()
    {
        $data = Mahasiswa::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'bail|required|unique:mahasiswa|max:250',
            'nim' => 'required|unique:mahasiswa|max:10',
            'email' => 'required|unique:mahasiswa|max:100'
        ]);

        if ($validated) {
            $mahasiswa = Mahasiswa::create($validated);
            return response()->json([
                'status' => 'Success',
                'data' => $mahasiswa
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $mahasiswa  = Mahasiswa::find($id)->update($request->all());
        if ($mahasiswa) {
            return response()->json([
                'status' => 'Success update',
                'data' => $mahasiswa
            ], 201);
        }
    }

    public function delete($id) {}
}
