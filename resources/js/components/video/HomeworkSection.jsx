import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Modal, Button, Form, Alert } from 'react-bootstrap';

const HomeworkSection = ({ video, user }) => {
    const [homeworks, setHomeworks] = useState([]);
    const [showEditQuestion, setShowEditQuestion] = useState(false);
    const [newQuestion, setNewQuestion] = useState('');
    const [formData, setFormData] = useState({ text: '', file: null });
    const [editingHomework, setEditingHomework] = useState(null);
    const [replies, setReplies] = useState({});

    useEffect(() => {
        if (video?.home_works) {
            setHomeworks(video.home_works);
        }
        setNewQuestion(video?.question || '');
    }, [video]);

    const handleQuestionUpdate = async () => {
        try {
            await axios.put(`/video/${video.id}/question`, { question: newQuestion });
            setShowEditQuestion(false);
            // Update video data here
        } catch (error) {
            console.error('Error updating question:', error);
        }
    };

    const handleSubmitHomework = async (e) => {
        e.preventDefault();
        const data = new FormData();
        data.append('text', formData.text);
        if (formData.file) data.append('file', formData.file);
        data.append('course_videos_id', video.id);

        try {
            const res = await axios.post('/add-homework', data);
            setHomeworks([...homeworks, res.data]);
            setFormData({ text: '', file: null });
        } catch (error) {
            console.error('Error submitting homework:', error);
        }
    };

    const handleDeleteHomework = async (id) => {
        if (window.confirm('هل أنت متأكد من حذف هذا الواجب؟')) {
            try {
                await axios.delete(`/homework/delete/${id}`);
                setHomeworks(homeworks.filter(hw => hw.id !== id));
            } catch (error) {
                console.error('Error deleting homework:', error);
            }
        }
    };

    const handleReplySubmit = async (homeworkId) => {
        try {
            await axios.post(`/api/homeworks/${homeworkId}/reply`, replies[homeworkId]);
            // Update homework in state
            setHomeworks(homeworks.map(hw =>
                hw.id === homeworkId ? { ...hw, ...replies[homeworkId] } : hw
            ));
        } catch (error) {
            console.error('Error submitting reply:', error);
        }
    };

    return (
        <div className="homework-section mt-4">
            {/* Question Section */}
            {user && (
                <div className="mb-4 p-4 shadow-sm" style={{ backgroundColor: '#004051', borderRadius: 10 }}>
                    <h5 className="mb-3 text-white">سؤال الواجب</h5>

                    {video?.question ? (
                        <Alert variant="info">{video.question}</Alert>
                    ) : (
                        <Alert variant="info">لم يتم تحديد سؤال لهذا الواجب بعد</Alert>
                    )}

                    {(user.role === 'teacher' || user.role === 'supervisor' || user.role === 'admin') && (
                        <>
                            <Button
                                variant="primary"
                                onClick={() => setShowEditQuestion(true)}
                                style={{ backgroundColor: '#ed6b2f', border: 'none' }}
                            >
                                {video?.question ? 'تعديل السؤال' : 'اضافة سؤال'}
                            </Button>

                            <Modal show={showEditQuestion} onHide={() => setShowEditQuestion(false)}>
                                <Modal.Header style={{ backgroundColor: '#02475E', color: 'white' }}>
                                    <Modal.Title>تعديل سؤال الواجب</Modal.Title>
                                </Modal.Header>
                                <Modal.Body style={{ backgroundColor: '#02475E', color: 'white' }}>
                                    <Form.Control
                                        as="textarea"
                                        rows={4}
                                        value={newQuestion}
                                        onChange={(e) => setNewQuestion(e.target.value)}
                                    />
                                    <Button
                                        className="mt-3 w-100"
                                        style={{ backgroundColor: '#ed6b2f', border: 'none' }}
                                        onClick={handleQuestionUpdate}
                                    >
                                        تحديث السؤال
                                    </Button>
                                </Modal.Body>
                            </Modal>
                        </>
                    )}
                </div>
            )}

            {/* Homework Submission Form */}
            {user && (
                <div className="mb-4 p-3" style={{ backgroundColor: '#035971', borderRadius: 10 }}>
                    <h5 className="mb-3">رفع الواجب</h5>
                    <Form onSubmit={handleSubmitHomework}>
                        <Form.Group className="mb-3">
                            <Form.Label>كتابة الواجب (اختياري):</Form.Label>
                            <Form.Control
                                as="textarea"
                                rows={3}
                                value={formData.text}
                                onChange={(e) => setFormData({ ...formData, text: e.target.value })}
                            />
                        </Form.Group>

                        <Form.Group className="mb-3">
                            <Form.Label>إرفاق ملف (اختياري):</Form.Label>
                            <Form.Control
                                type="file"
                                onChange={(e) => setFormData({ ...formData, file: e.target.files[0] })}
                            />
                        </Form.Group>

                        <Button
                            className="w-100"
                            type="submit"
                            style={{ backgroundColor: '#ed6b2f', border: 'none' }}
                        >
                            إرسال
                        </Button>
                    </Form>
                </div>
            )}

            {/* Students' Homeworks List */}
            <h5 className="mt-4 mb-3">واجبات الطلاب ({homeworks.length})</h5>
            {homeworks.map(homework => (
                <div key={homework.id} className="p-3 mb-3" style={{ backgroundColor: '#004051', borderRadius: 10 }}>
                    {/* Student Info */}
                    <div className="d-flex align-items-center mb-2">
                        <img
                            src={homework.user.image || defaultAvatar(homework.user)}
                            alt="User"
                            style={{ width: 40, height: 40, borderRadius: '50%' }}
                        />
                        <div className="ms-3">
                            <p className="m-0 text-white">{homework.user.name}</p>
                            <small className="text-white">{new Date(homework.created_at).toLocaleDateString()}</small>
                        </div>
                    </div>

                    {/* Homework Content */}
                    <div className="p-2 rounded text-white" style={{ backgroundColor: '#035971' }}>
                        <p>{homework.text || 'لا يوجد نص مكتوب'}</p>
                        {homework.file && (
                            <a
                                href={homework.file}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="btn btn-sm btn-light"
                            >
                                عرض الملف
                            </a>
                        )}
                    </div>

                    {/* Student Actions */}
                    {user?.id === homework.user_id && (
                        <div className="mt-3 d-flex gap-2">
                            <Button variant="warning" size="sm" onClick={() => setEditingHomework(homework)}>
                                تعديل
                            </Button>
                            <Button variant="danger" size="sm" onClick={() => handleDeleteHomework(homework.id)}>
                                حذف
                            </Button>
                        </div>
                    )}

                    {/* Edit Homework Modal */}
                    <Modal show={editingHomework?.id === homework.id} onHide={() => setEditingHomework(null)}>
                        <Modal.Header style={{ backgroundColor: '#02475E', color: 'white' }}>
                            <Modal.Title>تعديل الواجب</Modal.Title>
                        </Modal.Header>
                        <Modal.Body style={{ backgroundColor: '#02475E', color: 'white' }}>
                            {/* Edit form implementation */}
                        </Modal.Body>
                    </Modal>

                    {/* Teacher Reply Section */}
                    {(user?.role === 'teacher' || user?.role === 'supervisor' || user?.role === 'admin') && (
                        <div className="mt-3">
                            <Form.Group>
                                <Form.Label className="text-white">رد الأستاذ:</Form.Label>
                                <Form.Control
                                    as="textarea"
                                    rows={2}
                                    value={replies[homework.id]?.reply || ''}
                                    onChange={(e) => setReplies({
                                        ...replies,
                                        [homework.id]: { ...replies[homework.id], reply: e.target.value }
                                    })}
                                />
                            </Form.Group>

                            <Form.Group>
                                <Form.Label className="text-white">تقييم:</Form.Label>
                                <Form.Select
                                    value={replies[homework.id]?.rating || ''}
                                    onChange={(e) => setReplies({
                                        ...replies,
                                        [homework.id]: { ...replies[homework.id], rating: e.target.value }
                                    })}
                                >
                                    <option value="">اختر التقييم</option>
                                    {[1, 2, 3, 4, 5].map(num => (
                                        <option key={num} value={num}>{num}/5</option>
                                    ))}
                                </Form.Select>
                            </Form.Group>

                            <Button
                                className="mt-2 w-100"
                                variant="success"
                                size="sm"
                                onClick={() => handleReplySubmit(homework.id)}
                            >
                                إرسال
                            </Button>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

const defaultAvatar = (user) => {
    return user?.gender === 'female'
        ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
        : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png';
};

export default HomeworkSection;