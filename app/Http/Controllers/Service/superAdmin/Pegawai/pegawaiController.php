<?php

namespace App\Http\Controllers\Service\superadmin\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Models
use App\Models\Pegawai\pegawai;

class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = pegawai::paginate(20);
        return view('components.superadmin.DataPegawai.dataPegawai', compact('getData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
