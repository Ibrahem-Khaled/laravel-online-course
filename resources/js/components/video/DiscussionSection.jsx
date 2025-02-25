import axios from 'axios';
import React, { useState, useEffect } from 'react';

const DiscussionSection = ({ video, user }) => {
    const [comments, setComments] = useState(video.video_discussions || []);
    const [newComment, setNewComment] = useState('');
    const [errors, setErrors] = useState([]);
    const [editingCommentId, setEditingCommentId] = useState(null);
    const [editedCommentText, setEditedCommentText] = useState('');

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

            setComments([...comments, response.data]);
            setNewComment('');
            setErrors([]);
        } catch (error) {
            console.error('Error:', error);
            setErrors(['حدث خطأ أثناء إرسال التعليق.']);
        }
    };

    const handleEditComment = (comment) => {
        setEditingCommentId(comment.id);
        setEditedCommentText(comment.body);
    };

    const handleUpdateComment = async (commentId) => {
        if (!editedCommentText.trim()) {
            setErrors(['يرجى كتابة تعليق قبل التعديل.']);
            return;
        }

        try {
            const response = await axios.put(`/update-comment/${commentId}`, {
                body: editedCommentText,
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            setComments(comments.map(comment =>
                comment.id === commentId ? { ...comment, body: editedCommentText } : comment
            ));
            setEditingCommentId(null);
            setEditedCommentText('');
            setErrors([]);
        } catch (error) {
            console.error('Error:', error);
            setErrors(['حدث خطأ أثناء تعديل التعليق.']);
        }
    };

    const handleDeleteComment = async (commentId) => {
        if (window.confirm('هل أنت متأكد من حذف هذا التعليق؟')) {
            try {
                await axios.delete(`/delete-comment/${commentId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                setComments(comments.filter(comment => comment.id !== commentId));
            } catch (error) {
                console.error('Error:', error);
                setErrors(['حدث خطأ أثناء حذف التعليق.']);
            }
        }
    };

    const isAdminOrTeacher = user && (user.role === 'admin' || user.role === 'teacher');

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
                            src={comment.user.profile_image}
                            alt="User"
                            className="rounded-circle"
                            style={{ width: '40px', height: '40px' }}
                        />
                        <div className="ms-3" style={{ marginRight: '10px' }}>
                            <p className="m-0">{comment.user.name}</p>
                            <small className="text-white">{new Date(comment.created_at).toLocaleString('ar')}</small>
                        </div>

                        {(user && (user.id === comment.user.id || isAdminOrTeacher)) && (
                            <div className="ms-auto">
                                <button
                                    className="btn btn-sm btn-warning me-2"
                                    onClick={() => handleEditComment(comment)}
                                >
                                    تعديل
                                </button>
                                <button
                                    className="btn btn-sm btn-danger"
                                    onClick={() => handleDeleteComment(comment.id)}
                                >
                                    حذف
                                </button>
                            </div>
                        )}
                    </div>

                    {editingCommentId === comment.id ? (
                        <div className="d-flex align-items-center mt-2">
                            <textarea
                                className="form-control me-2"
                                rows="2"
                                value={editedCommentText}
                                onChange={(e) => setEditedCommentText(e.target.value)}
                            ></textarea>
                            <button
                                className="btn btn-sm btn-success"
                                onClick={() => handleUpdateComment(comment.id)}
                            >
                                حفظ
                            </button>
                        </div>
                    ) : (
                        <div className="p-2 rounded text-white" style={{ backgroundColor: '#035971' }}>
                            <p className="mb-1">{comment.body}</p>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

export default DiscussionSection;