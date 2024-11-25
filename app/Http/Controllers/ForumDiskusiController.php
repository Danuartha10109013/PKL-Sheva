<?php

namespace App\Http\Controllers;

use App\Models\ChatM;
use App\Models\forumM;
use App\Models\ProjectM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ForumDiskusiController
{
    public function pm()
{
    $id = Auth::user()->id;

    // Check the current route and fetch data accordingly
    if (Route::currentRouteName() == 'team_lead.project.forum') {
        $data = ProjectM::where('team_leader_id', $id)->get();
    } else {
        $data = ProjectM::all();
    }

    return view('page.fourm_diskusi.pm', compact('data'));
}


    public function index($id){
        $project = ProjectM::find($id);
        $ids = forumM::where('project_id',$id)->value('id');
        $forum = forumM::find($ids);
        $chat = ChatM::where('forum_id',$forum->id)->get();
        // dd($forum);
        return view('page.fourm_diskusi.index',compact('project','forum','chat'));
    }
    public function message(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,pdf,doc,docx', // Add valid file types
        ]);
    
        // Create a new chat instance
        $chat = new ChatM();
        $chat->chat = $request->message;
        $chat->forum_id = $id; // Assuming project_id is passed as $id
        $chat->user_id = Auth::user()->id;
    
        // Handle file upload if it exists
        if ($request->hasFile('file')) {
            // Get the original name of the file
            $originalName = $request->file('file')->getClientOriginalName();
    
            // Store the file in the public/storage/chat directory with its original name
            $filePath = $request->file('file')->storeAs('chat', $originalName, 'public');
    
            // Save the original name to the database
            $chat->file = $originalName;
        }
    
        // Save the chat instance
        $chat->save();
    
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    

}
