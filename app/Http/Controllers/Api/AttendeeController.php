<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{

    public function index(Event $event)
    {
        $attendee = $event->attendees()->latest();

        return AttendeeResource::collection(
            $attendee->paginate()
        );
    }

    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id' => $request->user()->id
        ]);

        return new AttendeeResource($attendee);
    }

    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($attendee);
    }

    public function destroy(string $event, Attendee $attendee)
    {
        $attendee->delete();

        return response(status: 204);
    }
}
