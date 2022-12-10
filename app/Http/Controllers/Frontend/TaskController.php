<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function view(){
            return view('home');
    }
    public function index(){
        return view('frontend.tasks.create');
    }
    public function myTasksIndex(){
        return view('frontend.tasks.mytasks');
    }
}
