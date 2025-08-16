<div class="modal fade" id="deleteInstructorModal{{ $instructor->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteInstructorModalLabel{{ $instructor->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteInstructorModalLabel{{ $instructor->id }}">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من رغبتك في حذف المدرب <strong>{{ $instructor->user->name ?? '' }}</strong> من دورة
                <strong>{{ $instructor->course->title ?? '' }}</strong>؟
            </div>
            <div class="modal-footer">
                <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم، حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
