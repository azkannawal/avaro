<?php

namespace App\Http\Controllers\Service\superadmin\Kendaraan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Models
use App\Models\Kendaraan\driver;

class driverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = driver::paginate(20);
        return view('components.superadmin.Driver.driver', compact('getData'));
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
