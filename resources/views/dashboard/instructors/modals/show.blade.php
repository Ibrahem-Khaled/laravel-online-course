<div class="modal fade" id="showInstructorModal{{ $instructor->id }}" tabindex="-1" role="dialog" aria-labelledby="showInstructorModalLabel{{ $instructor->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showInstructorModalLabel{{ $instructor->id }}">تفاصيل المدرب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><strong>اسم المدرب:</strong> {{ $instructor->user->name ?? 'N/A' }}</p>
                <p><strong>بريد المدرب:</strong> {{ $instructor->user->email ?? 'N/A' }}</p>
                <hr>
                <p><strong>الدورة:</strong> {{ $instructor->course->title ?? 'N/A' }}</p>
                <p><strong>الدور في الدورة:</strong> {{ $instructor->role == 'assistant' ? 'مساعد' : 'شريك' }}</p>
                <p><strong>تاريخ الإضافة:</strong> {{ $instructor->created_at->diffForHumans() }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
