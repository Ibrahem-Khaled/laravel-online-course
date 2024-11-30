<style>
    .teacher-section {
        text-align: center;
        padding: 50px 0;
        margin: 50px 0;
    }

    .teacher-section h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 30px;
        color: #fff;
    }

    .teacher-card {
        background-color: #055160;
        border-radius: 50%;
        text-align: center;
        padding: 20px;
        width: 200px;
        height: 200px;
        margin: 20px auto;
        position: relative;
        overflow: hidden;
    }

    .teacher-card img {
        width: 100%;
        height: auto;
        border-radius: 50%;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    }

    .teacher-name {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 15px;
        color: #fff;
    }

    .teacher-title {
        font-size: 0.9rem;
        background-color: #035971;
        color: #ffffff;
        padding: 5px 15px;
        border-radius: 8px;
        display: inline-block;
        margin-top: 5px;
    }

    .teacher-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }
</style>

@if ($students->count() > 0)
    <section class="teacher-section">
        <h2>طلاب برنامج طموح</h2>
        <div class="teacher-row">
            @foreach ($students as $teacher)
                <div>
                    <div class="teacher-card">
                        <img src="{{ asset('storage/' . $teacher->image) }}" alt="Teacher Image">
                    </div>
                    <h4 class="teacher-name">{{ $teacher->name }}</h4>
                    {{-- <p class="teacher-title">
                        {{ $teacher->userInfo?->degree ?? 'لا يوجد معلومات حالياً' }}
                    </p> --}}
                </div>
            @endforeach
        </div>
    </section>
@else
    <h4 class="text-center">لا يوجد معلمين</h4>
@endif
