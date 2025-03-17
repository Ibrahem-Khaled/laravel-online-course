import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../../styles/video.css';
import { motion, AnimatePresence } from 'framer-motion';

const Sidebar = ({ course, video, setVideo }) => {
    const [openParts, setOpenParts] = useState({});
    const [progress, setProgress] = useState(0);
    const [videoHistories, setVideoHistories] = useState([]);
    console.warn(course.softwares_usages);
    // جلب بيانات الفيديو عند تغيير الفيديو أو الكورس
    useEffect(() => {
        const fetchVideoData = async () => {
            try {
                const response = await axios.get(`/api/courses/${course.id}/videos/${video.id}`);
                const { video: newVideo, progress: newProgress } = response.data;
                setVideo(newVideo);
                setProgress(newProgress);
                setVideoHistories(response.data.video.videoHistories);
            } catch (error) {
                console.error('Failed to fetch video data:', error);
            }
        };

        fetchVideoData();
    }, [video.id, course.id]);

    // فتح القسم الذي يحتوي على الفيديو الحالي
    useEffect(() => {
        if (video && course.parts) {
            const foundPart = course.parts.find(part =>
                part.videos.some(v => v.id === video.id)
            );

            if (foundPart) {
                setOpenParts(prev => ({
                    ...prev,
                    [foundPart.id]: true,
                }));
            }
        }
    }, [video, course.parts]);

    // ترتيب الفيديوهات حسب الترتيب المحدد
    const getAllVideosInOrder = () => {
        if (course.parts?.length > 0) {
            return course.parts
                .sort((a, b) => a.ranking - b.ranking)
                .flatMap(part =>
                    part.videos.sort((a, b) => a.ranking - b.ranking)
                );
        } else {
            return course.videos?.sort((a, b) => a.ranking - b.ranking) || [];
        }
    };

    // تبديل فتح وإغلاق الأقسام
    const togglePart = (partId) => {
        setOpenParts((prev) => ({
            ...prev,
            [partId]: !prev[partId],
        }));
    };

    // تحديد أيقونة حالة الفيديو
    const getVideoStatusIcon = (otherVideo, currentVideoId) => {
        const history = videoHistories.find(h => h.course_video_id === otherVideo.id);

        // كورس مغلق: قفل الفيديوهات بعد أول فيديو غير مكتمل
        if (course.type === 'closed') {
            const allVideos = getAllVideosInOrder();
            const firstIncompleteIndex = allVideos.findIndex(v => {
                const h = videoHistories.find(hist => hist.course_video_id === v.id);
                return !h?.completed;
            });
            const targetIndex = allVideos.findIndex(v => v.id === otherVideo.id);
            if (firstIncompleteIndex !== -1 && targetIndex > firstIncompleteIndex) {
                return <i className="fas fa-lock text-white" />;
            }
        }

        // كورس يحتوي على أسئلة: قفل الفيديوهات إذا كان هناك واجب غير محلول
        if (course.type === 'question' && video.unresolvedHomeworksCount > 0 && otherVideo.id !== currentVideoId) {
            return <i className="fas fa-lock text-white" />;
        }

        // أيقونات الحالة الافتراضية
        if (history?.completed) return <i className="fas fa-check-circle" style={{ color: '#4CAF50' }} />;
        if (otherVideo.id === currentVideoId) return <i className="fas fa-play-circle text-white" />;
        if (history) return <i className="fas fa-clock" style={{ color: '#ed6b2f' }} />;
        return <i className="fas fa-lock text-white" />;
    };

    // التعامل مع النقر على الفيديو
    const handleVideoClick = (otherVideo) => {
        if (course.type === 'closed') {
            const allVideos = getAllVideosInOrder();
            const firstIncompleteIndex = allVideos.findIndex(v => {
                const history = videoHistories.find(h => h.course_video_id === v.id);
                return !history?.completed;
            });

            if (firstIncompleteIndex === -1) {
                setVideo(otherVideo);
            } else {
                const targetIndex = allVideos.findIndex(v => v.id === otherVideo.id);
                if (targetIndex > firstIncompleteIndex) {
                    alert('يجب إكمال الفيديوهات السابقة أولاً');
                    return;
                } else {
                    setVideo(otherVideo);
                }
            }
        } else if (course.type === 'question') {
            if (video.unresolvedHomeworksCount == 0) {
                alert('يجب حل واجب الفيديو الحالي قبل الانتقال إلى فيديو آخر');
                return;
            } else {
                setVideo(otherVideo);
            }
        } else {
            setVideo(otherVideo);
        }
    };

    return (
        <div className="col-lg-4" style={{ marginTop: 50 }}>
            {/* شريط التقدم */}
            <motion.div
                className="progress-container"
                initial={{ opacity: 0, y: -20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5 }}
            >
                <h5>نسبة الإنجاز: {Math.round(progress, 2)}%</h5>
                <div className="progress">
                    <div className="progress-bar" style={{ width: `${progress}%` }}></div>
                </div>
            </motion.div>

            {/* قائمة الفيديوهات */}
            <motion.div
                className="video-list"
                style={{ maxHeight: '470px', overflowY: 'auto' }}
                initial={{ opacity: 0, y: -20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: 0.2 }}
            >
                {course.parts?.length > 0 ? (
                    course.parts.sort((a, b) => a.ranking - b.ranking).map((part) => (
                        <div key={part.id}>
                            <div className="part-header" onClick={() => togglePart(part.id)}>
                                <span>{part.name}</span>
                                <span className="icon">
                                    <i className={`fas ${openParts[part.id] ? 'fa-minus' : 'fa-plus'}`} />
                                </span>
                            </div>

                            <AnimatePresence>
                                {openParts[part.id] && (
                                    <motion.div
                                        initial={{ height: 0, opacity: 0 }}
                                        animate={{ height: "auto", opacity: 1 }}
                                        exit={{ height: 0, opacity: 0 }}
                                        transition={{ duration: 0.4, ease: "easeInOut" }}
                                        className="video-group"
                                    >
                                        {part.videos.sort((a, b) => a.ranking - b.ranking).map((otherVideo, index) => {
                                            const history = videoHistories?.[otherVideo.id] || null;
                                            return (
                                                <motion.a
                                                    key={otherVideo.id}
                                                    href="#"
                                                    onClick={(e) => {
                                                        e.preventDefault();
                                                        handleVideoClick(otherVideo);
                                                    }}
                                                    className={`video-list-item ${video.id === otherVideo.id ? 'active' : ''}`}
                                                    whileHover={{ scale: 1.02 }}
                                                    whileTap={{ scale: 0.98 }}
                                                >
                                                    {getVideoStatusIcon(otherVideo, video.id, history)}
                                                    <div className="content-wrapper">
                                                        <span className="video-title">
                                                            {index + 1}. {otherVideo.title}
                                                        </span>
                                                        <span className="video-duration">
                                                            {otherVideo.duration}
                                                        </span>
                                                    </div>
                                                </motion.a>
                                            );
                                        })}
                                    </motion.div>
                                )}
                            </AnimatePresence>
                        </div>
                    ))
                ) : (
                    course.videos.sort((a, b) => new Date(a.created_at) - new Date(b.created_at)).map((otherVideo, index) => {
                        return (
                            <motion.a
                                key={otherVideo.id}
                                href="#"
                                onClick={(e) => {
                                    e.preventDefault();
                                    handleVideoClick(otherVideo);
                                }}
                                className={`video-list-item ${video.id === otherVideo.id ? 'active' : ''}`}
                                whileHover={{ scale: 1.02 }}
                                whileTap={{ scale: 0.98 }}
                            >
                                {getVideoStatusIcon(otherVideo, video.id, history)}

                                <div className="content-wrapper">
                                    <span className="video-title">
                                        {index + 1}. {otherVideo.title}
                                    </span>
                                    <span className="video-duration">
                                        {otherVideo.duration}
                                    </span>
                                </div>
                            </motion.a>
                        );
                    })
                )}
            </motion.div>

            {/* قسم المدرب */}
            <motion.div
                className="trainer-section text-white p-3 rounded mt-3"
                initial={{ opacity: 0, y: -20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: 0.4 }}
            >
                <h5 className="mb-3">المدربين</h5>
                <div className="d-flex align-items-start mb-3 justify-content-around">
                    <img
                        src={course.user?.profile_image}
                        alt="Trainer Image"
                        className="rounded-circle me-3"
                        style={{ width: '60px', height: '60px' }}
                    />
                    <div className="ms-3">
                        <p className="m-0 fw-bold">{course.user.name}</p>
                        <small>{course.user?.userInfo?.bio || 'لا توجد معلومات متاحة'}</small>
                    </div>
                    <div className="d-flex gap-2">
                        <a
                            href="/chat"
                            className="d-flex justify-content-center align-items-center text-white"
                            style={{ width: '40px', height: '40px', fontSize: '25px' }}
                        >
                            <i className="fas fa-comment" />
                        </a>
                        <a
                            href={`https://wa.me/${course.user.phone}`}
                            target="_blank"
                            className="d-flex justify-content-center align-items-center text-white"
                            style={{ width: '40px', height: '40px', fontSize: '25px' }}
                        >
                            <i className="fab fa-whatsapp" />
                        </a>
                    </div>
                </div>
            </motion.div>

            {/* قسم البرامج المستخدمة */}
            <motion.div
                className="attachments-section"
                style={{ margin: '20px 0' }}
                initial={{ opacity: 0, y: -20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: 0.6 }}
            >
                {course.softwares_usages.length > 0 ? (
                    <>
                        <h5 className="text-white" style={{ fontWeight: 'bold', marginBottom: '15px' }}>
                            البرامج المستخدمة
                        </h5>
                        <div className="row row-cols-1 row-cols-md-4 g-4">
                            {course.softwares_usages.map((item) => (
                                <div className="col" key={item.id}>
                                    <div
                                        className="card text-center"
                                        style={{ border: 'none', backgroundColor: 'transparent', boxShadow: 'none' }}
                                    >
                                        <a href={item.file || 'http://127.0.0.1:8000/dashboard/courses'} target="_blank" rel="noopener noreferrer">
                                            <img
                                                src={item.image ? `/storage/${item.image}` : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2F2.bp.blogspot.com%2F-dJ9XpH5XOm8%2FU8ZFngrXs2I%2FAAAAAAAAAWw%2FHbIA6HLu7QQ%2Fs1600%2Fred%2Bcircle%2Bexited%2Bicon%2Bfree%2Bicon%2Bexit%2Bbutton.png&f=1&nofb=1&ipt=e2b3f2629cfc19afe7bb74591e0bde4a8bc36c2c81989bc737afcad55c850e46&ipo=images'}
                                                alt={item.title}
                                                className="card-img-top img-fluid"
                                                style={{ borderRadius: '12px', maxHeight: '150px', objectFit: 'cover' }}
                                            />
                                        </a>
                                        <div className="card-body" style={{ padding: '10px 0' }}>
                                            <h6 className="card-title text-white" style={{ fontWeight: 'bold', fontSize: '14px' }}>
                                                {item.title}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </>
                ) : (
                    <h5 className="text-white text-center">لا يوجد برامج مستخدمة</h5>
                )}
            </motion.div>
        </div>
    );
};

export default Sidebar;