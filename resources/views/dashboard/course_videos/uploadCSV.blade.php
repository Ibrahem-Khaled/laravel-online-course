<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card border-0 shadow-lg overflow-hidden"
            style="border-radius: 20px; background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);">
            <div class="card-header bg-transparent py-4 border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="mb-0 text-primary font-weight-bold">
                        <i class="fas fa-cloud-upload-alt mr-2"></i> رفع ملف CSV للدورة
                    </h3>
                    <div class="icon-circle bg-primary text-white">
                        <i class="fas fa-file-csv"></i>
                    </div>
                </div>
                <p class="text-muted mt-2">يمكنك رفع ملف CSV يحتوي على تفاصيل الفيديوهات دفعة واحدة</p>
            </div>

            <div class="card-body px-5 py-4">
                <form action="{{ route('course.addVideoFromCsvFile', $courseId) }}" method="POST"
                    enctype="multipart/form-data" class="dropzone" id="csvDropzone">
                    @csrf

                    <div class="upload-area text-center p-5 mb-4" id="uploadArea"
                        style="border: 2px dashed #c0c4cc; border-radius: 15px; transition: all 0.3s;">
                        <div class="upload-icon text-primary mb-3">
                            <i class="fas fa-file-csv fa-4x"></i>
                        </div>
                        <h4 class="font-weight-bold mb-2">اسحب وأسقط ملف CSV هنا</h4>
                        <p class="text-muted mb-3">أو</p>
                        <label for="csv_file" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-folder-open mr-2"></i> تصفح الملفات
                        </label>
                        <input type="file" class="d-none" name="csv_file" id="csv_file" required accept=".csv">
                        <p class="small text-muted mt-3">يجب أن يكون الملف بصيغة CSV ولا يتجاوز 5MB</p>
                    </div>

                    <div class="file-details d-none" id="fileDetails">
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x mr-3"></i>
                            <div>
                                <h5 class="mb-1">تم اختيار الملف بنجاح</h5>
                                <p class="mb-0" id="fileName">example.csv</p>
                                <p class="mb-0 small" id="fileSize">3.2 MB</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger ml-auto" id="removeFile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill font-weight-bold shadow-lg"
                            id="uploadBtn" disabled
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; position: relative; overflow: hidden;">
                            <span class="position-relative z-index-1">
                                <i class="fas fa-upload mr-2"></i> رفع الملف
                            </span>
                            <span class="position-absolute top-0 left-0 w-100 h-100 bg-white opacity-10"></span>
                        </button>
                    </div>
                </form>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-muted mb-0">تحتاج إلى مساعدة؟</h6>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill" data-toggle="modal"
                            data-target="#csvFormatModal">
                            <i class="fas fa-question-circle mr-1"></i> نموذج ملف CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for CSV Format -->
<div class="modal fade" id="csvFormatModal" tabindex="-1" role="dialog" aria-labelledby="csvFormatModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="csvFormatModalLabel">نموذج ملف CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>يجب أن يحتوي ملف CSV على الأعمدة التالية بالترتيب:</p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>عنوان الفيديو</th>
                                <th>رابط الفيديو</th>
                                <th>مدة الفيديو (بالدقائق)</th>
                                <th>وصف الفيديو</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>مقدمة الدورة</td>
                                <td>https://example.com/video1.mp4</td>
                                <td>15</td>
                                <td>شرح مقدمة عن الدورة وأهدافها</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="/sample.csv" class="btn btn-outline-primary">
                        <i class="fas fa-download mr-2"></i> تحميل نموذج
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .upload-area:hover {
        border-color: #667eea !important;
        background-color: rgba(102, 126, 234, 0.05);
        transform: translateY(-2px);
    }

    #uploadBtn:disabled {
        opacity: 0.7;
        background: #a0a0a0 !important;
    }

    .dropzone.dz-drag-hover {
        border-color: #667eea;
    }

    .dz-preview.dz-file-preview .dz-image {
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csvFileInput = document.getElementById('csv_file');
        const uploadArea = document.getElementById('uploadArea');
        const fileDetails = document.getElementById('fileDetails');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFileBtn = document.getElementById('removeFile');
        const uploadBtn = document.getElementById('uploadBtn');

        // Handle file selection
        csvFileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const file = this.files[0];
                updateFileDetails(file);
            }
        });

        // Handle drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#667eea';
            this.style.backgroundColor = 'rgba(102, 126, 234, 0.1)';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#c0c4cc';
            this.style.backgroundColor = '';
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#c0c4cc';
            this.style.backgroundColor = '';

            if (e.dataTransfer.files.length > 0) {
                csvFileInput.files = e.dataTransfer.files;
                updateFileDetails(e.dataTransfer.files[0]);
            }
        });

        // Remove file
        removeFileBtn.addEventListener('click', function() {
            csvFileInput.value = '';
            fileDetails.classList.add('d-none');
            uploadArea.classList.remove('d-none');
            uploadBtn.disabled = true;
        });

        // Update file details
        function updateFileDetails(file) {
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

            uploadArea.classList.add('d-none');
            fileDetails.classList.remove('d-none');
            uploadBtn.disabled = false;
        }
    });
</script>
