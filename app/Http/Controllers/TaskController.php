<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use Validator;
use DB;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tasks = Task::where('user_id',$request->user()->id)->where('is_finished','0')->orderBy('created_at','desc')->paginate(5);

        $tasks_done = Task::where('user_id',$request->user()->id)->where('is_finished','1')->orderBy('created_at','desc')->paginate(5);

        return view('tasks.index', compact('tasks','tasks_done'));
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

        $task_updated = Task::updateorCreate(['id' => $id],
        ['name' => $task ]
        );

        return redirect ('/');
    }

    public function finished(Request $request)
    {
        $finished_at = Carbon::now()->toDateTimeString();
        $id = $request->id;

        $task_finished= Task::updateorCreate(['id' => $id], //where
        ['is_finished' => 1, 'finished_at' => $finished_at] //set
        );

        return redirect ('/');
    }
}
