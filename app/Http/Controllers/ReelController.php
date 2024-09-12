<?php

namespace App\Http\Controllers;
use App\Models\Reel;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Reel::all();

        return response()->json(['reel' => $reels]);
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255' ,
            'video' => 'required|mimes:mp4,mov,avi|max:20480' 
        ]);

        $video = $request->file('video');

        $fileName = time() . '.' . $video->getClientOriginalExtension();
        $video->move(public_path('uploads/reels'), $fileName);

        $reel = new Reel();
        $reel->title = $request->input('title');
        $reel->description = $request->input('description');
        $reel->video_path = 'uploads/reels/' . $fileName;
        $reel->save();

        return response()->json(['message' => 'Reel uploaded successfully']);
    }
}
