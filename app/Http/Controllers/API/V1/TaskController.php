<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate(10);
        if(count($tasks)>0){
            return response()->json([
                'status' => 200,
                'task' => $tasks
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'task' => 'No tasks available'
            ],404);
        }
        
       
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'required|max:250',
            'type' => 'required',

        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        }
        $input = $request->all();
        if($request->hasFile('image'))
        {
            $image=$request->file('image');
            if ($image){
                $rand_val           = date('YMDHIS') . rand(11111, 99999);
                $image_file_name    = md5($rand_val);
                $file               = $image;
                $fileName           = $image_file_name.'.'.$file->getClientOriginalExtension();
                $path               = $request->file('image')->storeAs('uploads',$fileName);
                $input['image']     = $fileName ;
            }
        }
        $task =  Task::create($input);
        if($task){
            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully',
                'data' => ['name' => $task->name, 'description' => $task->description,'type'=>$task->type]
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong'
            ],500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = Task::findOrFail($id);
        if($tasks){
            return response()->json([
                'status' => 200,
                'task' => ['name'=>$tasks->name,'description'=>$tasks->description,'image_url'=> asset('app/uploads').'/'.$tasks->image,'type'=>$tasks->type]
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'task' => 'No tasks available'
            ],404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}