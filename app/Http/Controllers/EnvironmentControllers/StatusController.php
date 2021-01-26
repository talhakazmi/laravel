<?php

namespace App\Http\Controllers\EnvironmentControllers;

use App\Filters\StatusFilter;
use App\Http\Controllers\Api\APIController;
use App\Http\Requests\Portal\NextStatusRequest;
use App\Http\Requests\Portal\StatusRequest;
use App\Http\Resources\Api\v1\Blogs as BlogResource;
use App\Http\Resources\Api\v1\NextStatus;
use App\Http\Resources\Api\v1\Statuses;
use App\Status;
use App\StatusNext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class StatusController extends APIController
{
    public function index(StatusFilter $filter)
    {
        if(request()->page){
            $status = Status::with('StatusFlow')->sortable()->filter($filter)->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $status = Status::all();
        }
        return $status;
    }
    public function store(StatusRequest $request)
    {
        Status::create($request->all());
        return response()->json(['success' => 'Status was added successfully']);
    }
    public function show(Status $status)
    {
        return response()->json($status);
    }
    public function update(StatusRequest $request, Status $status)
    {
        $status->fill($request->all());
        $status->save();
        return response()->json(['success' => 'Status was updated successfully']);
    }
    public function destroy(Status $status){
        if (!$this->willExtinct($status->status_type, $status->status_flow)) {
            $status->delete();
            return response()->json(['success' => 'Status was deleted successfully']);
        }else {
            return response()->json(['error' => 'Can\'t delete the last status of this type']);
        }
    }
    public function nextStatusList()
    {
        if (request()->statusID)
            $statusFlow =StatusNext::with(['StatusFrom', 'StatusTo'])->sortable()->where('FromStatus',request()->statusID)->orderBy('created_at', 'desc')->paginate(10);
        else
            $statusFlow =StatusNext::all();

	    return $statusFlow;
    }
    public function storeNextStatus(NextStatusRequest $request)
    {
        StatusNext::create($request->all());
        return response()->json(['success' => 'Status next was added successfully']);

    }
    public function editNextStatus($statusFlowID)
    {
        $statusFlow =StatusNext::find($statusFlowID);
        return response()->json($statusFlow);
    }
    public function updateNextStatus(NextStatusRequest $request, $nextStatusID)
    {
        $statusFlow = StatusNext::find($nextStatusID);
        $statusFlow->fill($request->all());
        $statusFlow->save();
        return response()->json(['success' => 'Status next was updated successfully']);
    }

    public function deleteNextStatus($nextStatusID)
    {
        $statusNext = StatusNext::find($nextStatusID);
        if ($statusNext)
        {
            $statusNext->delete();
            return response()->json(['success' => 'Status next was deleted successfully']);
        }
    }

    private function willExtinct($type, $flow){
        if (count(Status::where('status_type', $type)->where('status_flow', $flow)->get()) == 1)
        {
           return true;
        }else{
           return false;
        }
    }
}
