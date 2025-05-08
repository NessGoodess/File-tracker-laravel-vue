<?php

namespace App\Http\Controllers;

use App\Models\activity;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $activity = activity::orderBy('created_at', 'desc')->get();
        return Inertia::render('Documents/ActivityList', [
            'activities' => $activity,
        ]);
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
    public function show(activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(activity $activity)
    {
        //
    }
}
