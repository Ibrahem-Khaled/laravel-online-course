@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>إدارة الأقسام</h6>
                        <button class="btn btn-primary mb-0" data-toggle="modal" data-target="#createSectionModal">
                            <i class="fas fa-plus me-1"></i> إضافة قسم جديد
                        </button>
                    </div>

                    <!-- إحصائيات الأقسام -->
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row mx-3 mb-3">
                            <x-stat-card title="الأقسام" count="{{ $stats['total_sections'] }}" icon="layer-group"
                                color="primary" />
                            <x-stat-card title="البرنامج الطموح" count="{{ $stats['ambitious_program'] }}" icon="star"
                                color="success" />
                            <x-stat-card title="البرنامج الطموح 2" count="{{ $stats['ambitious_program2'] }}" icon="star"
                                color="info" />
                            <x-stat-card title="ريادة الأعمال" count="{{ $stats['entrepreneurship'] }}" icon="lightbulb"
                                color="danger" />
                        </div>

                        <!-- ألسنة التبويب -->
                        <ul class="nav nav-tabs" id="sectionsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all"
                                    type="button" role="tab">
                                    الكل
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ambitious1-tab" data-toggle="tab" data-target="#ambitious1"
                                    type="button" role="tab">
                                    البرنامج الطموح 1
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ambitious2-tab" data-toggle="tab" data-target="#ambitious2"
                                    type="button" role="tab">
                                    البرنامج الطموح 2
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="entrepreneurship-tab" data-toggle="tab"
                                    data-target="#entrepreneurship" type="button" role="tab">
                                    ريادة الأعمال
                                </button>
                            </li>
                        </ul>

                        <!-- محتوى التبويبات -->
                        <div class="tab-content" id="sectionsTabContent">
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                @include('dashboard.sections.sections_table', [
                                    'sections' => $sections,
                                ])
                            </div>
                            <div class="tab-pane fade" id="ambitious1" role="tabpanel">
                                @include('dashboard.sections.sections_table', [
                                    'sections' => $sections->where('type', 'ambitious_program'),
                                ])
                            </div>
                            <div class="tab-pane fade" id="ambitious2" role="tabpanel">
                                @include('dashboard.sections.sections_table', [
                                    'sections' => $sections->where('type', 'ambitious_program2'),
                                ])
                            </div>
                            <div class="tab-pane fade" id="entrepreneurship" role="tabpanel">
                                @include('dashboard.sections.sections_table', [
                                    'sections' => $sections->where('type', 'entrepreneurship_program'),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.sections.create')
    @foreach ($sections as $section)
        @include('dashboard.sections.edit', ['section' => $section])
    @endforeach
@endsection

@push('scripts')
    <script>
        // تفعيل ألسنة التبويب
        const tabElms = document.querySelectorAll('button[data-toggle="tab"]');
        tabElms.forEach(tabElm => {
            tabElm.addEventListener('shown.bs.tab', event => {
                localStorage.setItem('activeSectionTab', event.target.id);
            });
        });

        // استعادة التبويب النشط عند تحميل الصفحة
        const activeTab = localStorage.getItem('activeSectionTab');
        if (activeTab) {
            const tab = new bootstrap.Tab(document.getElementById(activeTab));
            tab.show();
        }
    </script>
@endpush
