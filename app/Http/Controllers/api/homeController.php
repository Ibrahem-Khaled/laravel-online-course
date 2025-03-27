<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\VideoHistory;
use Auth;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function getVideoData(Course $course, CourseVideo $video)
    {
        $video->load('homeWorks.user.userInfo', 'videoDiscussions.user.userInfo', 'videoUsage');

        // حساب ترتيب الفيديو الحالي في قائمة الفيديوهات
        $currentVideoIndex = $course->videos->search(function ($v) use ($video) {
            return $v->id === $video->id;
        }) + 1;

        // حساب نسبة الإنجاز
        $completedVideosCount = VideoHistory::where('user_id', auth()->id())
            ->whereIn('course_video_id', $course->videos->pluck('id'))
            ->where('completed', true)
            ->count();

        $totalVideos = $course->videos->count();
        $progress = $totalVideos > 0 ? ($completedVideosCount / $totalVideos) * 100 : 0;

        $histories = VideoHistory::where('user_id', auth()->id())
            ->whereIn('course_video_id', $course->videos->pluck('id'))
            ->get();

        // حساب عدد الواجبات غير المكتملة
        $unresolvedHomeworksCount = $video->homeWorks()
            ->whereNull('reply')
            ->WhereNull('rating')
            ->count();

        $userCanUploadHomework = !$video->homeWorks()->where('user_id', Auth::user()?->id)->exists();
        $videoInUsageCount = $video->videoUsage()->count();

        $videoData = array_merge($video->toArray(), [
            'unresolvedHomeworksCount' => $unresolvedHomeworksCount,
            'userCanUploadHomework' => $userCanUploadHomework,
            'videoInUsageCount' => $videoInUsageCount,
            'videoHistories' => $histories
        ]);


        // إرجاع البيانات كـ JSON
        return response()->json([
            'video' => $videoData,
            'progress' => $progress,
            'currentVideoIndex' => $currentVideoIndex,
            'totalVideos' => $totalVideos,
        ]);
    }

    public function getVideoHistory(CourseVideo $video)
    {
        $history = VideoHistory::firstOrCreate([
            'user_id' => auth()->id(),
            'course_video_id' => $video->id,
        ]);

        return response()->json($history);
    }

    public function getLastWatchedVideo()
    {
        $user = auth()->user();

        $lastWatched = VideoHistory::where('user_id', $user->id)
            ->whereNotNull('last_viewed_time')
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json($lastWatched);
    }

    public function updateProgress(CourseVideo $video, Request $request)
    {
        $time = $request->input('time');

        $history = VideoHistory::updateOrCreate(
            ['user_id' => auth()->id(), 'course_video_id' => $video->id],
            ['last_viewed_time' => gmdate("H:i:s", $time)]
        );

        return response()->json(['success' => true, 'history' => $history]);
    }

    public function complete(CourseVideo $video)
    {
        $history = VideoHistory::where('user_id', auth()->id())
            ->where('course_video_id', $video->id)
            ->update([
                'completed' => true,
                'completed_at' => now(),
            ]);
        return response()->json(['success' => true]);
    }
}
