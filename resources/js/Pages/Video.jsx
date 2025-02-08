import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'font-awesome/css/font-awesome.min.css';
import '../styles/video.css';
import Sidebar from '../components/video/SideBar';
import DiscussionSection from '../components/video/DiscussionSection';
import HomeworkSection from '../components/video/HomeworkSection';
import AttachmentsSection from '../components/video/AttachmentsSection';

const Video = ({ course, userRole, duration_in_hours, user, rating }) => {
  const [showEditor, setShowEditor] = useState(false);
  const [video, setVideo] = useState(course.videos[0]);

  useEffect(() => {
    if (showEditor && document.getElementById('description-editor')) {
      const quill = new Quill('#description-editor', {
        theme: 'snow',
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link']
          ]
        }
      });

      const form = document.getElementById('description-form');
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const descriptionInput = document.getElementById('description-input');
        descriptionInput.value = quill.root.innerHTML;
        // Handle form submission here
      });
    }
  }, [showEditor]);

  const toggleDescriptionEditor = () => {
    setShowEditor(!showEditor); 
  };

  const deviceTranslations = {
    web: { label: 'ويب', icon: <i className="fas fa-globe"></i> },
    mobile: { label: 'جوال', icon: <i className="fas fa-mobile-alt"></i> },
    desktop: { label: 'كمبيوتر', icon: <i className="fas fa-desktop"></i> },
    tablet: { label: 'تابلت', icon: <i className="fas fa-tablet-alt"></i> },
    tv: { label: 'تلفزيون', icon: <i className="fas fa-tv"></i> },
    other: { label: 'أخرى', icon: <i className="fas fa-question-circle"></i> },
    all: { label: 'جميع الأجهزة', icon: <i className="fas fa-layer-group"></i> },
  };

  const device = video?.device || 'web';

  return (
    <div className="container main-content">
      <div className="row" style={{ direction: 'rtl' }}>
        <div className="col-lg-8">
          <div className="course-info">
            <h2 className="course-title">{course.title}</h2>
            <div className="course-meta">
              <span>
                المتطلبات: {deviceTranslations[device].label} {deviceTranslations[device].icon}
              </span>
              <h6>|</h6>
              <span>الوقت: {duration_in_hours}</span>
              <h6>|</h6>
              <span>الدروس: {course.videos.length}</span>
              <h6>|</h6>
              <span>
                مستوى الدورة:
                {course.difficulty_level === 'beginner' && ' للمبتدئين'}
                {course.difficulty_level === 'intermediate' && ' للمتوسطين'}
                {course.difficulty_level === 'advanced' && ' للمتقدمين'}
              </span>
              <h6>|</h6>
              <div className="d-flex align-items-center gap-2 rating-container">
                <span className="badge text-white text-dark rating-text" style={{ backgroundColor: '#ed6b2f' }}>
                  {Math.round(rating || 0, 1)}
                </span>
                <div className="rating-stars">
                  {Array.from({ length: 5 }, (_, i) => (
                    <i
                      key={i}
                      className={`fas ${i < Math.floor(rating || 0)
                        ? 'fa-star'
                        : i - (rating || 0) < 1
                          ? 'fa-star-half-alt'
                          : 'far fa-star text-secondary'
                        }`}
                      style={{ color: '#ed6b2f' }}
                    ></i>
                  ))}
                </div>
              </div>
            </div>
          </div>

          <div className="video-container" dangerouslySetInnerHTML={{ __html: video.video }}></div>

          <ul className="nav nav-tabs" id="videoTabs" role="tablist">
            <li className="nav-item" role="presentation">
              <button className="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">
                محتوي الدرس
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button className="nav-link" id="sources-tab" data-bs-toggle="tab" data-bs-target="#sources" type="button" role="tab" aria-controls="sources" aria-selected="false">
                المرفقات
                {video?.videoInUsageCount > 0 && (
                  <span id="homework-counter" className="badge bg-danger">
                    {video?.videoInUsageCount}
                  </span>
                )}
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button className="nav-link" id="homework-tab" data-bs-toggle="tab" data-bs-target="#homework" type="button" role="tab" aria-controls="homework" aria-selected="false">
                الواجبات
                {video?.unresolvedHomeworksCount > 0 && (
                  <span id="homework-counter" className="badge bg-danger">
                    {video?.unresolvedHomeworksCount}
                  </span>
                )}
              </button>
            </li>
            <li className="nav-item" role="presentation">
              <button className="nav-link" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion" type="button" role="tab" aria-controls="discussion" aria-selected="false">
                المناقشة
              </button>
            </li>
          </ul>
          <div className="tab-content" id="videoTabsContent">
            <div className="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
              {userRole && ['admin', 'supervisor', 'teacher'].includes(userRole) && (
                <button className="edit-description-btn" onClick={toggleDescriptionEditor}>
                  {showEditor ? 'إلغاء التعديل' : 'تعديل الوصف'}
                </button>
              )}
              <div id="description-content" className="description-content" style={{ display: showEditor ? 'none' : 'block' }}>
                <div dangerouslySetInnerHTML={{ __html: video.description }}></div>
              </div>
              {userRole && ['admin', 'supervisor', 'teacher'].includes(userRole) && (
                <form id="description-form" style={{ display: showEditor ? 'block' : 'none' }}>
                  <div id="description-editor" style={{ height: '300px' }}></div>
                  <input type="hidden" id="description-input" name="description" />
                  <button type="submit" className="btn btn-primary mt-3">
                    حفظ التعديلات
                  </button>
                  <button type="button" className="btn btn-secondary mt-3" onClick={toggleDescriptionEditor}>
                    إلغاء
                  </button>
                </form>
              )}
            </div>
            <div className="tab-pane fade" id="sources" role="tabpanel" aria-labelledby="sources-tab">
              <AttachmentsSection video={video} user={user} />
            </div>
            <div className="tab-pane fade" id="homework" role="tabpanel" aria-labelledby="homework-tab">
              <HomeworkSection video={video} user={user} />
            </div>
            <div className="tab-pane fade" id="discussion" role="tabpanel" aria-labelledby="discussion-tab">
              <DiscussionSection video={video} user={user} />
            </div>
          </div>
        </div>
        <Sidebar
          course={course}
          video={video}
          setVideo={setVideo}
          user={user}
        />
      </div>
    </div>
  );
};

export default Video;