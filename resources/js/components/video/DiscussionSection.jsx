import axios from 'axios';
import React, { useState, useEffect } from 'react';

const DiscussionSection = ({ video, user }) => {
    const [comments, setComments] = useState(video.video_discussions || []);
    const [newComment, setNewComment] = useState('');
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        setComments(video.video_discussions || []);
    }, [video]);

    const handleSubmitComment = async () => {
        if (!newComment.trim()) {
            setErrors(['يرجى كتابة تعليق قبل الإرسال.']);
            return;
        }

        const formData = new FormData();
        formData.append('video_id', video.id);
        formData.append('body', newComment);

        try {
            const response = await axios.post('/add-comment', formData, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            if (response.data.success) {
                setComments([...comments, response.data.comment]);
                setNewComment('');
                setErrors([]);
            } else {
                setErrors(response.data.errors || ['حدث خطأ أثناء إرسال التعليق.']);
            }
        } catch (error) {
            console.error('Error:', error);
            setErrors(['حدث خطأ أثناء إرسال التعليق.']);
        }
    };

    return (
        <div className="discussion-section mt-4">
            {/* نموذج إضافة تعليق جديد */}
            <div className="mb-4 p-3" style={{ backgroundColor: '#072D38', borderRadius: '10px', display: 'flex', alignItems: 'center' }}>
                {user ? (
                    <>
                        <div id="comment-errors" className={`alert alert-danger ${errors.length ? 'd-block' : 'd-none'}`}>
                            {errors.map((error, index) => (
                                <p key={index}>{error}</p>
                            ))}
                        </div>

                        <form id="comment-form" style={{ flexGrow: 1, display: 'flex', alignItems: 'center' }}>
                            <input type="hidden" name="video_id" value={video.id} />
                            <textarea
                                id="commentText"
                                name="body"
                                className="form-control"
                                rows="1"
                                placeholder="اكتب الاستفسار هنا..."
                                value={newComment}
                                onChange={(e) => setNewComment(e.target.value)}
                            ></textarea>
                            <button
                                type="button"
                                id="submit-comment"
                                className="btn btn-primary"
                                style={{ backgroundColor: '#ed6b2f', border: 'none', padding: '10px 20px' }}
                                onClick={handleSubmitComment}
                            >
                                إرسال
                            </button>
                        </form>
                    </>
                ) : (
                    <p className="text-white">يرجى تسجيل الدخول لكتابة الاستفسار.</p>
                )}
            </div>

            {/* عرض التعليقات */}
            <h5 className="mt-4 mb-3">الاستفسارات</h5>
            {comments.map((comment) => (
                <div key={comment.id} className="p-3 mb-3" style={{ backgroundColor: '#004051', borderRadius: '10px' }}>
                    <div className="d-flex align-items-center mb-2">
                        <img
                            src={comment.user.image || (comment.user?.userInfo?.gender === 'female' ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png' : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png')}
                            alt="User"
                            className="rounded-circle"
                            style={{ width: '40px', height: '40px' }}
                        />
                        <div className="ms-3" style={{ marginRight: '10px' }}>
                            <p className="m-0">{comment.user.name}</p>
                            <small className="text-white">{new Date(comment.created_at).toLocaleString('ar')}</small>
                        </div>
                    </div>
                    <div className="p-2 rounded text-white" style={{ backgroundColor: '#035971' }}>
                        <p className="mb-1">{comment.body}</p>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default DiscussionSection;