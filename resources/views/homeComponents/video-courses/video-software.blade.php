<div class="attachments-section" style="margin: 20px 0;">
    @include('homeComponents.video-courses.in_video_usages')
    @if ($video->videoUsage->where('type', 'attachment')->count() > 0)
        <h5 class="text-white mb-4 font-weight-bold text-center">المرفقات</h5>
        <div class="list-group">
            @foreach ($video->videoUsage->where('type', 'attachment') as $item)
                <div class="list-group-item"
                    style="background-color: #004051; color: #ffffff; border-radius: 12px; margin-bottom: 15px; padding: 20px;">
                    <!-- العنوان -->
                    <h6 style="font-weight: bold; color: #ed6b2f; margin-bottom: 10px;">{{ $item->title }}</h6>

                    <!-- الوصف -->
                    @if ($item->description)
                        <p style="font-size: 14px; margin-bottom: 10px; color: #e0e0e0;">{{ $item->description }}</p>
                    @endif

                    <!-- الصورة -->
                    @if ($item->image)
                        <a href="{{ asset('storage/' . $item->image) }}" target="_blank" class="btn btn-sm btn-light"
                            style="border-radius: 8px; margin-bottom: 10px;">
                            <i class="bi bi-image"></i> عرض الصورة
                        </a>
                    @endif

                    <!-- الملف -->
                    @if ($item->file)
                        <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-sm btn-light"
                            style="border-radius: 8px; margin-bottom: 10px;">
                            <i class="bi bi-file-earmark"></i> تحميل الملف
                        </a>
                    @endif

                    <!-- زر المسح -->
                    @if (
                        (auth()->check() && auth()->user()->role == 'admin') ||
                            auth()->user()->role == 'supervisor' ||
                            auth()->user()->role == 'teacher')
                        <form action="{{ route('videoUsage.destroy', $item->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                style="border-radius: 8px; margin-bottom: 10px;">
                                <i class="bi bi-trash"></i> مسح
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <h5 class="text-white mb-3 text-center">لا يوجد مرفقات</h5>
    @endif
</div>
