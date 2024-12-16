<div class="attachments-section" style="margin: 20px 0;">
    @if ($video->videoUsage->where('type', 'attachment')->count() > 0)
        <h5 class="text-white mb-4 font-weight-bold text-center">المرفقات</h5>
        <div class="list-group">
            @foreach ($video->videoUsage->where('type', 'attachment') as $item)
                <div class="list-group-item" style="background-color: #004051; color: #ffffff; border-radius: 12px; margin-bottom: 15px; padding: 20px;">
                    <!-- العنوان -->
                    <h6 style="font-weight: bold; color: #ff9c00; margin-bottom: 10px;">{{ $item->title }}</h6>

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
                            style="border-radius: 8px;">
                            <i class="bi bi-file-earmark"></i> تحميل الملف
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <h5 class="text-white mb-3 text-center">لا يوجد مرفقات</h5>
    @endif
</div>
