<?php

namespace App\Services;

use App\Models\Calendar;
use Inertia\Inertia;

class CalendarServices
{
    public function createCalendarItem($res)
    {
        Calendar::create([
            'start_date' => $res['date'][0],
            'end_date' => $res['date'][1],
            'title' => $res['title'],
            'type' => $res['type'],
        ]);
        return to_route('calendar.index');
    }

    public function createCalendarItemBsed($res)
    {
        Calendar::create([
            'start_date' => $res['date'][0],
            'end_date' => $res['date'][1],
            'title' => $res['title'],
            'type' => $res['type'],
        ]);
        return to_route('calendar-bsed.indexBsed');
    }

    public function updateCalendarItem($res, $id): \Illuminate\Http\RedirectResponse
    {
        Calendar::findOrFail($id)->update([
            'start_date' => $res['date'][0],
            'end_date' => $res['date'][1],
            'title' => $res['title'],
            'type' => $res['type'],
        ]);
        return to_route('calendar.index');
    }

    public function updateCalendarItemBsed($res, $id): \Illuminate\Http\RedirectResponse
    {
        Calendar::findOrFail($id)->update([
            'start_date' => $res['date'][0],
            'end_date' => $res['date'][1],
            'title' => $res['title'],
            'type' => $res['type'],
        ]);
        return to_route('calendar-bsed.indexBsed');
    }

}
