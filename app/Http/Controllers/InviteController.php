<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invite;
use App\Models\Agent;
use Illuminate\Support\Str;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
{
    public function invite()
    {
        return view('invite');
    }
    public function process(Request $request)
    {
        do {
            $token = Str::random(12);
        } 
        while (Invite::where('token', $token)->first());
        $agent_id = Auth::guard('agent')->user()->id;
        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token,
            'agent_id' => $agent_id
        ]);
        Mail::to($request->get('email'))->send(new InviteCreated($invite));
        return redirect()->back();
    }
    public function accept($token)
    {
    if (!$invite = Invite::where('token', $token)->first()) {
        abort(404);
    }
    $agent = Agent::where('id',$invite->agent_id)->first()->name;
    return $agent;
    }
}
