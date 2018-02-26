<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
        return view('todos.index',compact('todos'));
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
        request()->validate([
            'title' => 'required',
        ]);
        $todo = Todo::create($request->all());
        $message = 'Todo added successfully';
        $status = 'success';
        return response()->json([
            'todo' => $todo, 
            'message' => $message, 
            'alert-type' => $status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        return view('todos.index',compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::find($id);
        return view('todos.index',compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => 'required',
        ]);
        $todo = Todo::find($id)->update($request->all());
        $message = 'Todo updated successfully';
        $status = 'success';
        return response()->json([
            'todo' => $todo, 
            'message' => $message, 
            'alert-type' => $status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id)->delete();
        $message = 'Todo deleted successfully';
        $status = 'success';
        return response()->json([
            'todo' => $todo, 
            'message' => $message, 
            'alert-type' => $status
        ]);
    }

    /**
     * Change the completed status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');
        $todo = Todo::find($id);
        $todo->is_complete = !$todo->is_complete;
        $todo->save();

        $message = 'Todo updated successfully';
        $status = 'success';
        return response()->json([
            'todo' => $todo, 
            'message' => $message, 
            'alert-type' => $status
        ]);
    }
}
