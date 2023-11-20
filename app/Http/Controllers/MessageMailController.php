<?php

namespace App\Http\Controllers;

use App\Models\MessageMail;
use Illuminate\Http\Request;

class MessageMailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Let's get all messages Mails
        $messages = MessageMail::orderBy('code_name')->paginate(10);
        //let's return a view
        return view('messagesMails.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'code_name'=> 'required|unique:message_mails|max:100',
            'type' => 'required|max:255',
            'object'=> 'required|max:255',
            'body'=>'required',
        ]);

        MessageMail::create([
            'code_name'=>$request->code_name,
            'type'=>$request->type,
            'object'=>$request->object,
            'body'=>$request->body,
            'action'=>$request->action?true:false,
            'attachement'=>$request->attachement?true:false
        ]);

        return redirect()->back();
        
    }

    /**
     * Display the specified resource.
     */
    public function show(MessageMail $messageMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MessageMail $messageMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $messageMail)
    {
        //
        $messageMail = MessageMail::find($messageMail);

        $request->validate([
            'code_name'=> 'required|max:100',
            'type' => 'required|max:255',
            'object'=> 'required|max:255',
            'body'=>'required',
        ]);
        
        $messageMail->update([
            'code_name'=>$request->code_name,
            'type'=>$request->type,
            'object'=>$request->object,
            'body'=>$request->body,
            'action'=>$request->action?true:false,
            'attachement'=>$request->attachement?true:false
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $messageMail)
    {
        //
        $messageMail = MessageMail::find($messageMail);
        
        $messageMail->delete();

        return redirect()->back();
    }
}
