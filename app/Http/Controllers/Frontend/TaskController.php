<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function view(){
        $tasks = Task::orderBy('order', 'ASC')->get();
        return view('frontend.tasks.view', compact('tasks'));
    }
    public function index(){
        return view('frontend.tasks.create');
    }
}
