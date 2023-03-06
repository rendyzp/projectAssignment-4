<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreSubtaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = auth()->user();

        $subtask = $user->subtasks()->create([
            'task_id' => $id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Successfully add subtask',
            'data' => $subtask,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function show(Subtask $subtask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function edit(Subtask $subtask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubtaskRequest  $request
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $subtask = Subtask::find($id);
        $subtask->title = $request->title;
        $subtask->description = $request->description;
        $subtask->save();

        return response()->json([
            'message' => 'Successfully update subtask',
            'data' => $subtask,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subtask = Subtask::find($id);
        $subtask->delete();

        return response()->json([
            'message' => 'Successfully delete subtask',
            'data' => $subtask,
        ]);
    }
}
