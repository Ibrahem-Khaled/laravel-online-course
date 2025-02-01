<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\VideoHistory;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function getVideoData(Course $course, CourseVideo $video)
    {
        // حساب ترتيب الفيديو الحالي في قائمة الفيديوهات
        $currentVideoIndex = $course->videos->search(function ($v) use ($video) {
            return $v->id === $video->id;
        }) + 1;

        // حساب نسبة الإنجاز
        $completedVideosCount = 0;

        $totalVideos = $course->videos->count();
        $progress = $totalVideos > 0 ? ($completedVideosCount / $totalVideos) * 100 : 0;

        // تحديث تاريخ مشاهدة الفيديو
        // VideoHistory::updateOrCreate(
        //     ['user_id' => auth()->id(), 'course_video_id' => $video->id],
        //     ['last_viewed_time' => now()]
        // );

        // حساب عدد الواجبات غير المكتملة
        $unresolvedHomeworksCount = $video->homeWorks()
            ->whereNull('reply')
            ->WhereNull('rating')
            ->count();

        // إرجاع البيانات كـ JSON
        return response()->json([
            'video' => $video,
            'progress' => $progress,
            'currentVideoIndex' => $currentVideoIndex,
            'totalVideos' => $totalVideos,
            'unresolvedHomeworksCount' => $unresolvedHomeworksCount,
        ]);
    }
}
