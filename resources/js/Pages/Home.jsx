import React from 'react';
import '../styles/Home.css';
import Carousel from 'react-bootstrap/Carousel';
import { Container, Row, Col, Card } from 'react-bootstrap';

// دالة لتقسيم المصفوفة إلى مجموعات بحجم محدد
function chunkArray(array, chunkSize) {
    const results = [];
    for (let i = 0; i < array.length; i += chunkSize) {
        results.push(array.slice(i, i + chunkSize));
    }
    return results;
}

function Home({ isAuthenticated, coursesHours, allStudentsCount, teachers, courses, students, sections }) {
    // تقسيم مصفوفة الطلاب إلى مجموعات من 3 طلاب
    const studentChunks = chunkArray(students, 3);

    const sectionChunks = chunkArray(sections, 3);


    return (
        <>
            <section className="hero-section">
                <div className="hero-content">
                    <h1 className="hero-title">
                        تعلم بطريقة إبداعية مع <span>أكاديمية السّريع</span>
                    </h1>
                    <p className="hero-text">
                        انطلق في مسيرتك التعليمية الآن واستمتع بمجموعة متنوعة من الدورات والبرامج التي ستقودك إلى آفاق أرحب من المعرفة والتطور والإبداع.
                    </p>
                    {!isAuthenticated && (
                        <div>
                            <a href="/auth/login" className="btn-primary-login">
                                تسجيل دخول
                            </a>
                            <a href="/auth/register" className="btn-outline-register">
                                إنشاء حساب
                            </a>
                        </div>
                    )}
                </div>
                <div className="hero-image">
                    <img src="/assets/img/hero-section-img.png" alt="Learning" />
                </div>
            </section>

            <section className="info-section">
                <div className="info-card">
                    <img src="https://cdn-icons-png.flaticon.com/128/7339/7339321.png" alt="Learning" />
                    <h2>{coursesHours}+</h2>
                    <p>محتوى الساعات</p>
                </div>

                <div className="info-card">
                    <img src="https://cdn-icons-png.flaticon.com/128/3829/3829933.png" alt="Learning" />
                    <h2>{allStudentsCount}+</h2>
                    <p>الطلاب</p>
                </div>

                <div className="info-card">
                    <img src="https://cdn-icons-png.flaticon.com/128/8295/8295504.png" alt="Learning" />
                    <h2>{teachers.length}+</h2>
                    <p>المعلمين</p>
                </div>

                <div className="info-card">
                    <img src="https://cdn-icons-png.flaticon.com/128/8644/8644489.png" alt="Learning" />
                    <h2>{courses.length}+</h2>
                    <p>الدورات</p>
                </div>
            </section>

            <section
                className="d-flex flex-column align-items-center justify-content-center mt-5"
                style={{ textAlign: 'center', maxWidth: '60%', margin: 'auto' }}
            >
                <div className="mt-4">
                    <h4 className="mb-4" style={{ color: '#F4813E' }}>ما هو هدف المنصة التعليمية؟</h4>
                    <p className="mb-4">
                        تهدف المنصة التعليمية للإرتقاء بمستوى التعلم وخلق تجربة تعليمية رائدة كما تعزز إمكانية الوصول للمحتوى التعليمي بسهولة وسلاسة
                    </p>
                </div>
            </section>

            <section
                className="d-flex flex-column align-items-center justify-content-center mt-5"
                style={{ textAlign: 'center' }}
            >
                <img src="/assets/img/medileHero.png" alt="Shape 1" className="img-fluid" />
            </section>

            {/* Carousel لأفضل الطلاب - عرض 3 طلاب في كل شريحة */}
            <section className="best-students-section mt-5" style={{ textAlign: 'center', marginBottom: '5rem' }}>
                <h1 style={{ color: '#F4813E', fontWeight: 'bold', marginBottom: '10rem' }}>
                    طلاب برنامج طموح
                </h1>
                <Carousel interval={3000} indicators={false} controls={true}>
                    {studentChunks.map((chunk, index) => (
                        <Carousel.Item key={index}>
                            <div className="d-flex justify-content-center">
                                {chunk.map((student) => (
                                    <div key={student.id} className="mx-3">
                                        <img
                                            src={student.profile_image}
                                            alt={student.name}
                                            className="rounded-circle"
                                            style={{
                                                width: '150px',
                                                height: '150px',
                                                objectFit: 'cover',
                                                marginBottom: '1rem',
                                            }}
                                        />
                                        <h4>{student.name}</h4>
                                        {student.title && <p>{student.title}</p>}
                                    </div>
                                ))}
                            </div>
                        </Carousel.Item>
                    ))}
                </Carousel>
            </section>


            <section
                className="d-flex flex-column align-items-center justify-content-center mt-5"
                style={{ textAlign: 'center' }}
            >
                <h4 className="mb-4" style={{ color: '#F4813E' }}>الفصول الدراسية</h4>
                <Container>
                    <Carousel indicators={false} controls={true} interval={3000}>
                        {sectionChunks.map((chunk, chunkIndex) => (
                            <Carousel.Item key={chunkIndex}>
                                <Row className="justify-content-center">
                                    {chunk.map((item) => (
                                        <Col md={4} key={item.id} className="mb-4">
                                            <Card className="bg-transparent h-100">
                                                <Card.Img
                                                    variant="top"
                                                    src={item.image || '/assets/img/default-course.png'}
                                                    alt={item.name}
                                                    style={{ height: '200px', objectFit: 'cover' }}
                                                />
                                                <Card.Body>
                                                    <Card.Title style={{ color: '#fff', fontWeight: 'bold' }}>
                                                        {item.name}
                                                    </Card.Title>
                                                    {/* يمكنك إظهار وصف الفصول هنا إن وُجد */}
                                                    {/* <Card.Text style={{ color: '#aaa' }}>
                          {item.description || 'لا يوجد وصف'}
                        </Card.Text> */}
                                                    <div className="d-flex align-items-center justify-content-center my-2">
                                                        <div
                                                            className="d-flex flex-wrap align-items-center"
                                                            style={{
                                                                backgroundColor: '#035971',
                                                                padding: '10px 20px',
                                                                borderRadius: '15px',
                                                            }}
                                                        >
                                                            {item.users
                                                                .filter((user) => user.role === 'student')
                                                                .slice(0, 3)
                                                                .map((student) => (
                                                                    <img
                                                                        key={student.id}
                                                                        src={student.profile_image}
                                                                        alt={student.name}
                                                                        className="rounded-circle me-2"
                                                                        style={{
                                                                            width: '40px',
                                                                            height: '40px',
                                                                            objectFit: 'cover',
                                                                        }}
                                                                    />
                                                                ))}
                                                            <span style={{ color: 'white', marginLeft: '10px' }}>
                                                                +{item.users.filter((user) => user.role === 'student').length}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p className="mt-3" style={{ color: '#fff' }}>
                                                        الطلاب المتفاعلون يوميًا
                                                    </p>
                                                </Card.Body>
                                            </Card>
                                        </Col>
                                    ))}
                                </Row>
                            </Carousel.Item>
                        ))}
                    </Carousel>
                </Container>
            </section>

            <section
                className="d-flex flex-column align-items-center justify-content-center mt-5"
                style={{ textAlign: 'center', maxWidth: '60%', margin: 'auto' }}
            >
                <img src="/assets/img/user-reports.png" alt="Shape 1" className="img-fluid" />
            </section>
        </>
    );
}

export default Home;
