<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Testing;
use Illuminate\Http\Request;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Testing::latest()->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $test = $user->tests()->create($request->all());
        return response()->json(['message' => 'Creating success', 'data' => $test]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = tap(Testing::find($id))->update([
            'title' => $request->title,
            'questions' => $request->questions,
            'time' => $request->time,
        ]);
        return response()->json(['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = auth()->user()->tests()->delete($id);
        Rating::where([
            ['work_id', $id],
            ['work_type', 'test']
        ])->delete();
        return response()->json(['id' => $data]);
    }
}
