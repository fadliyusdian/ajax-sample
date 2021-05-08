<?php

namespace App\Http\Controllers;

use App\Hari;
use App\JadwalPelajaran;
use App\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jadwal_pelajaran = JadwalPelajaran::where('user_id', auth()->user()->id)->orderBy('hari_id')->get();
        $mapel = MataPelajaran::all();
        $hari = Hari::all();
        return view('jadwal', ['jadwal' => $jadwal_pelajaran, 'mapel' => $mapel, 'hari' => $hari]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'mapel' => 'required|exists:mata_pelajarans,id',
            'hari' => 'required|exists:haris,id',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg'=> $validator->errors()->first()];
        }

        $jadwal_pelajaran = JadwalPelajaran::create([
            'user_id' => auth()->user()->id,
            'mata_pelajaran_id' => $request->mapel,
            'hari_id' => $request->hari
        ]);
        return ['status' => true, 'msg' => "Jadwal telah ditambahkan", 'data' => JadwalPelajaran::where('id', $jadwal_pelajaran->id)->with(['mapel', 'hari'])->first()];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JadwalPelajaran  $jadwal_pelajaran
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalPelajaran $jadwal_pelajaran)
    {
        //
        return $jadwal_pelajaran;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JadwalPelajaran  $jadwal_pelajaran
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalPelajaran $jadwal_pelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JadwalPelajaran  $jadwal_pelajaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JadwalPelajaran $jadwal_pelajaran)
    {
        //
        $validator = Validator::make($request->all(), [
            'mapel' => 'required|exists:mata_pelajarans,id',
            'hari' => 'required|exists:haris,id',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg'=> $validator->errors()->first()];
        }

        $jadwal_pelajaran->update([
            'user_id' => auth()->user()->id,
            'mata_pelajaran_id' => $request->mapel,
            'hari_id' => $request->hari
        ]);

        return ['status'=> true, 'msg' => "Jadwal telah diperbaharui", 'data' => JadwalPelajaran::where('id', $jadwal_pelajaran->id)->with(['mapel', 'hari'])->first()];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JadwalPelajaran  $jadwal_pelajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalPelajaran $jadwal_pelajaran)
    {
        //
        $jadwal_pelajaran->delete();
        return ['status' => true, 'msg' => "Jadwal telah dihapus"];
    }
}
