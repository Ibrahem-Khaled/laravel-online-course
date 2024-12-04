<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    thead tr {
        background-color: #06455E;
        color: white;
        text-transform: uppercase;
    }

    tbody tr:nth-child(even) {
        background-color: #072D38;
        transition: background-color 0.3s ease-in-out;
    }

    tbody tr:nth-child(odd) {
        background-color: #01586F;
        transition: background-color 0.3s ease-in-out;
    }

    tbody tr:hover {
        background-color: #0A6B82;
        color: #fff;
        transform: scale(1.02);
    }

    th,
    td {
        padding: 15px;
        text-align: center;
        border: 1px solid #06455E;
        font-size: 14px;
    }

    th {
        font-size: 16px;
        font-weight: bold;
    }

    td {
        font-size: 14px;
    }

    /* الزر أسفل الجدول */
    button {
        background-color: #06455E;
        color: #00AA25;
        padding: 12px 20px;
        border: none;
        border-radius: 25px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
</style>

<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: center; direction: rtl;">
        <thead>
            <tr>
                <th>اسم الطالب</th>
                <th>المدرب</th>
                <th>درجة الطالب</th>
                <th>التقييم</th>
                @if (Auth::user()->role == 'teacher')
                    <th>تعديل البيانات</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                @php
                    $sumUserReport = $student->userReports->last()
                        ? $student->userReports->last()->attendance +
                            $student->userReports->last()->reactivity +
                            $student->userReports->last()->homework +
                            $student->userReports->last()->completion +
                            $student->userReports->last()->creativity +
                            $student->userReports->last()->ethics
                        : 0;
                @endphp
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>أ/ {{ $trainer->name }}</td>
                    <td>{{ $student->userReports->last() ? $sumUserReport . '/60' : 'لا يوجد تقييم' }}</td>
                    <td>
                        @if ($sumUserReport >= 51)
                            <!-- 85% من 60 -->
                            ممتاز
                        @elseif ($sumUserReport >= 45)
                            <!-- 75% من 60 -->
                            جيد جدًا
                        @elseif ($sumUserReport >= 39)
                            <!-- 65% من 60 -->
                            جيد
                        @elseif ($sumUserReport >= 30)
                            <!-- 50% من 60 -->
                            مقبول
                        @else
                            دون المستوى
                        @endif
                    </td>

                    @if (Auth::user()->role == 'teacher')
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#editStudentModal{{ $student->id }}">تعديل البيانات</button>
                        </td>
                    @endif
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1"
                    aria-labelledby="editStudentLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content"
                            style="background-color: #072D38; color: white; border-radius: 10px;">
                            <div class="modal-header" style="background-color: #06455E; color: white;">
                                <h5 class="modal-title" id="editStudentLabel">
                                    تعديل بيانات الطالب: <span style="color: #F48140;">{{ $student->name }}</span>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <h6>تفاصيل الطالب:</h6>
                                    <p>اسم الطالب: <strong>{{ $student->name }}</strong></p>
                                    <p>آخر تقييم:
                                        <strong>{{ $student->userReports->last() ? $sumUserReport . '/60' : 'لا يوجد تقييم' }}</strong>
                                    </p>
                                </div>
                                <form action="{{ route('update-user-reports', $student->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="attendance" class="form-label">الحضور</label>
                                            <input type="number" class="form-control" id="attendance" name="attendance"
                                                max="10"
                                                value="{{ $student->userReports->last()->attendance ?? 0 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="reactivity" class="form-label">التفاعل</label>
                                            <input type="number" class="form-control" id="reactivity" name="reactivity"
                                                max="10"
                                                value="{{ $student->userReports->last()->reactivity ?? 0 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="homework" class="form-label">الواجبات</label>
                                            <input type="number" class="form-control" id="homework" name="homework"
                                                max="10"
                                                value="{{ $student->userReports->last()->homework ?? 0 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="completion" class="form-label">الإكمال</label>
                                            <input type="number" class="form-control" id="completion" name="completion"
                                                max="10"
                                                value="{{ $student->userReports->last()->completion ?? 0 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="creativity" class="form-label">الإبداع</label>
                                            <input type="number" class="form-control" id="creativity" name="creativity"
                                                max="10"
                                                value="{{ $student->userReports->last()->creativity ?? 0 }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ethics" class="form-label">الأخلاق</label>
                                            <input type="number" class="form-control" id="ethics" name="ethics"
                                                max="10"
                                                value="{{ $student->userReports->last()->ethics ?? 0 }}">
                                        </div>
                                    </div>
                                    <div class="text-center"
                                        style="display: flex; justify-content: center; flex-direction: column;">
                                        <button type="submit" class="btn btn-success mt-3"
                                            style="background-color: #F48140; border: none;">
                                            حفظ التعديلات
                                        </button>
                                        <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">
                                            إغلاق
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </tbody>
    </table>
</div>
