<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\inVideoUsage;
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

    public function addVideoUsage(Request $request)
    {
        $request->validate([
            'course_video_id' => 'required|exists:course_videos,id',
            'type' => 'required|in:software,attachment',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file' => 'nullable|mimes:pdf,doc,docx,zip|max:5120',
        ]);

        // رفع الملفات (إن وجد)
        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;
        $filePath = $request->file('file') ? $request->file('file')->store('files', 'public') : null;

        // حفظ البيانات
        inVideoUsage::create([
            'user_id' => auth()->user()->id,
            'course_video_id' => $request->course_video_id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'file' => $filePath,
        ]);

        return redirect()->back()->with('success', 'تمت الإضافة بنجاح!');
    }


}
