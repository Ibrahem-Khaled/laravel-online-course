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
        $video->load('homeWorks.user.userInfo', 'videoDiscussions.user.userInfo', 'videoUsage', 'histories');
        // حساب ترتيب الفيديو الحالي في قائمة الفيديوهات
        $currentVideoIndex = $course->videos->search(function ($v) use ($video) {
            return $v->id === $video->id;
        }) + 1;

        // حساب نسبة الإنجاز
        $completedVideosCount = 0;

        $totalVideos = $course->videos->count();
        $progress = $totalVideos > 0 ? ($completedVideosCount / $totalVideos) * 100 : 0;

        // حساب عدد الواجبات غير المكتملة
        $unresolvedHomeworksCount = $video->homeWorks()
            ->whereNull('reply')
            ->WhereNull('rating')
            ->count();

        $userCanUploadHomework = !$video->homeWorks()->where('user_id', auth()->id())->exists();

        $videoData = array_merge($video->toArray(), [
            'unresolvedHomeworksCount' => $unresolvedHomeworksCount,
            'userCanUploadHomework' => $userCanUploadHomework,
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
