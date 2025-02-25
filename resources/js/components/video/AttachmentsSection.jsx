import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Modal, Button, Form, Alert, ListGroup } from 'react-bootstrap';
import { extractAndShortenLinks } from '../../utils/helpers';

const AttachmentsSection = ({ video, user }) => {
    const [showModal, setShowModal] = useState(false);
    const [fields, setFields] = useState([{ type: 'attachment', title: '', description: '', image: null, files: [] }]);
    const [attachments, setAttachments] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    useEffect(() => {
        if (video?.video_usage) {
            setAttachments(video.video_usage.filter(u => u.type === 'attachment'));
        }
    }, [video]);

    const handleAddField = () => {
        setFields([...fields, { type: 'attachment', title: '', description: '', image: null, files: [] }]);
    };

    const handleFieldChange = (index, field, value) => {
        const newFields = [...fields];
        newFields[index][field] = value;
        setFields(newFields);
    };

    const handleFileUpload = async (index, files, field) => {
        const newFields = [...fields];
        newFields[index][field] = files;
        setFields(newFields);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        try {
            const formData = new FormData();
            formData.append('course_video_id', video.id);

            fields.forEach((field, index) => {
                formData.append(`usages[${index}][type]`, field.type);
                formData.append(`usages[${index}][title]`, field.title);
                formData.append(`usages[${index}][description]`, field.description);

                if (field.image) {
                    formData.append(`usages[${index}][image]`, field.image);
                }

                if (field.files) {
                    Array.from(field.files).forEach(file => {
                        formData.append(`usages[${index}][files][]`, file);
                    });
                }
            });

            const response = await axios.post('/video-usage/add', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            // التعديل هنا: تحويل البيانات إلى مصفوفة إذا لم تكن كذلك
            const newAttachments = Array.isArray(response.data)
                ? response.data
                : [response.data];

            setAttachments([...attachments, ...newAttachments]);
            setShowModal(false);
            setFields([{ type: 'attachment', title: '', description: '', image: null, files: [] }]);
        } catch (err) {
            setError(err.response?.data?.message || 'حدث خطأ أثناء الإضافة');
        } finally {
            setLoading(false);
        }
    };

    const handleDelete = async (id) => {
        if (window.confirm('هل أنت متأكد من حذف هذا المرفق؟')) {
            try {
                await axios.delete(`/video-usage/${id}`);
                setAttachments(attachments.filter(a => a.id !== id));
            } catch (err) {
                setError(err.response?.data?.message || 'حدث خطأ أثناء الحذف');
            }
        }
    };

    const ExtractAndShortenLink = ({ text }) => {
        if (!text) {
            return <p>لا يوجد نص مكتوب</p>;
        }

        return <p>{extractAndShortenLinks(text)}</p>;
    };

    return (
        <div className="attachments-section mt-4">
            {/* زر الإضافة للصلاحيات */}
            {(user?.role === 'admin' || user?.role === 'supervisor' || user?.role === 'teacher') && (
                <>
                    <Button
                        variant="primary"
                        onClick={() => setShowModal(true)}
                        style={{ backgroundColor: '#ed6b2f', border: 'none', marginBottom: '20px' }}
                    >
                        إضافة مرفقات الدرس
                    </Button>

                    {/* مودال الإضافة */}
                    <Modal show={showModal} onHide={() => setShowModal(false)} size="lg">
                        <Modal.Header style={{ backgroundColor: '#02475E', color: 'white' }}>
                            <Modal.Title>إضافة مرفقات الدرس</Modal.Title>
                        </Modal.Header>
                        <Modal.Body style={{ backgroundColor: '#072D38', color: 'white' }}>
                            {error && <Alert variant="danger">{error}</Alert>}

                            <Form onSubmit={handleSubmit}>
                                {fields.map((field, index) => (
                                    <div key={index} className="field-group mb-4">
                                        {index > 0 && <hr className="my-4" />}

                                        <Form.Group className="mb-3">
                                            <Form.Label>النوع</Form.Label>
                                            <Form.Select
                                                value={field.type}
                                                onChange={(e) => handleFieldChange(index, 'type', e.target.value)}
                                                required
                                                style={{ border: '2px solid #02475E', borderRadius: '8px' }}
                                            >
                                                <option value="attachment">مرفقات</option>
                                            </Form.Select>
                                        </Form.Group>

                                        <Form.Group className="mb-3">
                                            <Form.Label>العنوان</Form.Label>
                                            <Form.Control
                                                type="text"
                                                value={field.title}
                                                onChange={(e) => handleFieldChange(index, 'title', e.target.value)}
                                                required
                                                style={{ border: '2px solid #02475E', borderRadius: '8px' }}
                                            />
                                        </Form.Group>

                                        <Form.Group className="mb-3">
                                            <Form.Label>الوصف</Form.Label>
                                            <Form.Control
                                                as="textarea"
                                                rows={3}
                                                value={field.description}
                                                onChange={(e) => handleFieldChange(index, 'description', e.target.value)}
                                                style={{ border: '2px solid #02475E', borderRadius: '8px' }}
                                            />
                                        </Form.Group>

                                        <Form.Group className="mb-3">
                                            <Form.Label>الصورة</Form.Label>
                                            <Form.Control
                                                type="file"
                                                onChange={(e) => handleFileUpload(index, e.target.files[0], 'image')}
                                                accept="image/*"
                                                style={{ border: '2px solid #02475E', borderRadius: '8px' }}
                                            />
                                        </Form.Group>

                                        <Form.Group className="mb-3">
                                            <Form.Label>الملفات</Form.Label>
                                            <Form.Control
                                                type="file"
                                                onChange={(e) => handleFileUpload(index, e.target.files, 'files')}
                                                multiple
                                                accept=".pdf,.doc,.docx,.zip,.txt"
                                                style={{ border: '2px solid #02475E', borderRadius: '8px' }}
                                            />
                                            <Form.Text className="text-muted">
                                                يمكنك رفع أكثر من ملف (PDF, DOC, ZIP, TXT)
                                            </Form.Text>
                                        </Form.Group>
                                    </div>
                                ))}

                                <div className="mb-4">
                                    <Button
                                        variant="secondary"
                                        onClick={handleAddField}
                                        disabled={loading}
                                    >
                                        إضافة حقل جديد
                                    </Button>
                                </div>

                                <Button
                                    type="submit"
                                    variant="primary"
                                    disabled={loading}
                                    style={{ backgroundColor: '#ed6b2f', border: 'none', width: '100%' }}
                                >
                                    {loading ? 'جاري الإضافة...' : 'إضافة'}
                                </Button>
                            </Form>
                        </Modal.Body>
                    </Modal>
                </>
            )}

            {/* عرض المرفقات */}
            {attachments.length > 0 ? (
                <>
                    <h5 className="text-white mb-4 text-center font-weight-bold">المرفقات</h5>
                    <ListGroup>
                        {attachments.map(attachment => (
                            <ListGroup.Item
                                key={attachment.id}
                                className="mb-3"
                                style={{
                                    backgroundColor: '#004051',
                                    borderRadius: '12px',
                                    border: '1px solid #035971'
                                }}
                            >
                                <h6 style={{ color: '#ed6b2f', fontWeight: 'bold' }}>{attachment.title}</h6>

                                {attachment.description && (
                                    <ExtractAndShortenLink text={attachment.description} />
                                )}

                                <div className="d-flex flex-wrap gap-2">
                                    {attachment.image && (
                                        <Button
                                            variant="light"
                                            href={`/storage/${attachment.image}`}
                                            target="_blank"
                                            className="d-flex align-items-center"
                                        >
                                            <i className="bi bi-image me-2"></i>
                                            عرض الصورة
                                        </Button>
                                    )}

                                    {attachment.file && (
                                        <Button
                                            variant="light"
                                            href={`/storage/${attachment.file}`}
                                            target="_blank"
                                            className="d-flex align-items-center"
                                        >
                                            <i className="bi bi-file-earmark me-2"></i>
                                            تحميل الملف
                                        </Button>
                                    )}
                                </div>

                                {(user?.role === 'admin' || user?.role === 'supervisor' || user?.role === 'teacher') && (
                                    <div className="mt-3">
                                        <Button
                                            variant="danger"
                                            size="sm"
                                            onClick={() => handleDelete(attachment.id)}
                                        >
                                            <i className="bi bi-trash me-1"></i>
                                            مسح
                                        </Button>
                                    </div>
                                )}
                            </ListGroup.Item>
                        ))}
                    </ListGroup>
                </>
            ) : (
                <h5 className="text-white mb-3 text-center">لا يوجد مرفقات</h5>
            )}
        </div>
    );
};

export default AttachmentsSection;