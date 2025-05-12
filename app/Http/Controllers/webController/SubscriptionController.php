<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(Course $course)
    {
        // التحقق من أن المستخدم مسجل دخول
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $user = Auth::user();

        // التحقق من أن المستخدم غير مشترك بالفعل في هذه الدورة
        $existingSubscription = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'أنت مشترك بالفعل في هذه الدورة'
            ], 400);
        }

        try {
            // إنشاء اشتراك جديد
            $subscription = new UserCourse();
            $subscription->user_id = $user->id;
            $subscription->course_id = $course->id;
            $subscription->subscription_date = now();
            $subscription->is_active = '1'; // أو true
            $subscription->save();

            // يمكنك إضافة أي عمليات إضافية هنا مثل إرسال بريد إلكتروني

            return response()->json([
                'success' => true,
                'message' => 'تم الاشتراك في الدورة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الاشتراك: ' . $e->getMessage()
            ], 500);
        }
    }

    // إلغاء اشتراك الدورة
    public function unsubscribe(Course $course)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $user = Auth::user();

        $subscription = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على اشتراك'
            ], 404);
        }

        try {
            $subscription->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم إلغاء الاشتراك بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إلغاء الاشتراك: ' . $e->getMessage()
            ], 500);
        }
    }

    // عرض جميع اشتراكات المستخدم
    // public function userSubscriptions()
    // {
    //     $user = Auth::user();
    //     $subscriptions = $user->subscriptions()->with('course')->get();

    //     return view('subscriptions.index', compact('subscriptions'));
    // }
}
