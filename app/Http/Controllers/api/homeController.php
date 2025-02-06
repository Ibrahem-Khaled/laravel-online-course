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
        $completedVideosCount = 0;

        $totalVideos = $course->videos->count();
        $progress = $totalVideos > 0 ? ($completedVideosCount / $totalVideos) * 100 : 0;


        VideoHistory::updateOrCreate(
            ['user_id' => Auth::user()?->id, 'course_video_id' => $video->id],
            [
                'last_viewed_time' => now(), // تحديث آخر وقت مشاهدة
            ]
        );

        $videoHistories = auth()->user()
            ->videoHistories()
            ->select('video_histories.*') // جلب كل الحقول
            ->distinct('course_video_id') // تجنب تكرار الفيديو
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
            'videoHistory' => $videoHistories
        ]);


        // إرجاع البيانات كـ JSON
        return response()->json([
            'video' => $videoData,
            'progress' => $progress,
            'currentVideoIndex' => $currentVideoIndex,
            'totalVideos' => $totalVideos,
        ]);
    }
}
