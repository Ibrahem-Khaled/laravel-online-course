<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\CourseVideo;
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

        $comment = VideoDiscussion::create([
            'course_video_id' => $request->input('video_id'),
            'user_id' => auth()->user()->id,
            'body' => $request->input('body'),
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'user_image' => $comment->user->image
                    ? asset('storage/' . $comment->user->image)
                    : ($comment->user->userInfo?->gender == 'female'
                        ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                        : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png'),
                'user_name' => $comment->user->name,
                'created_at' => $comment->created_at->locale('ar')->diffForHumans(),
                'body' => $comment->body,
            ],
        ]);
    }

    public function homeworkReply(Request $request, $id)
    {
        $homework = VideoHomeWork::findOrFail($id);

        $homework->update([
            'reply' => $request->reply,
            'rating' => $request->rating,
        ]);

        return response()->json(['success' => true, 'message' => 'تم إرسال التقييم بنجاح!']);
    }

    public function addVideoUsage(Request $request)
    {
        $request->validate([
            'course_video_id' => 'required|exists:course_videos,id',
            'usages.*.type' => 'required|in:software,attachment',
            'usages.*.title' => 'required|string|max:255',
            'usages.*.description' => 'nullable|string',
            'usages.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'usages.*.files.*' => 'nullable|mimes:pdf,doc,docx,zip,txt|max:5120',
        ]);

        foreach ($request->usages as $usage) {
            $imagePath = isset($usage['image']) ? $usage['image']->store('images', 'public') : null;
            $filePath = isset($usage['file']) ? $usage['file']->store('files', 'public') : null;


            inVideoUsage::create([
                'user_id' => auth()->id(),
                'course_video_id' => $request->course_video_id,
                'type' => $usage['type'],
                'title' => $usage['title'],
                'description' => $usage['description'],
                'image' => $imagePath,
                'file' => $filePath,
            ]);
        }

        return redirect()->back()->with('success', 'تمت الإضافة بنجاح!');
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $video = CourseVideo::findOrFail($id);
        $video->question = $request->question;
        $video->save();

        return redirect()->back()->with('success', 'تم تحديث سؤال الواجب بنجاح.');
    }


}
