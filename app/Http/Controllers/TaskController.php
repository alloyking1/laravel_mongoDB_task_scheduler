<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('email', auth()->user()->email)->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'reminder_time' => 'required|date',
        ]);

        $data = $request->all();
        $data['due_date'] = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s');
        $data['reminder_time'] = \Carbon\Carbon::parse($request->reminder_time)->format('Y-m-d H:i:s');
        $data['email'] = auth()->user()->email;

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
        $tasks = Task::where('id', $id)->get();

        return view('tasks.edit', ['tasks' => $tasks]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->all();
        $data['due_date'] = \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s');
        $data['reminder_time'] = \Carbon\Carbon::parse($request->reminder_time)->format('Y-m-d H:i:s');

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
