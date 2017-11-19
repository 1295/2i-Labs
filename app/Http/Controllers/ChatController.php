<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = Chat::all();
        return response()->json([
            'chats'    => $chats,
        ], 200);
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
        $this->validate($request, [
            'first_name'  => 'required|max:255',
            'last_name'  => 'required|max:255',
            'messenger_user_id'=> 'required|max:255',
            'chat_message' => 'required',
        ]);
        $chat =  new Chat;
        $chat->first_name = $request->first_name;
        $chat->last_name = $request->last_name;
        $chat->fb_id = $request->messenger_user_id;
        $chat->message = $request->chat_message;
        $chat->save();
      
        return response()>json([
            'chat'    => $chat,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        $chats = Chat::where('fb_id', '$chat->fb_id')->get();
        return response()->json([
            'chats'    => $chats,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */

    
    public function update(Request $request, Chat $chat)
    {
        $this->validate($request, [
        'first_name'  => 'required|max:255',
        'last_name'  => 'required|max:255',
        'messenger_user_id'=> 'required|max:255',
        'chat_message' => 'required',
        ]);
 
        $chat->first_name = $request->first_name;
        $chat->last_name = $request->last_name;
        $chat->fb_id = $request->messenger_user_id;
        $chat->message = $request->chat_message;
        $chat->save();
 
        return response()->json([
            'message' => 'Task updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
