<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\VideoHomeWork;
use App\Models\VideoDiscussion;
use Illuminate\Http\Request;

class videoCourseController extends Controller
{
    public function addHomework(Request $request)
    {
        $request->validate([
            'file' => 'nullable|file',
            'text' => 'required|string',
        ]);

        $file = $request->file('file');
        $filename = null;

        if ($file) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        $homework = VideoHomeWork::create([
            'course_videos_id' => $request->input('course_videos_id'),
            'user_id' => auth()->user()->id,
            'file' => $filename,
            'text' => $request->input('text'),
        ]);

        return redirect()->back()->with('success', 'تم اضافة المهمة بنجاح');
    }

    public function videoDiscssion(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        VideoDiscussion::create([
            'course_video_id' => $request->input('video_id'),
            'user_id' => auth()->user()->id,
            'body' => $request->input('body'),
        ]);

        return redirect()->back()->with('success', 'تم اضافة التعليق بنجاح');
    }


}
