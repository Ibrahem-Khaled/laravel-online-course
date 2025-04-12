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
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card bg-gradient-primary shadow-primary">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-white text-sm mb-0 text-uppercase font-weight-bold">
                                                        إجمالي الأقسام</p>
                                                    <h5 class="text-white font-weight-bolder mb-0">
                                                        {{ $stats['total_sections'] }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow rounded-circle">
                                                    <i class="fas fa-layer-group text-primary text-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card bg-gradient-success shadow-success">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-white text-sm mb-0 text-uppercase font-weight-bold">
                                                        البرنامج الطموح 1</p>
                                                    <h5 class="text-white font-weight-bolder mb-0">
                                                        {{ $stats['ambitious_program'] }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow rounded-circle">
                                                    <i class="fas fa-star text-success text-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card bg-gradient-info shadow-info">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-white text-sm mb-0 text-uppercase font-weight-bold">
                                                        البرنامج الطموح 2</p>
                                                    <h5 class="text-white font-weight-bolder mb-0">
                                                        {{ $stats['ambitious_program2'] }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow rounded-circle">
                                                    <i class="fas fa-star-half-alt text-info text-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card bg-gradient-danger shadow-danger">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-white text-sm mb-0 text-uppercase font-weight-bold">ريادة
                                                        الأعمال</p>
                                                    <h5 class="text-white font-weight-bolder mb-0">
                                                        {{ $stats['entrepreneurship'] }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow rounded-circle">
                                                    <i class="fas fa-lightbulb text-danger text-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
