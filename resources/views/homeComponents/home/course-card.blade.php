<style>
    .course-card {
        width: 100%;
        max-width: 286px;
        background-color: #035971;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        text-align: right;
        margin: 10px auto;
    }

    .course-card:hover {
        transform: translateY(-5px);
    }

    .course-card .card-img-top {
        height: 150px;
        object-fit: cover;
        width: 100%;
    }

    .course-card .card-body {
        padding: 15px;
    }

    .course-card-title {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .course-card .rating {
        color: gold;
        margin-bottom: -10px;
    }

    .course-card .price {
        color: #ed6b2f;
        font-weight: bold;
        margin-top: 5px;
        background-color: #0B495B;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .favorite-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.8);
        border: none;
        color: red;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .favorite-btn:hover {
        background: rgba(255, 255, 255, 1);
    }

    .trainer-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
    }

    .trainer-info img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-left: 5px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .sort-section {
            flex-direction: column;
            align-items: flex-end;
        }

        .course-card {
            width: 100%;
            max-width: 100%;
            margin: 15px 0;
        }

        .trainer-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
<div class="col-lg-3 col-md-4 col-sm-6">
    <a href="{{ route('courses.videos', $course->id) }}" class="text-decoration-none">
        <div class="course-card">
            <button class="favorite-btn">
                <i class="fas {{ $course?->is_favorite ? 'fa-heart' : 'fa-heart-o' }}"></i>
            </button>
            <img class="card-img-top" src="{{ asset('storage/' . $course->image) }}" alt="Course Image">
            <div class="card-body">
                <h5 class="course-card-title">{{ $course->title }}</h5>
                <div class="trainer-info">
                    @if ($course->ratings->count() == 0)
                        <p class="rating">
                            لا يوجد تقييمات
                        </p>
                    @else
                        <p class="rating">
                            @for ($i = 1; $i <= $course->ratings->avg('rating'); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            ({{ $course->ratings->count() }})
                        </p>
                    @endif
                    <div class="trainer-info">
                        <span style="font-size: 11px">{{ $course->user->name }}</span>
                        <img src="{{ $course->user->image ? asset('storage/' . $course->user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                            alt="Trainer Image">
                    </div>
                </div>

                <div class="trainer-info">
                    <p style="color: #ed6b2f">{{ $course->user->count() ?? 0 }}
                        <i class="fas fa-user"></i>
                    </p>
                    <p class="price">{{ $course->price }} ريال</p>
                </div>
            </div>
        </div>
    </a>
</div>
