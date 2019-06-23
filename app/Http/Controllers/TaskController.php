<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;

class TaskController extends Controller
{
    public function index(int $id)
    {
        // 全てのフォルダを取得する
        $folders = Folder::all();
        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
     */
    public function create(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function store(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }
}
