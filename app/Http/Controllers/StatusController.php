<?php

namespace App\Http\Controllers;

use App\Http\Requests\Status\StatusCheckRequest;
use App\Models\User;

class StatusController extends Controller
{
    public function statusCheck(StatusCheckRequest $request)
    {
        $userWithAppointment = null;
        if ($nid = $request->input('nid')) {
            $userWithAppointment = User::query()
                ->where('nid', $nid)
                ->with('appointment')
                ->first();
        }

        return view('status.status')->with([
            'user' => $userWithAppointment,
        ]);
    }
}
