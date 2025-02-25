<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\CourseVideo;
use App\Models\inVideoUsage;
use App\Models\VideoHomeWork;
use App\Models\VideoDiscussion;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $homework->load('user');
        NotificationService::createNotification(
            auth()->user()->id,
            $homework->courseVideos->course->user_id,
            'VideoHomeWork',
            auth()->user()->name . ' قام بتسليم واجب في الفيديو ' . $homework->courseVideos->title
        );

        return response()->json($homework);
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

        $comment->load('user');

        NotificationService::createNotification(
            auth()->user()->id,
            $comment->courseVideo->course->user_id,
            'VideoDiscussion',
            auth()->user()->name . ' قام بتعليق في الفيديو ' . $comment->courseVideo->title
        );

        return response()->json(
            $comment,
        );
    }
    public function updateVideoDiscssion(Request $request, $id)
    {
        $comment = VideoDiscussion::findOrFail($id);
        $comment->body = $request->body;
        $comment->save();

        return response()->json(['success' => true, 'message' => 'تم تعديل التعليق بنجاح!']);
    }
    public function deleteVideoDiscssion($id)
    {
        $comment = VideoDiscussion::findOrFail($id);
        $comment->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف التعليق بنجاح!']);
    }

    public function homeworkReply(Request $request, $id)
    {
        $homework = VideoHomeWork::findOrFail($id);

        $homework->update([
            'reply' => $request->reply,
            'rating' => $request->rating,
        ]);

        NotificationService::createNotification(
            auth()->user()->id,
            $homework->user_id,
            'VideoHomeWork',
            auth()->user()->name . ' قام برد على واجب في الفيديو ' . $homework->courseVideos->title
        );

        return response()->json(['success' => true, 'message' => 'تم الرد على الواجب بنجاح!']);
    }

    public function updateHomework(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string',
            'file' => 'nullable|file',
        ]);

        $homework = VideoHomeWork::findOrFail($id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $homework->file = $filename;
        }

        $homework->text = $request->input('text');
        $homework->save();

        NotificationService::createNotification(
            auth()->user()->id,
            $homework->courseVideos->course->user_id,
            'VideoHomeWork',
            auth()->user()->name . ' قام بتحديث واجب في الفيديو ' . $homework->courseVideos->title
        );

        return redirect()->back()->with('success', 'تم تحديث الواجب بنجاح');
    }

    public function deleteHomework($id)
    {
        $homework = VideoHomeWork::findOrFail($id);
        $homework->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف الواجب بنجاح!']);
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


            $usage = inVideoUsage::create([
                'user_id' => auth()->id(),
                'course_video_id' => $request->course_video_id,
                'type' => $usage['type'],
                'title' => $usage['title'],
                'description' => $usage['description'],
                'image' => $imagePath,
                'file' => $filePath,
            ]);
        }

        return response()->json($usage);
    }

    public function destroyVideoUsage($id)
    {
        // البحث عن العنصر
        $videoUsage = inVideoUsage::findOrFail($id);
        if ($videoUsage->file) {
            Storage::delete($videoUsage->file);
        }
        $videoUsage->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف العنصر بنجاح!']);
    }

    public function updateDescription(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $video = CourseVideo::findOrFail($id);
        $video->description = $request->description;
        $video->save();

        return redirect()->back()->with('success', 'تم تحديث وصف الفيديو بنجاح.');
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $video = CourseVideo::findOrFail($id);
        $video->question = $request->question;
        $video->save();

        return response()->json(['success' => true, 'message' => 'تم تحديث السؤال بنجاح!']);
    }


}
