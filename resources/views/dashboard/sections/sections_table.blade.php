<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">القسم</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">النوع</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الطلاب</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">المدرسون</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الدورات</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">رابط الاجتماع</th>
                <th class="text-secondary opacity-7"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($sections as $section)
            <tr>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                            @if($section->image)
                            <img src="{{ asset('storage/' . $section->image) }}" class="avatar avatar-sm me-3" alt="صورة القسم">
                            @else
                            <div class="avatar avatar-sm bg-gradient-primary me-3">
                                <i class="fas fa-layer-group text-white"></i>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">
                                <a href="{{ route('sections.show', $section->id) }}">{{ $section->name }}</a>
                            </h6>
                            <p class="text-xs text-secondary mb-0">{{ Str::limit($section->description, 30) }}</p>
                        </div>
                    </div>
                </td>
                <td class="text-white">
                    <span class="badge 
                        @if($section->type == 'ambitious_program') bg-gradient-success
                        @elseif($section->type == 'ambitious_program2') bg-gradient-info
                        @else bg-gradient-danger
                        @endif">
                        {{ $section->type == 'ambitious_program' ? 'البرنامج الطموح 1' : 
                          ($section->type == 'ambitious_program2' ? 'البرنامج الطموح 2' : 'ريادة الأعمال') }}
                    </span>
                </td>
                <td class="align-middle text-center text-sm text-white">
                    <span class="badge bg-gradient-primary">{{ $section->users_count }}</span>
                </td>
                <td class="align-middle text-center text-sm text-white">
                    <span class="badge bg-gradient-warning">{{ $section->users()->where('role', 'teacher')->count() }}</span>
                </td>
                <td class="align-middle text-center text-sm text-white">
                    <span class="badge bg-gradient-info">{{ $section->courses_count }}</span>
                </td>
                <td class="align-middle text-center">
                    @if($section->meeting_link)
                    <a href="{{ $section->meeting_link }}" target="_blank" class="text-secondary font-weight-bold text-xs">
                        <i class="fas fa-video me-1"></i> انضم
                    </a>
                    @else
                    <span class="text-secondary font-weight-bold text-xs">غير متوفر</span>
                    @endif
                </td>
                <td class="align-middle">
                    <button class="btn btn-sm btn-outline-info mb-0" data-toggle="modal" data-target="#editSectionModal{{ $section->id }}">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </button>
                    <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger mb-0" onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                            <i class="fas fa-trash me-1"></i> حذف
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">لا توجد أقسام متاحة</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>