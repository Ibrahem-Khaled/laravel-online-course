import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Modal, Button, Form, Alert } from 'react-bootstrap';
import { formatDistanceToNow, parseISO } from 'date-fns';
import { ar } from 'date-fns/locale';
import { extractAndShortenLinks } from '../../utils/helpers';

const HomeworkSection = ({ video, user }) => {
    const [homeworks, setHomeworks] = useState([]);
    const [showEditQuestion, setShowEditQuestion] = useState(false);
    const [newQuestion, setNewQuestion] = useState('');
    const [formData, setFormData] = useState({ text: '', file: null });
    const [editingHomework, setEditingHomework] = useState(null);
    const [replies, setReplies] = useState({});
    const [successMessages, setSuccessMessages] = useState({});
    const [errors, setErrors] = useState({});
    const [editingText, setEditingText] = useState('');
    const [editingFile, setEditingFile] = useState(null);

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
        } catch (error) {
            console.error('Error updating question:', error);
        }
    };

    const handleSubmitHomework = async (e) => {
        e.preventDefault();
        setErrors({});
        const data = new FormData();
        data.append('text', formData.text);
        if (formData.file) data.append('file', formData.file);
        data.append('course_videos_id', video.id);

        try {
            const res = await axios.post('/add-homework', data);
            setHomeworks([...homeworks, res.data]);
            setFormData({ text: '', file: null });
        } catch (error) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            }
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
            await axios.post(`/homework/reply/${homeworkId}`, replies[homeworkId]);
            setHomeworks(homeworks.map(hw =>
                hw.id === homeworkId ? { ...hw, ...replies[homeworkId] } : hw
            ));
            setSuccessMessages(prev => ({ ...prev, [homeworkId]: true }));
            setTimeout(() => {
                setSuccessMessages(prev => ({ ...prev, [homeworkId]: false }));
            }, 3000);
        } catch (error) {
            console.error('Error submitting reply:', error);
        }
    };

    const handleUpdateHomework = async (e, homeworkId) => {
        e.preventDefault();
        const data = new FormData();
        data.append('text', editingText);
        if (editingFile) data.append('file', editingFile);
        data.append('_method', 'PUT');

        try {
            const res = await axios.post(`/homework/update/${homeworkId}`, data);
            // setHomeworks(homeworks.map(hw =>
            //     hw.id === homeworkId ? { ...hw, text: res.data.text, file: res.data.file } : hw
            // ));
            setEditingHomework(null);
        } catch (error) {
            console.error('Error updating homework:', error);
        }
    };

    const ExtractAndShortenLink = ({ text }) => {
        if (!text) {
            return <p>لا يوجد نص مكتوب</p>;
        }

        return <p>{extractAndShortenLinks(text)}</p>;
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
            {video.userCanUploadHomework == true && (
                <div className="mb-4 p-3" style={{ backgroundColor: '#035971', borderRadius: 10 }}>
                    <h5 className="mb-3">رفع الواجب</h5>
                    {Object.values(errors).map((err, i) => (
                        <Alert key={i} variant="danger">{err[0]}</Alert>
                    ))}
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
            {homeworks
                .filter(homework =>
                    user?.role === 'student'
                        ? homework.user_id === user?.id
                        : true
                )
                .map(homework => (
                    <div key={homework.id} className="p-3 mb-3" style={{ backgroundColor: '#004051', borderRadius: 10 }}>
                        {/* Student Info */}
                        <div className="d-flex align-items-center mb-2">
                            <img
                                src={homework.user.profile_image}
                                alt="User"
                                style={{ width: 40, height: 40, borderRadius: '50%' }}
                            />
                            <div className="ms-3">
                                <p className="m-0 text-white">{homework.user.name}</p>
                                <small className="text-white">
                                    {formatDistanceToNow(parseISO(homework.created_at), {
                                        addSuffix: true,
                                        locale: ar
                                    })}
                                </small>
                            </div>
                        </div>

                        {/* Homework Content */}
                        <div className="p-2 rounded text-white" style={{ backgroundColor: '#035971' }}>
                            <ExtractAndShortenLink text={homework.text} />
                            {homework.file && (
                                <a
                                    href={`/uploads/${homework.file}`}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="btn btn-sm btn-light"
                                >
                                    عرض الملف
                                </a>
                            )}
                        </div>

                        {/* Student Actions */}
                        {((user?.id === homework.user_id && user?.role === 'student') ||
                            user?.role === 'teacher' ||
                            user?.role === 'admin') && (
                                <div className="mt-3 d-flex gap-2">
                                    {/* للطالب المالك فقط - أزرار التعديل والحذف */}
                                    {user?.id === homework.user_id && user?.role === 'student' && (
                                        <>
                                            <Button
                                                variant="warning"
                                                size="sm"
                                                onClick={() => {
                                                    setEditingHomework(homework);
                                                    setEditingText(homework.text);
                                                }}
                                            >
                                                تعديل
                                            </Button>
                                            <Button
                                                variant="danger"
                                                size="sm"
                                                onClick={() => handleDeleteHomework(homework.id)}
                                            >
                                                حذف
                                            </Button>
                                        </>
                                    )}

                                    {/* للمعلمين والمديرين - زر حذف فقط */}
                                    {(user?.role === 'teacher' || user?.role === 'admin') && (
                                        <Button
                                            variant="danger"
                                            size="sm"
                                            onClick={() => handleDeleteHomework(homework.id)}
                                        >
                                            حذف الواجب
                                        </Button>
                                    )}
                                </div>
                            )}
                        {/* Edit Homework Modal */}
                        <Modal
                            show={editingHomework?.id === homework.id}
                            onHide={() => setEditingHomework(null)}
                        >
                            <Modal.Header style={{ backgroundColor: '#02475E', color: 'white' }}>
                                <Modal.Title>تعديل الواجب</Modal.Title>
                            </Modal.Header>
                            <Modal.Body style={{ backgroundColor: '#02475E', color: 'white' }}>
                                <Form onSubmit={(e) => handleUpdateHomework(e, homework.id)}>
                                    <Form.Group className="mb-3">
                                        <Form.Label>نص الواجب:</Form.Label>
                                        <Form.Control
                                            as="textarea"
                                            rows={4}
                                            value={editingText}
                                            onChange={(e) => setEditingText(e.target.value)}
                                        />
                                    </Form.Group>
                                    <Form.Group className="mb-3">
                                        <Form.Label>تغيير الملف (اختياري):</Form.Label>
                                        <Form.Control
                                            type="file"
                                            onChange={(e) => setEditingFile(e.target.files[0])}
                                        />
                                    </Form.Group>
                                    <Button
                                        type="submit"
                                        className="w-100"
                                        style={{ backgroundColor: '#ed6b2f', border: 'none' }}
                                    >
                                        تحديث الواجب
                                    </Button>
                                </Form>
                            </Modal.Body>
                        </Modal>

                        {/* Display existing reply for student */}
                        {(user?.role === 'student' && (homework.reply || homework.rating)) && (
                            <div className="mt-3 p-2 rounded" style={{
                                backgroundColor: '#022c34',
                                border: '1px solid #035971'
                            }}>
                                <h6 className="text-warning mb-2">رد الأستاذ:</h6>
                                <p className="text-white mb-1">
                                    {homework.reply || 'لم يتم إضافة رد بعد.'}
                                </p>
                                {homework.rating && (
                                    <p className="text-info mb-0">
                                        <i className="bi bi-star-fill text-warning"></i>
                                        تقييم: {homework.rating}/5
                                    </p>
                                )}
                            </div>
                        )}

                        {/* Teacher Reply Section */}
                        {(user?.role !== 'student' &&
                            (user?.role === 'teacher' ||
                                user?.role === 'supervisor' ||
                                user?.role === 'admin')) && (
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
                                    {successMessages[homework.id] && (
                                        <span className="text-info d-block mt-2">تم إرسال التقييم بنجاح</span>
                                    )}
                                </div>
                            )}
                    </div>
                ))}
        </div>
    );
};

export default HomeworkSection;