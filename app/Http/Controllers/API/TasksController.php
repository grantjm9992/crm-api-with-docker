<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;
use Validator;
use App\Http\Resources\Task as TaskResource;
   
class TasksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::whereRaw($this->makeWhere($request));    
        return $this->sendResponse(TaskResource::collection($tasks->get()), 'Task retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $task = Task::create($input);
   
        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
  
        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }
   
        return $this->sendResponse(new TaskResource($task), 'Task retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $input = $request->all();
   
        $task->update($input);
   
        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
   
        return $this->sendResponse([], 'Task deleted successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function makeWhere(Request $request)
    {
        $where = '1 = 1';
        if ($request)
        {
            if ($request->important) $where .= ' AND important = 1 ';
            if ($request->starred) $where .= ' AND starred = 1 ';
        }
        return $where;
    }

    /**
     * Update task order
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateTaskOrder(Request $request)
    {
        $taskArray = $request->all();
        $counter = 1;
        foreach ($taskArray as $task) {
            $task = Task::find($task['id']);
            $task->order = $counter;
            $task->save();
            $counter++;
        }

        return $this->sendResponse('Order updated correctly', 200);
    }
}