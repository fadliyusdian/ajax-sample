<?php

namespace App\Http\Controllers;

use App\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mataPelajaran = MataPelajaran::all();
        return view('mapel', ['mapel' => $mataPelajaran]);
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
            'nama' => 'required|string',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $mapel = MataPelajaran::create([
            'nama' => $request->nama
        ]);

        return ['status' => true, 'msg' => "Mata Pelajaran telah telah ditambahkan", 'data' => $mapel];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MataPelajaran  $mataPelajaran
     * @return \Illuminate\Http\Response
     */
    public function show(MataPelajaran $mapel)
    {
        //
        return $mapel;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\MataPelajaran $mapel
     * @return \Illuminate\Http\Response
     */
    public function edit(MataPelajaran $mapel)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\MataPelajaran $mapel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MataPelajaran $mapel)
    {
        //
        $validator = Validator::make($request->all() , [
            'nama' => 'required|string',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $mapel->update([
            'nama' => $request->nama,
        ]);

        return ['status' => true, 'msg' => "Mapel ".$mapel->nama." telah diperbaharui", "data" => $mapel];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MataPelajaran  $mataPelajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(MataPelajaran $mapel)
    {
        //
        $mapel->delete();
        return ['status' => true, 'msg' => "Mata Pelajaran telah dihapus"];
    }
}
