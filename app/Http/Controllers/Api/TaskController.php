<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskFormValidation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class TaskController extends Controller
{
    public function createTask(TaskFormValidation $request){
        try{
            $header = $request->header('Authorization');
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $order_no = Task::orderBy('order', 'DESC')->pluck('order')->first();
            if($order_no == 'none' or $order_no == ""){
                #If Table is Empty
                $order_no = 0;
            }
            else{
                #If Table has Already some Data
                $order_no = $order_no + 1;
            }
            $task->order = $order_no;
            $task->user_id = request()->user()->id;
            if($header){
            $task_save = $task->save();
            }
            if($task_save){
                $response = ["success" => "true" ,"message" => 'Task Added Successfully!', 'status' => 201];
                return response($response, 201);
            }
            else{
                $response = ["success" => "false" ,"message" => 'Task Creation Failed!' , 'status' => 400];
                return response()->json($response, 400);
            }
        }
        catch(Exception $e){
            return response()->json(['success' =>'false', 'message' => $e->getMessage()]);
        }
    }

    public function viewAllTasks(){
        $tasks = Task::orderBy('order', 'ASC')->get();
        return view('frontend.tasks.view', compact('tasks'));
    }

    public function update(TaskFormValidation $request, $id){
        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->order = $request->order;
        $task->save();
        if ($task) {
            $response = ["message" => 'Task Updated Successfully!', 'status' => 200];
            return response()->json($response, 200);
        }
        else{
            $response = ["message" => 'Task Updation Failed!' , 'status' => 404];
            return response()->json($response, 404);
        }
    }

    public function delete($id){
        if ($id && $id != '') $task = Task::find(decrypt($id));
        $order = $task->order;
            $delete_task = $task->delete();
            if($delete_task){
                Task::where('order','>', $order)->decrement('order');
                $response = ["message" => 'Task Deleted Successfully!', 'status' => 200];
                return response()->json($response, 200);
                // return redirect(route('view_tasks'))->with($response, 200);

            }
            else{
                $response = ["message" => 'Task Deletion Failed!' , 'status' => 404];
                return response()->json($response, 404);
            }
    }
    public function addStatus(Request $request){
        $status =  Task::find($request->id);
        $status->status = $request->status;
        $status->save();
        if ($status == 'Completed') {
         return response()->json([
             'success' => true,
             'message' => 'Completed'
         ]);
     }
     else {
         return response()->json([
             'error' => true,
             'message' => 'Pending'
         ]);
     }
     }

     public function updateOrder(Request $request)
    {
        foreach($request->get('order') as $id => $order) {

            $order_update = Task::find($id)->update(['order' => $order]);

        }

        if($order_update){
            $response = ["message" => 'Order Updated Successfully!', 'status' => 201];
            return response($response, 201);
        }
        else{
            $response = ["message" => 'Order Updation Failed!' , 'status' => 400];
            return response()->json($response, 400);
        }
    }
    public function myTasks(Request $request){
        $tasks = Task::where('user_id', $request->user()->id)->get();
        return response()->json(['tasks' => $tasks]);
    }
}
