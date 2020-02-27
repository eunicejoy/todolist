<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Validator;
use DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tasks = Task::where('user_id',$request->user()->id)->orderBy('created_at','desc')->paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        //return $request;

        $validator = Validator::make($request->all(), [
            'taskname' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $request->user()->tasks()->create([
            'name' => $request->taskname
        ]);

        return redirect('/');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->taskid;
        $task  = $request->task;

        DB::update('update tasks set name = ? where id = ?',[$task,$id]);
        return redirect ('/');
    }
}
