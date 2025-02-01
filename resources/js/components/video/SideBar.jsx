import React, { useState, useEffect } from 'react';
import axios from 'axios'; // استخدم axios للتعامل مع الطلبات HTTP
import '../../styles/video.css';
import { motion } from 'framer-motion';

const Sidebar = ({ course, video, setVideo }) => {
    const [openParts, setOpenParts] = useState({});
    const [progress, setProgress] = useState(0);
    const [videoHistories, setVideoHistories] = useState([]);

    useEffect(() => {
        const fetchVideoData = async () => {
            try {
                const response = await axios.get(`/api/courses/${course.id}/videos/${video.id}`);
                const { video: newVideo, progress: newProgress } = response.data;
                setVideo(newVideo);
                setProgress(newProgress);
            } catch (error) {
                console.error('Failed to fetch video data:', error);
            }
        };

        fetchVideoData();
    }, [video.id, course.id]);

    const togglePart = (partId) => {
        setOpenParts((prev) => ({
            ...prev,
            [partId]: !prev[partId],
        }));
    };

    const getVideoStatusIcon = (otherVideo, currentVideoId, isCompleted, isViewed) => {
        if (otherVideo.id === currentVideoId) {
            return <i className="fas fa-play-circle" style={{ color: '#fff' }} />;
        } else if (isCompleted) {
            return <i className="fas fa-check-circle" style={{ color: '#28a745' }} />;
        } else if (isViewed) {
            return <i className="fas fa-clock" style={{ color: '#fff' }} />;
        } else {
            return <i className="fas fa-lock" style={{ color: '#fff' }} />;
        }
    };

    return (
        <div className="col-lg-4" style={{ marginTop: '1.5%' }}>
            {/* قائمة الفيديوهات مع شريط التقدم المدمج */}
            <div className="progress-container">
                <h5>نسبة الإنجاز: {Math.round(progress, 2)}%</h5>
                <div className="progress">
                    <div className="progress-bar" style={{ width: `${progress}%` }}></div>
                </div>
            </div>

            <div className="video-list" style={{ maxHeight: '470px', overflowY: 'auto' }}>
                {course.parts?.length > 0 ? (
                    course.parts.sort((a, b) => a.ranking - b.ranking).map((part) => (
                        <div key={part.id}>
                            <div className="part-header" onClick={() => togglePart(part.id)}>
                                <span>{part.name}</span>
                                <span className="icon">
                                    <i className={`fas ${openParts[part.id] ? 'fa-minus' : 'fa-plus'}`} />
                                </span>
                            </div>

                            <motion.div
                                initial={{ height: 0, opacity: 0 }}
                                animate={{
                                    height: openParts[part.id] ? "auto" : 0,
                                    opacity: openParts[part.id] ? 1 : 0
                                }}
                                transition={{ duration: 0.4, ease: "easeInOut" }}
                                className="video-group"
                            >
                                {part.videos.sort((a, b) => a.ranking - b.ranking).map((otherVideo, index) => {
                                    const history = videoHistories?.[otherVideo.id] || null;
                                    const isCompleted = history?.pivot?.completed ?? false;
                                    const isViewed = history && !history.pivot?.completed;

                                    return (
                                        <a
                                            key={otherVideo.id}
                                            href="#"
                                            onClick={(e) => {
                                                e.preventDefault();
                                                setVideo(otherVideo);
                                            }}
                                            className={`video-list-item ${video.id === otherVideo.id ? 'active' : ''}`}
                                        >
                                            <div className="d-flex align-items-center">
                                                {getVideoStatusIcon(otherVideo, video.id, isCompleted, isViewed)}
                                                <span>
                                                    {index + 1}. {otherVideo.title}
                                                </span>
                                                <span className="video-duration">{otherVideo.duration}</span>
                                            </div>
                                        </a>
                                    );
                                })}
                            </motion.div>
                        </div>
                    ))
                ) : (
                    course.videos.sort((a, b) => new Date(a.created_at) - new Date(b.created_at)).map((otherVideo, index) => {
                        const history = videoHistories?.[otherVideo.id] || null;
                        const isCompleted = history?.pivot?.completed ?? false;
                        const isViewed = history && !history.pivot?.completed;

                        return (
                            <a
                                key={otherVideo.id}
                                href="#"
                                onClick={(e) => {
                                    e.preventDefault();
                                    setVideo(otherVideo);
                                }}
                                className={`video-list-item ${video.id === otherVideo.id ? 'active' : ''}`}
                            >
                                <div className="d-flex align-items-center">
                                    {getVideoStatusIcon(otherVideo, video.id, isCompleted, isViewed)}
                                    <span>
                                        {index + 1}. {otherVideo.title}
                                    </span>
                                    <span className="video-duration">{otherVideo.duration}</span>
                                </div>
                            </a>
                        );
                    })
                )}
            </div>

            {/* قسم المدرب */}
            <div className="trainer-section text-white p-3 rounded mt-3">
                <h5 className="mb-3">المدربين</h5>
                <div className="d-flex align-items-start mb-3 justify-content-around">
                    <img
                        src={course.user?.image ? `/storage/${course.user.image}` : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png'}
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
                            href="chat_link_here"
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
            </div>

            {/* قسم الملحقات / البرامج المستخدمة */}
            <div className="attachments-section" style={{ margin: '20px 0' }}>
                {video.videoUsage?.filter((item) => item.type === 'software').length > 0 ? (
                    <>
                        <h5 className="text-white" style={{ fontWeight: 'bold', marginBottom: '15px' }}>
                            البرامج المستخدمة
                        </h5>
                        <div className="row row-cols-1 row-cols-md-4 g-4">
                            {video.videoUsage
                                .filter((item) => item.type === 'software')
                                .map((item) => (
                                    <div className="col" key={item.id}>
                                        <div
                                            className="card text-center"
                                            style={{ border: 'none', backgroundColor: 'transparent', boxShadow: 'none' }}
                                        >
                                            <a href={item.url} target="_blank" rel="noopener noreferrer">
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
            </div>
        </div>
    );
};

export default Sidebar;