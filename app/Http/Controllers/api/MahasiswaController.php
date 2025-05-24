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
    public function showById($id)
    {
        $data = Mahasiswa::find($id);
        if ($data) {
            return response()->json($data);
        }
        return response()->json([
            'status' => "Cant't Find Id"
        ], 400);
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

        $validated = $request->validate([
            'nama' => 'sometimes|required|unique:mahasiswa|max:250',
            'nim' => 'sometimes|required|unique:mahasiswa|max:10',
            'email' => 'sometimes|required|unique:mahasiswa|max:100'
        ]);

        if (empty($validated)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Tidak ada data yang dikirim.'
            ], 422);
        }

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($validated);

        return response()->json([
            'status' => 'Success Update',
            'data' => $mahasiswa
        ], 200);
    }

    public function delete($id) {
        $data = Mahasiswa::find($id);
        $deletedData = Mahasiswa::destroy($id);
        if ($deletedData) {
            return response()->json([
                'status' => 'Data Deleted',
                'deleted_data' => $data
            ]);
        }else {
            return response()->json([
                'status' => 'Invalid',
            ], 400);
        }
    }
}
