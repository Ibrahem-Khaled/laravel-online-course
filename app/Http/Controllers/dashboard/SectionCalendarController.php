<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Models\SectionCalendar;
use Illuminate\Http\Request;

class SectionCalendarController extends Controller
{
    // إنشاء جدول جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'course_id' => 'nullable|exists:courses,id',
            'day_number' => 'required|integer|min:1|max:7',
            'start_time' => 'nullable|required_with:course_id|date_format:H:i',
        ]);

        SectionCalendar::create($validated);

        return redirect()->back()->with('success', 'تمت إضافة الجدول بنجاح!');
    }

    // تعديل الجدول
    public function update(Request $request, $id)
    {
        $calendar = SectionCalendar::findOrFail($id);

        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'course_id' => 'nullable|exists:courses,id',
            'day_number' => 'required|integer|min:1|max:7',
            'start_time' => 'nullable|required_with:course_id|date_format:H:i',
        ]);

        $calendar->update($validated);

        return redirect()->back()->with('success', 'تم تعديل الجدول بنجاح!');
    }

    // حذف الجدول
    public function destroy($id)
    {
        $calendar = SectionCalendar::findOrFail($id);
        $calendar->delete();

        return redirect()->back()->with('success', 'تم حذف الجدول بنجاح!');
    }
}
