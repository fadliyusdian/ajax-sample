<?php

namespace App\Http\Controllers;

use App\JadwalPelajaran;
use App\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranByMapel extends Controller
{
    //
    public function index()
    {
        $mapel = MataPelajaran::all();
        return view('jadwal-mapel', ['mapel' => $mapel]);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mapel' => 'required|exists:mata_pelajarans,id'
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $mataPelajaran = MataPelajaran::find($request->mapel);
        $jadwalPelajaran = $mataPelajaran->jadwal_pelajarans->where('user_id', auth()->user()->id)->map(function($data) {
            $data['hari'] = $data->hari;
            return $data;
        });

        return ['status' => true, 'data' => $jadwalPelajaran, 'mapel' => $mataPelajaran];
    }
}
