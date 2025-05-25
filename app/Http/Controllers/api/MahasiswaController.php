<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MahasiswaRequest;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class MahasiswaController extends Controller
{
    //

    public function index()
    {
        $data = MahasiswaResource::collection(Mahasiswa::all()); // mengapa pakai static method collection disini, karena mahasiswa::all() akan mengembalikan sebuah collection yang mana ini harus di handle oleh collection method
        if(Empty($data)) {
            return response()->json([
                'status' => 0,
                'message' => 'Data API is empty'
            ]);
        } else {
            return response()->json($data);
        }
    }
    public function showById($id)
    {
        $data = new MahasiswaResource(Mahasiswa::findOrFail($id)); // tidak seperti di index method, disini kita bisa instansiasi langsung mahasiswa resource dengan mengirimkan single data dari mahasiswa, karena dia bukan collection jadi aman aman saja untuk mengintansiasikan resource mahasiswa ke dalam $data
        if ($data) {
            return response()->json($data);
        }
        return response()->json([
            'status' => "Cant't Find Id"
        ], 400);
    }

    public function store(MahasiswaRequest $request)
    {
        $validated = $request->validated(); // pakai validateD untuk ambil data yang sudah di validasi

        if ($validated) {
            $mahasiswa = Mahasiswa::create($validated);
            return response()->json([
                'id' => $mahasiswa->id,
                'status' => 'Success',
                'data' => [
                    'nama' => $mahasiswa->nama,
                    'nim' => $mahasiswa->nim,
                    'email' => $mahasiswa->email,
                ]
            ], 201);
        }else {
            response()->json([
                'status' => "Syntax Error"
            ]);
        }
    }

    public function update(MahasiswaRequest $request, $id)
    {

        $validated = $request->validated();

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
        $data = Mahasiswa::findorFail($id);
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
