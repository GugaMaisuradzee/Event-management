<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index','show']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events =  EventResource::collection(Event::with('user')->get());

        return response()->json([
           'events' => $events,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_time'
            ]),
            'user_id' => $request->user()->id
        ]);

        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('user','attendees');
        return new UserResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event): JsonResponse
    {
         Event::query()->update($request->validated());

        return response()->json([
            'event' => $event
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response(status: 204);
    }
}
