<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{

    public function index()
    {
        $statuses = Status::all();
        return $this->success(StatusResource::collection($statuses));
    }

    public function show(Status $status)
    {
        return $this->success(new StatusResource($status));
    }

    public function store(StatusStoreRequest $request)
    {

        $status = Status::query()->create([
            'name' => $request->get('name'),
        ]);

        Log::query()->create([
            'user_id' => auth()->user(),
            'action' => 'store',
            'description' => 'a status is stored'
        ]);

        return $this->success(new StatusResource($status));

    }

    public function update(StatusUpdateRequest $request, Status $status)
    {
        $status->update([
            'name' => $request->get('name'),
        ]);

        Log::query()->create([
            'user_id' => auth()->user(),
            'action' => 'update',
            'description' => 'a status is updated'
        ]);

        return $this->success(new StatusResource($status));
    }

    public function destroy(Status $status)
    {
        if ($status->products()->count())
        {
            return $this->error("status is used by some products");
        }

        $status->delete();

        Log::query()->create([
            'user_id' => auth()->user(),
            'action' => 'destroy',
            'description' => 'a status is destroyed'
        ]);

        return $this->success("the status is deleted");

    }

}
