<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function allTask()
    {
        $tasks = Task::all();
        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ], 200);
    }

    public function addTask(Request $request)
    {
        $userId = $request->get('user_id');

        #check if user is authenticated
        if (!$userId) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized'
            ], 401);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $userId
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task added successfully',
        ], 200);
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Task not found'
            ], 404);
        }

        // Only update allowed fields
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        $task->update($validated); // no need to call save()

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
        ], 200);
    }
}
