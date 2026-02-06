@extends('admin.master')
@section('title', 'Edit Questionnaire')
@push('style-link')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/questionnaire-style.css') }}">
@endpush
@push('style')
    <style>
        .editCategoryTitleBtn {
            background: none;
            border: none;
            font-size: 1rem;
            line-height: 1;
            opacity: 0.7;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
            margin-left: 0.5rem;
        }

        .custom-slider {
            width: 100%;
            appearance: none;
            height: 12px;
            border-radius: 20px;
            background: linear-gradient(to right, #e0e0e0, #007bff);
            outline: none;
        }

        .custom-slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            border: 2px solid #ccc;
        }

        .range-labels {
            display: flex;
            justify-content: space-between;
            color: black;
            font-size: 14px;
            margin-top: 5px;
        }

        .custom-tooltip {
            position: relative;
            top: -4px;
        }

        .custom-tooltip .tooltip-text {
            background-color: #000;
            color: white;
            padding: 4px 8px;
            font-size: 14px;
            border-radius: 4px;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        .custom-tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }
    </style>
@endpush
@push('modal')
    <!-- Toast Container -->
    <div class="toast-container">
        <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert"
             aria-live="assertive"
             aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="toastMessage">Operation successful</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
            </div>
        </div>
    </div>
@endpush

@section('main')
    <!-- Welcome Screen -->
    <div id="welcomeScreen" class="welcome-screen">
        <div class="welcome-card">
            <div class="welcome-icon">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <h1 class="welcome-title">Questionnaire Builder</h1>
            <div class="title-input-group">
                <input type="text" class="title-input" id="welcomeTitleInput"
                       placeholder="Enter your questionnaire title..." maxlength="100">
            </div>
            <button type="button" class="start-btn" id="startBuildingBtn" disabled>
                <span class="btn-text">Start Editing</span>
                <span class="loading-spinner d-none"></span>
            </button>
        </div>
    </div>

    <!-- Main Application -->
    <div id="mainApp" class="main-app">
        <!-- Header -->
        <header class="app-header">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h1 class="app-title" id="appTitle">Questionnaire Builder</h1>
                        <p class="app-subtitle">Building: <span id="currentTitle">Untitled Questionnaire</span></p>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-primary btn-sm me-2" id="editTitleBtn">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Title
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm saveButton" id="saveButton">
                            <i class="bi bi-save me-1"></i>
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Container -->
        <div class="main-container">
            <!-- Category Section -->
            <div class="category-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="bi bi-folder me-2"></i>
                        Categories
                    </h5>
                    <small class="text-muted">Organize your questions into categories</small>
                </div>

                <div class="category-tabs-wrapper">
                    <div id="categoryTabsContainer">
                        <!-- Tabs will be rendered here -->
                    </div>
                    <div class="add-category-btn" id="addCategoryBtn" title="Add New Category">
                        <i class="bi bi-plus"></i>
                        <div class="category-input" id="categoryInput">
                            <input type="text" placeholder="Category name..." id="newCategoryName" maxlength="20">

                            <!-- Category Image Upload -->
                            <div class="mb-3">
                                <label class="form-label small">Category Image (Optional)</label>
                                <div class="image-upload-container">
                                    <input type="file" class="form-control form-control-sm" id="categoryImageInput"
                                           accept="image/*">
                                    <div class="image-preview mt-2" id="categoryImagePreview" style="display: none;">
                                        <img src="/placeholder.svg" alt="Category preview" class="img-thumbnail"
                                             style="max-width: 100px; max-height: 100px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                id="removeCategoryImage">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    <div class="upload-progress mt-2" id="categoryUploadProgress"
                                         style="display: none;">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary btn-sm flex-fill" id="saveCategoryBtn">
                                    <i class="bi bi-check"></i> Add
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm flex-fill" id="cancelCategoryBtn">
                                    <i class="bi bi-x"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <div id="categoryContent">
                    <!-- Category content will be rendered here -->
                </div>
            </div>

            <!-- Question Builder Form -->
            <div id="questionBuilder" class="question-builder" style="display: none;">
                <div class="question-builder-header">
                    <h5 class="question-builder-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span id="formTitle">Add New Question</span>
                    </h5>
                </div>
                <div class="question-builder-body">
                    <form id="questionForm">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="questionTitle" class="form-label">Question Text</label>
                                <input type="text" class="form-control" id="questionTitle"
                                       placeholder="Enter your question here" required>
                            </div>
                        </div>

                        <!-- Question Image Upload -->
                        <div class="mb-3">
                            <label class="form-label">Question Image (Optional)</label>
                            <div class="image-upload-container">
                                <input type="file" class="form-control" id="questionImageInput" accept="image/*">
                                <div class="image-preview mt-2" id="questionImagePreview" style="display: none;">
                                    <img src="/placeholder.svg" alt="Question preview" class="img-thumbnail"
                                         style="max-width: 200px; max-height: 150px;">
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                            id="removeQuestionImage">
                                        <i class="bi bi-x"></i> Remove
                                    </button>
                                </div>
                                <div class="upload-progress mt-2" id="questionUploadProgress" style="display: none;">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Question Comment Field -->
                        <div class="mb-3">
                            <label for="questionComment" class="form-label">Question Comment/Description
                                (Optional)</label>
                            <textarea class="form-control" id="questionComment" rows="2"
                                      placeholder="Add additional context or instructions for this question"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Question Type</label>
                            <div id="selectedTypeDisplay" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <div id="selectedTypeBadge" class="badge me-2"></div>
                                    <button type="button" id="changeTypeBtn"
                                            class="btn btn-sm btn-outline-secondary">Change Type
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="selectTypeBtn" class="btn btn-outline-primary w-100">
                                <i class="bi bi-grid-3x3-gap me-2"></i>
                                Select Question Type
                            </button>

                            <!-- Type Selector -->
                            <div id="typeSelector" class="mt-3 p-3 border rounded bg-light" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Select Question Type</h6>
                                    <button type="button" id="closeSelectorBtn" class="btn-close"
                                            aria-label="Close"></button>
                                </div>
                                <div class="row g-3" id="typeOptions"></div>
                            </div>
                        </div>

                        <!-- Type-specific fields will be inserted here -->
                        <div id="typeSpecificFields"></div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="requiredCheck" checked>
                            <label class="form-check-label" for="requiredCheck">
                                <i class="bi bi-asterisk text-danger me-1"></i>
                                Required Question
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" id="cancelEditBtn" class="btn btn-outline-secondary"
                                    style="display: none;">
                                <i class="bi bi-x me-1"></i>
                                Cancel
                            </button>
                            <button type="button" id="clearBtn" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i>
                                Clear
                            </button>
                            <button type="submit" id="addQuestionBtn" class="btn btn-primary" disabled>
                                <i class="bi bi-plus-lg me-2"></i>
                                Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Floating Controls -->
        <div class="floating-controls">
            <button type="button" class="control-btn btn-save saveButton" title="Save Questionnaire">
                <i class="bi bi-save"></i>
            </button>
            <button type="button" class="control-btn btn-preview" id="toggleModeBtn" title="Preview Mode">
                <i class="bi bi-eye"></i>
            </button>
            <button type="button" class="control-btn btn-download" id="saveBtn" title="Download JSON">
                <i class="bi bi-download"></i>
            </button>
            <button type="button" class="control-btn btn-clear" id="clearAllBtn" title="Clear All">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>

@endsection

@section('script')

    <script !src="">
        $(document).ready(function () {
            localStorage.removeItem("questionnaire_questions")
            localStorage.removeItem("questionnaire_categories")
            localStorage.removeItem("questionnaire_active_category")
            localStorage.removeItem("questionnaire_title")


            let tableQue = @json($questionnaire->payload)

                let
            parseQue = JSON.parse(tableQue);


            localStorage.setItem('questionnaire_questions', JSON.stringify(parseQue.questions));
            localStorage.setItem('questionnaire_categories', JSON.stringify(parseQue.categories));
            localStorage.setItem('questionnaire_title', "{{$questionnaire->name}}");
        });
    </script>


    <script>
        // Question Types Configuration
        const QUESTION_TYPES = {
            RADIO: {
                label: "Multiple Choice",
                value: "RADIO",
                icon: "bi-record-circle",
                description: "Single selection from multiple options",
            },
            SLIDER: {
                label: "Slider",
                value: "SLIDER",
                icon: "bi-sliders",
                description: "Select a value within a range",
            },
            SELECT: {
                label: "Dropdown",
                value: "SELECT",
                icon: "bi-menu-down",
                description: "Select from a dropdown menu",
            },
            AMOUNT: {
                label: "{{ currency_icon() }} Numeric Amount",
                value: "AMOUNT",
                // icon: "bi-currency-dollar",
                description: "Enter a numeric value",
            },
            TEXT: {
                label: "Short Text",
                value: "TEXT",
                icon: "bi-input-cursor-text",
                description: "Brief text response",
            },
            COMMENT: {
                label: "Long Text",
                value: "COMMENT",
                icon: "bi-card-text",
                description: "Detailed text response",
            },
        }

        // Global State
        let questions = []
        let categories = []
        let activeCategory = null
        let isPreviewMode = false
        let currentQuestionType = ""
        let editingQuestionId = null
        let sortableInstance = null
        let questionnaireTitle = ""
        let currentQuestionImageUrl = ""
        let currentCategoryImageUrl = ""

        // Toast instance
        let toastInstance = null

        // Initialize the application
        $(document).ready(() => {
            toastInstance = new bootstrap.Toast(document.getElementById("toast"))

            loadDataFromStorage()
            initializeWelcomeScreen()
        })

        function initializeWelcomeScreen() {
            setupWelcomeEventListeners()

            // If we have a saved title, show the main app
            if (questionnaireTitle) {
                $("#welcomeTitleInput").val(questionnaireTitle)
                $("#startBuildingBtn").prop("disabled", false)
            }
        }

        function setupWelcomeEventListeners() {
            // Title input validation
            $("#welcomeTitleInput").on("input", function () {
                const title = $(this).val().trim()
                $("#startBuildingBtn").prop("disabled", !title)
            })

            // Enter key to start
            $("#welcomeTitleInput").keypress((e) => {
                if (e.which === 13 && !$("#startBuildingBtn").prop("disabled")) {
                    startBuilding()
                }
            })

            // Start building button
            $("#startBuildingBtn").click(startBuilding)
        }

        function startBuilding() {
            const title = $("#welcomeTitleInput").val().trim()
            if (!title) return

            // Show loading state
            const btn = $("#startBuildingBtn")
            btn.prop("disabled", true)
            btn.find(".btn-text").text("Loading...")
            btn.find(".loading-spinner").removeClass("d-none")

            // Save title
            questionnaireTitle = title
            localStorage.setItem("questionnaire_title", title)

            // Simulate loading for smooth transition
            setTimeout(() => {
                // Hide welcome screen and show main app
                $("#welcomeScreen").fadeOut(500, () => {
                    $("#mainApp").fadeIn(500)
                    initializeMainApp()
                })
            }, 1000)
        }

        function initializeMainApp() {
            setupMainEventListeners()
            renderTypeOptions()

            // Update title display
            $("#currentTitle").text(questionnaireTitle)

            // Create default category if none exist
            if (categories.length === 0) {
                createDefaultCategory()
            }

            renderCategoryTabs()
            updateCategoryContent()
        }

        function createDefaultCategory() {
            const defaultCategory = {
                id: "default",
                name: "General",
                imageUrl: "",
            }
            categories.push(defaultCategory)
            activeCategory = "default"
            saveDataToStorage()
        }

        $(document).on('click', '#cancelCategoryBtn', function () {
            hideCategoryInput();
        })

        function setupMainEventListeners() {
            // Category management
            $("#addCategoryBtn").click(showCategoryInput)
            $("#saveCategoryBtn").click(handleAddCategory)
            // $("#cancelCategoryBtn").click(hideCategoryInput)
            $("#newCategoryName").keypress((e) => {
                if (e.which === 13) {
                    handleAddCategory()
                }
                if (e.which === 27) {
                    hideCategoryInput()
                }
            })

            // Category image upload
            $("#categoryImageInput").change(handleCategoryImageUpload)
            $("#removeCategoryImage").click(removeCategoryImage)

            // Question image upload
            $("#questionImageInput").change(handleQuestionImageUpload)
            $("#removeQuestionImage").click(removeQuestionImage)

            // Title editing
            $("#editTitleBtn").click(editTitle)

            // Title editing
            $(document).on("click", ".editCategoryTitleBtn", function (e) {
                e.stopPropagation();

                const categoryId = $(this).closest(".category-tab").data("category-id");
                const categoryName = $(this).closest(".category-tab").data("category-name");
                const categoryImage = $(this).closest(".category-tab").data("category-image");
                const placeholder = "{{ asset('assets/logo/placeholder.svg') }}";

                Swal.fire({
                    title: "Edit Category",
                    html: `
                        <input id="swal-category-name" class="swal2-input mx-0 w-100" placeholder="Category name..." value="${categoryName}">

                        <label class="form-label small" style="display:block; text-align:left; margin:10px 0 5px;">Category Image (Optional)</label>
                        <input type="file" class="form-control form-control-sm" id="swal-category-image" accept="image/*">
                        <input type="hidden" id="swal-category-old-image" value="${categoryImage}">

                        <div class="image-preview mt-2" style="align-items: center; gap: 10px; margin-top: 10px;">
                            <img src="${categoryImage || placeholder}" alt="Category preview" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" id="swal-image-preview">
                            <button type="button" class="btn btn-sm btn-outline-danger" id="remove-image-btn" data-id="${categoryId}">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: "Update",
                    cancelButtonText: "Cancel",
                    preConfirm: () => {
                        const name = document.getElementById("swal-category-name").value.trim();
                        const fileInput = document.getElementById("swal-category-image");
                        const oldImage = document.getElementById("swal-category-old-image").value.trim();
                        const file = fileInput.files[0];

                        return new Promise((resolve, reject) => {
                            if (!name) {
                                reject("Title cannot be empty");
                            }

                            if (file) {
                                const reader = new FileReader();
                                reader.onload = () => {
                                    resolve({name, image: reader.result});
                                };
                                reader.readAsDataURL(file); // Convert image to base64
                            } else {
                                resolve({name, image: oldImage}); // No image changed
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {name, image} = result.value;

                        categories.forEach((category) => {
                            if (category.id == categoryId) {
                                category.name = name;
                                category.imageUrl = image;
                            }
                        });

                        saveDataToStorage();
                        renderCategoryTabs();
                    }
                });

                // Preview image on change
                $(document).on("change", "#swal-category-image", function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $("#swal-image-preview").attr("src", e.target.result).show();
                            $("#remove-image-btn").show().data("remove", false); // Image added, unmark remove
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Handle remove image
                $(document).on("click", "#remove-image-btn", function () {
                    var categoryId = $(this).data('id');
                    categories.forEach((category) => {
                        if (category.id == categoryId) {
                            category.imageUrl = "";
                        }
                    });
                    $("#swal-image-preview").attr("src", "").hide();
                    $(this).hide().data("removed", true);
                    $("#swal-category-image").val(""); // clear file input too
                    $("#swal-category-old-image").val(""); // clear file input too

                    saveDataToStorage();
                    renderCategoryTabs();
                });

            });

            // Question form
            $("#questionForm").submit(handleAddQuestion)
            $("#clearBtn").click(clearForm)
            $("#cancelEditBtn").click(cancelEdit)
            $("#questionTitle").on("input", validateForm)
            $("#questionComment").on("input", validateForm)

            // Type selector
            $("#selectTypeBtn").click(() => showTypeSelector())
            $("#changeTypeBtn").click(() => showTypeSelector())
            $("#closeSelectorBtn").click(hideTypeSelector)

            // Required checkbox
            $("#requiredCheck").change(validateForm)

            // Control buttons
            $("#toggleModeBtn").click(togglePreviewMode)
            $("#clearAllBtn").click(clearAll)
            $("#saveBtn").click(saveQuestionnaire)

            // Dynamic event handlers
            $(document).on("click", ".category-tab", function () {
                const categoryId = $(this).data("category-id")
                setActiveCategory(String(categoryId))
            })

            $(document).on("click", ".category-tab .close-btn", function (e) {
                e.stopPropagation()
                const categoryId = $(this).closest(".category-tab").data("category-id")
                deleteCategory(String(categoryId))
            })

            $(document).on("click", ".add-question-btn", () => {
                showQuestionBuilder()
            })

            $(document).on("click", ".edit-question", function (e) {
                e.preventDefault()
                e.stopPropagation()
                const questionId = $(this).data("question-id")
                editQuestion(questionId)
            })

            $(document).on("click", ".delete-question", function (e) {
                e.preventDefault()
                e.stopPropagation()
                const questionId = $(this).data("question-id")
                deleteQuestion(questionId)
            })

            $(document).on("input", ".slider-input", function () {
                const value = $(this).val()
                // $(this).siblings(".d-flex").find(".slider-value").text(value)
                $(this).closest('div').find('.slider-value').text(value)
            })

            // Score input handlers
            $(document).on("input", ".score-input", () => {
                validateForm()
            })
        }

        // Image Upload Functions
        function handleQuestionImageUpload(e) {
            const file = e.target.files[0]
            if (!file) return

            if (!file.type.startsWith("image/")) {
                showToast("Please select a valid image file", "danger")
                return
            }

            // Show progress
            $("#questionUploadProgress").show()
            const progressBar = $("#questionUploadProgress .progress-bar")

            // Simulate upload progress (replace with actual AJAX call)
            simulateImageUpload(file, progressBar, (imageUrl) => {
                currentQuestionImageUrl = imageUrl
                showImagePreview("#questionImagePreview", imageUrl)
                $("#questionUploadProgress").hide()
                showToast("Image uploaded successfully", "success")
            })
        }

        function handleCategoryImageUpload(e) {
            const file = e.target.files[0]
            if (!file) return

            if (!file.type.startsWith("image/")) {
                showToast("Please select a valid image file", "danger")
                return
            }

            // Show progress
            $("#categoryUploadProgress").show()
            const progressBar = $("#categoryUploadProgress .progress-bar")

            // Simulate upload progress (replace with actual AJAX call)
            simulateImageUpload(file, progressBar, (imageUrl) => {
                currentCategoryImageUrl = imageUrl
                showImagePreview("#categoryImagePreview", imageUrl)
                $("#categoryUploadProgress").hide()
                showToast("Category image uploaded successfully", "success")
            })
        }

        function simulateImageUpload(file, progressBar, callback) {
            // This simulates an AJAX upload - replace with your actual upload logic
            // let progress = 0
            // const interval = setInterval(() => {
            //     progress += Math.random() * 30
            //     if (progress >= 100) {
            //         progress = 100
            //         clearInterval(interval)

            // Create a temporary URL for the uploaded file (in real implementation, use the URL from server)
            // const imageUrl = URL.createObjectURL(file)
            // callback(imageUrl)
            //     }
            //     progressBar.css("width", progress + "%")
            // }, 200)

            // Here's where you would make your actual AJAX call:

            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', "{{csrf_token()}}");

            $.ajax({
                url: "{{route('admin.questionnaire.upload.images')}}", // Your upload endpoint
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = evt.loaded / evt.total * 100;
                            progressBar.css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function (response) {
                    callback(response.data.imageUrl); // Use the URL returned from server
                },
                error: function () {
                    showToast('Upload failed', 'danger');
                    progressBar.parent().parent().hide();
                }
            });

        }

        function showImagePreview(previewSelector, imageUrl) {
            const preview = $(previewSelector)
            preview.find("img").attr("src", imageUrl)
            preview.show()
        }

        function removeQuestionImage() {
            currentQuestionImageUrl = ""
            $("#questionImagePreview").hide()
            $("#questionImageInput").val("")
            showToast("Image removed", "info")
        }

        function removeCategoryImage() {
            currentCategoryImageUrl = ""
            $("#categoryImagePreview").hide()
            $("#categoryImageInput").val("")
            showToast("Category image removed", "info")
        }

        function editTitle() {
            Swal.fire({
                title: "Edit Questionnaire Title",
                input: "text",
                inputValue: questionnaireTitle,
                inputPlaceholder: "Enter questionnaire title",
                showCancelButton: true,
                confirmButtonText: "Update",
                cancelButtonText: "Cancel",
                inputValidator: (value) => {
                    if (!value.trim()) {
                        return "Title cannot be empty"
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    questionnaireTitle = result.value.trim()
                    $("#currentTitle").text(questionnaireTitle)
                    localStorage.setItem("questionnaire_title", questionnaireTitle)
                    showToast("Title updated successfully", "success")
                }
            })
        }

        // Category Management Functions
        function showCategoryInput() {
            $("#categoryInput").addClass("show")
            $("#newCategoryName").focus()
            currentCategoryImageUrl = ""
            $("#categoryImagePreview").hide()
            $("#categoryImageInput").val("")
        }

        function hideCategoryInput() {
            $("#categoryInput").removeClass("show")
            $("#newCategoryName").val("")
            currentCategoryImageUrl = ""
            $("#categoryImagePreview").hide()
            $("#categoryImageInput").val("")
        }

        function handleAddCategory() {
            const name = $("#newCategoryName").val().trim()
            if (!name) {
                showToast("Category name is required", "danger")
                return
            }

            if (categories.some((cat) => cat.name.toLowerCase() === name.toLowerCase())) {
                showToast("Category name already exists", "danger")
                return
            }

            const newCategory = {
                id: Date.now().toString(),
                name: name,
                imageUrl: currentCategoryImageUrl || "",
            }

            categories.push(newCategory)
            activeCategory = newCategory.id
            saveDataToStorage()
            renderCategoryTabs()
            updateCategoryContent()
            hideCategoryInput()
            showToast("Category added successfully", "success")
        }

        function deleteCategory(categoryId) {
            if (categories.length <= 1) {
                showToast("Cannot delete the last category", "warning")
                return
            }

            const categoryQuestions = questions.filter((q) => q.categoryId === categoryId)
            if (categoryQuestions.length > 0) {
                Swal.fire({
                    title: "Category has questions",
                    text: `This category contains ${categoryQuestions.length} question(s). Delete anyway?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete all!",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-secondary",
                    buttonsStyling: true,
                }).then((result) => {
                    if (result.value) {
                        performCategoryDeletion(categoryId)
                    }
                })
            } else {
                performCategoryDeletion(categoryId)
            }
        }

        function performCategoryDeletion(categoryId) {
            categories = categories.filter((cat) => cat.id !== categoryId)
            questions = questions.filter((q) => q.categoryId !== categoryId)

            if (activeCategory === categoryId) {
                activeCategory = categories[0]?.id || null
            }

            saveDataToStorage()
            renderCategoryTabs()
            updateCategoryContent()
            showToast("Category deleted successfully", "danger")
        }

        function setActiveCategory(categoryId) {
            activeCategory = categoryId
            renderCategoryTabs()
            updateCategoryContent()
        }

        function renderCategoryTabs() {
            const container = $("#categoryTabsContainer")
            container.empty()

            categories.forEach((category) => {
                const questionCount = questions.filter((q) => q.categoryId === category.id).length
                const isActive = category.id === activeCategory

                const tab = $(`
                    <div class="category-tab ${isActive ? "active" : ""}" data-category-id="${category.id}" data-category-name="${category.name}" data-category-image="${category.imageUrl}">
                        ${category.imageUrl ? `<img src="${category.imageUrl}" alt="${category.name}" style="width: 20px; height: 20px; border-radius: 50%; margin-right: 0.5rem; object-fit: cover;">` : ""}
                        <span class="tab-name">${category.name}</span>
                        ${questionCount > 0 ? `<span class="question-count-badge">${questionCount}</span>` : ""}
                        <button type="button" class="editCategoryTitleBtn" title="Edit category"><i class="bi bi-pencil"></i></button>
                        ${categories.length > 1 ? `<button type="button" class="close-btn text-black" title="Delete category"><i class="bi bi-x"></i></button>` : ""}
                    </div>
                `)

                container.append(tab)
            })
        }

        function updateCategoryContent() {
            const container = $("#categoryContent")
            container.empty()

            if (!activeCategory) {
                container.html('<div class="text-center p-5 text-muted">No categories available</div>')
                return
            }

            const categoryQuestions = questions.filter((q) => q.categoryId === activeCategory)
            const currentCategory = categories.find((c) => c.id === activeCategory)

            if (categoryQuestions.length === 0 && !isPreviewMode) {
                container.html(`
            <div class="add-question-area">
                <button type="button" class="add-question-btn">
                    <i class="bi bi-plus"></i>
                </button>
                <div class="add-question-text">Add your first question</div>
                <div class="add-question-subtext">Click the button above to start building your questionnaire</div>
            </div>
        `)
            } else {
                if (isPreviewMode) {
                    const categoryName = currentCategory?.name || "Unknown"
                    let categoryHeader = `
                <div class="p-4 bg-light border-bottom">
                    <h4 class="mb-0">
                        <i class="bi bi-eye me-2"></i>
                        Preview: ${categoryName}
                    </h4>
                </div>
            `

                    if (currentCategory?.imageUrl) {
                        categoryHeader = `
                    <div class="p-4 bg-light border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="${currentCategory.imageUrl}" alt="${categoryName}"
                                 style="width: 60px; height: 60px; border-radius: 8px; margin-right: 1rem; object-fit: cover;">
                            <h4 class="mb-0">
                                <i class="bi bi-eye me-2"></i>
                                Preview: ${categoryName}
                            </h4>
                        </div>
                    </div>
                `
                    }

                    container.append(categoryHeader)
                }

                const questionsContainer = $('<div class="p-3"></div>')

                categoryQuestions.forEach((question, index) => {
                    const questionHtml = createQuestionItem(question, index)
                    questionsContainer.append(questionHtml)
                })

                container.append(questionsContainer)

                if (!isPreviewMode) {
                    container.append(`
                <div class="add-question-area">
                    <button type="button" class="add-question-btn">
                        <i class="bi bi-plus"></i>
                    </button>
                    <div class="add-question-text">Add another question</div>
                    <div class="add-question-subtext">Continue building your questionnaire</div>
                </div>
            `)
                }

                setupDragAndDrop()
            }
        }

        // Question Management Functions
        function showQuestionBuilder() {
            $("#questionBuilder").slideDown(400)
            $("html, body").animate(
                {
                    scrollTop: $("#questionBuilder").offset().top - 100,
                },
                400,
            )
            $("#questionTitle").focus()
        }

        function hideQuestionBuilder() {
            $("#questionBuilder").slideUp(400)
            clearForm()
        }

        function addQuestion(question) {
            const newQuestion = {
                ...question,
                id: Date.now().toString(),
                categoryId: activeCategory,
                imageUrl: currentQuestionImageUrl || "",
                comment: $("#questionComment").val().trim(),
            }

            questions.push(newQuestion)
            renderCategoryTabs()
            updateCategoryContent()
            hideQuestionBuilder()
            showToast("Question added successfully", "success")
        }

        function updateQuestion(id, updatedQuestion) {
            const index = questions.findIndex((q) => q.id === String(id))
            if (index !== -1) {
                questions[index] = {
                    ...updatedQuestion,
                    id: String(id),
                    categoryId: activeCategory,
                    imageUrl: currentQuestionImageUrl || "",
                    comment: $("#questionComment").val().trim(),
                }
                saveDataToStorage()
                renderCategoryTabs()
                updateCategoryContent()
                hideQuestionBuilder()
                showToast("Question updated successfully", "success")
            }
        }

        function deleteQuestion(id) {
            Swal.fire({
                title: "Delete Question?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                confirmButtonClass: "btn btn-danger",
                cancelButtonClass: "btn btn-secondary",
                buttonsStyling: true,
            }).then((result) => {
                if (result.value) {
                    questions = questions.filter((q) => q.id !== String(id))
                    saveDataToStorage()
                    renderCategoryTabs()
                    updateCategoryContent()
                    showToast("Question deleted successfully", "danger")
                }
            })
        }

        function editQuestion(questionId) {
            const question = questions.find((q) => q.id === String(questionId))
            if (!question) return

            editingQuestionId = questionId
            $("#formTitle").text("Edit Question")
            $("#addQuestionBtn").html('<i class="bi bi-check-lg me-2"></i>Save Changes')
            $("#cancelEditBtn").show()

            $("#questionTitle").val(question.title)
            $("#questionComment").val(question.comment || "")
            $("#requiredCheck").prop("checked", question.required)

            // Set question image
            currentQuestionImageUrl = question.imageUrl || ""
            if (currentQuestionImageUrl) {
                showImagePreview("#questionImagePreview", currentQuestionImageUrl)
            }

            selectQuestionType(question.type)

            setTimeout(() => {
                switch (question.type) {
                    case "RADIO":
                        populateOptionsWithScores(question.options, "#radioOptions", "bi-record-circle")
                        break
                    case "SELECT":
                        populateOptionsWithScores(question.options, "#selectOptions", "bi-menu-down")
                        break
                    case "SLIDER":
                        populateOptionsWithScores(question.options, "#radioOptions", "bi-record-circle")
                        // $("#minValue").val(question.minValue)
                        // $("#maxValue").val(question.maxValue)
                        // $("#stepValue").val(question.step)
                        // updateSliderPreview()
                        break
                    case "AMOUNT":
                    case "TEXT":
                    case "COMMENT":
                        $("#placeholderText").val(question.placeholder || "")
                        break
                }
                validateForm()
            }, 100)

            showQuestionBuilder()
        }

        // Question Form Functions
        function renderTypeOptions() {
            const container = $("#typeOptions")
            container.empty()

            Object.values(QUESTION_TYPES).forEach((type) => {
                const typeCard = $(`
            <div class="col-md-6">
                <div class="card h-100 cursor-pointer border-0 shadow-sm" data-type="${type.value}">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi ${type.icon} text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="card-title">${type.label}</h6>
                        <p class="card-text small text-muted">${type.description}</p>
                    </div>
                </div>
            </div>
        `)

                typeCard.click(() => selectQuestionType(type.value))
                container.append(typeCard)
            })
        }

        function showTypeSelector() {
            $("#selectTypeBtn").hide()
            $("#selectedTypeDisplay").hide()
            $("#typeSelector").slideDown(300)
        }

        function hideTypeSelector() {
            $("#typeSelector").slideUp(300)
            if (currentQuestionType) {
                $("#selectedTypeDisplay").show()
            } else {
                $("#selectTypeBtn").show()
            }
        }

        function selectQuestionType(type) {
            currentQuestionType = type
            const typeInfo = QUESTION_TYPES[type]

            $("#selectedTypeBadge")
                .html(`
        <i class="bi ${typeInfo.icon} me-1"></i>
        ${typeInfo.label}
    `)
                .attr("class", `badge badge-${type.toLowerCase()} me-2`)

            hideTypeSelector()
            $("#selectedTypeDisplay").show()

            renderTypeSpecificFields(type)
            validateForm()
        }

        function renderTypeSpecificFields(type) {
            const container = $("#typeSpecificFields")
            container.empty()

            switch (type) {
                case "RADIO":
                    container.html(createRadioOptionsEditor())
                    setupOptionsEditor("#radioOptions", "#addRadioOption")
                    break
                case "SELECT":
                    container.html(createSelectOptionsEditor())
                    setupOptionsEditor("#selectOptions", "#addSelectOption")
                    break
                case "SLIDER":
                    container.html(createSliderOptionsEditor())
                    setupOptionsEditor("#radioOptions", "#addRadioOption")
                    // setupSliderEditor()
                    break
                case "AMOUNT":
                case "TEXT":
                case "COMMENT":
                    container.html(createPlaceholderEditor())
                    break
            }
        }

        // Form creation functions with scoring
        function createRadioOptionsEditor() {
            return `
                <div class="mb-3">
                    <label class="form-label">Answer Options</label>
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div id="radioOptions">
                                <div class="option-item mb-2">
                                    <div class="option-with-score">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-record-circle text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control option-text" placeholder="Option text">
                                        <input type="number" class="form-control score-input" placeholder="Score" min="0" step="0.1">
                                        <button type="button" class="btn btn-outline-danger option-remove" disabled>
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addRadioOption" class="btn btn-outline-primary btn-sm w-100 mt-2">
                                <i class="bi bi-plus me-1"></i>
                                Add Option
                            </button>
                        </div>
                    </div>
                </div>
            `
        }

        function createSelectOptionsEditor() {
            return `
                <div class="mb-3">
                    <label class="form-label">Dropdown Options</label>
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div id="selectOptions">
                                <div class="option-item mb-2">
                                    <div class="option-with-score">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-menu-down text-success"></i>
                                        </span>
                                        <input type="text" class="form-control option-text" placeholder="Option text">
                                        <input type="number" class="form-control score-input" placeholder="Score" min="0" step="0.1">
                                        <button type="button" class="btn btn-outline-danger option-remove" disabled>
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addSelectOption" class="btn btn-outline-primary btn-sm w-100 mt-2">
                                <i class="bi bi-plus me-1"></i>
                                Add Option
                            </button>
                        </div>
                    </div>
                </div>
            `
        }

        function createSliderOptionsEditor() {
            return `
                <div class="mb-3">
                    <label class="form-label">Slider Configuration</label>
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div id="radioOptions">
                                <div class="option-item mb-2">
                                    <div class="option-with-score">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-record-circle text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control option-text" placeholder="Option text">
                                        <input type="number" class="form-control score-input" placeholder="Score" min="0" step="0.1">
                                        <button type="button" class="btn btn-outline-danger option-remove" disabled>
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addRadioOption" class="btn btn-outline-primary btn-sm w-100 mt-2">
                                <i class="bi bi-plus me-1"></i>
                                Add More
                            </button>
                        </div>
                    </div>
                </div>
            `
        }

        // function createSliderOptionsEditor() {
        //     return `
        //         <div class="mb-3">
        //             <label class="form-label">Slider Configuration</label>
        //             <div class="card border-0 bg-light">
        //                 <div class="card-body">
        //                     <div class="row g-3 mb-3">
        //                         <div class="col-md-4">
        //                             <label for="minValue" class="form-label">Min Value</label>
        //                             <input type="number" class="form-control" id="minValue" value="0">
        //                         </div>
        //                         <div class="col-md-4">
        //                             <label for="maxValue" class="form-label">Max Value</label>
        //                             <input type="number" class="form-control" id="maxValue" value="100">
        //                         </div>
        //                         <div class="col-md-4">
        //                             <label for="stepValue" class="form-label">Step</label>
        //                             <input type="number" class="form-control" id="stepValue" min="0.01" step="0.01" value="1">
        //                         </div>
        //                     </div>
        //                     <div>
        //                         <label class="form-label">Preview</label>
        //                         <input type="range" id="sliderPreview" class="form-range" min="0" max="100" step="1">
        //                         <div class="d-flex justify-content-between small text-muted">
        //                             <span id="sliderMin">0</span>
        //                             <span id="sliderMax">100</span>
        //                         </div>
        //                     </div>
        //                 </div>
        //             </div>
        //         </div>
        //     `
        // }

        function createPlaceholderEditor() {
            return `
                <div class="mb-3">
                    <label for="placeholderText" class="form-label">Placeholder Text</label>
                    <input type="text" class="form-control" id="placeholderText"
                           placeholder="Enter placeholder text for this field">
                </div>
            `
        }

        // Setup options editor with scoring
        function setupOptionsEditor(containerId, addButtonId) {
            $(document)
                .off("click", addButtonId)
                .on("click", addButtonId, () => {
                    const iconClass = containerId.includes("radio") ? "bi-record-circle text-primary" : "bi-menu-down text-success"
                    addOptionWithScore(containerId, iconClass)
                })

            $(document)
                .off("click", `${containerId} .option-remove`)
                .on("click", `${containerId} .option-remove`, function () {
                    removeOption($(this), containerId)
                })

            $(document)
                .off("input", `${containerId} .option-text, ${containerId} .score-input`)
                .on("input", `${containerId} .option-text, ${containerId} .score-input`, () => {
                    validateForm()
                })
        }

        function setupSliderEditor() {
            $(document)
                .off("input", "#minValue, #maxValue, #stepValue")
                .on("input", "#minValue, #maxValue, #stepValue", () => {
                    updateSliderPreview()
                })
        }

        function addOptionWithScore(containerId, iconClass) {
            const container = $(containerId)
            const optionHtml = `
                <div class="option-item mb-2">
                    <div class="option-with-score">
                        <span class="input-group-text bg-white">
                            <i class="bi ${iconClass}"></i>
                        </span>
                        <input type="text" class="form-control option-text" placeholder="Option text">
                        <input type="number" class="form-control score-input" placeholder="Score" min="0" step="0.1">
                        <button type="button" class="btn btn-outline-danger option-remove">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            `
            container.append(optionHtml)
            updateRemoveButtons(containerId)
        }

        function removeOption($button, containerId) {
            $button.closest(".option-item").remove()
            updateRemoveButtons(containerId)
            validateForm()
        }

        function updateRemoveButtons(containerId) {
            const options = $(containerId + " .option-item")
            options.find(".option-remove").prop("disabled", options.length <= 1)
        }

        function updateSliderPreview() {
            const min = Number.parseInt($("#minValue").val()) || 0
            const max = Number.parseInt($("#maxValue").val()) || 100
            const step = Number.parseFloat($("#stepValue").val()) || 1

            $("#sliderPreview").attr({
                min: min,
                max: max,
                step: step,
            })
            $("#sliderMin").text(min)
            $("#sliderMax").text(max)
        }

        function validateForm() {
            const title = $("#questionTitle").val().trim()
            const hasType = currentQuestionType !== ""
            let isValid = title && hasType

            // Additional validation for options with scores
            if (currentQuestionType === "RADIO" || currentQuestionType === "SELECT") {
                const options = $(".option-text")
                const scores = $(".score-input")
                let hasValidOptions = false

                options.each(function (index) {
                    const optionText = $(this).val().trim()
                    const score = $(scores[index]).val()
                    if (optionText && score !== "") {
                        hasValidOptions = true
                    }
                })

                isValid = isValid && hasValidOptions
            }

            $("#addQuestionBtn").prop("disabled", !isValid)
        }

        function handleAddQuestion(e) {
            e.preventDefault()

            const questionData = {
                title: $("#questionTitle").val().trim(),
                type: currentQuestionType,
                required: $("#requiredCheck").is(":checked"),
                comment: $("#questionComment").val().trim(),
                imageUrl: currentQuestionImageUrl || "",
            }

            switch (currentQuestionType) {
                case "RADIO":
                case "SELECT":
                    questionData.options = getOptionsWithScores()
                    break
                case "SLIDER":
                    questionData.options = getOptionsWithScores()
                    // questionData.minValue = Number.parseInt($("#minValue").val()) || 0
                    // questionData.maxValue = Number.parseInt($("#maxValue").val()) || 100
                    // questionData.step = Number.parseFloat($("#stepValue").val()) || 1
                    break
                case "AMOUNT":
                case "TEXT":
                case "COMMENT":
                    questionData.placeholder = $("#placeholderText").val().trim()
                    break
            }

            if (editingQuestionId) {
                updateQuestion(editingQuestionId, questionData)
                editingQuestionId = null
                $("#formTitle").text("Add New Question")
                $("#addQuestionBtn").html('<i class="bi bi-check-lg me-2"></i>Save Changes')
                $("#cancelEditBtn").hide()
            } else {
                addQuestion(questionData)
            }
        }

        function getOptionsWithScores() {
            const options = []
            $(".option-item").each(function () {
                const text = $(this).find(".option-text").val().trim()
                const score = Number.parseFloat($(this).find(".score-input").val()) || 0
                if (text) {
                    options.push({
                        text: text,
                        value: text.toLowerCase().replace(/\s+/g, "-"),
                        score: score,
                    })
                }
            })
            return options
        }

        function clearForm() {
            $("#questionForm")[0].reset()
            currentQuestionType = ""
            editingQuestionId = null
            currentQuestionImageUrl = ""
            $("#selectedTypeDisplay").hide()
            $("#selectTypeBtn").show()
            $("#typeSpecificFields").empty()
            $("#typeSelector").hide()
            $("#formTitle").text("Add New Question")
            $("#addQuestionBtn").html('<i class="bi bi-plus-lg me-2"></i>Add Question')
            $("#cancelEditBtn").hide()
            $("#questionImagePreview").hide()
            $("#questionImageInput").val("")
            $("#questionComment").val("")
            validateForm()
        }

        function cancelEdit() {
            clearForm()
            hideQuestionBuilder()
            showToast("Edit cancelled", "secondary")
        }

        function createQuestionItem(question, index) {
            const typeInfo = QUESTION_TYPES[question.type]
            const isEditing = editingQuestionId === question.id

            const questionCard = $(`
        <div class="question-item ${isEditing ? "border-primary" : ""}" data-question-id="${question.id}">
            ${
                !isPreviewMode
                    ? `
                    <div class="question-header">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-grip-vertical drag-handle me-2"></i>
                            <div class="question-number">${index + 1}</div>
                            <span class="ms-2 text-muted small">Question ${index + 1}</span>
                        </div>
                        <div class="question-actions">
                            <button type="button" class="btn btn-sm btn-outline-primary edit-question" data-question-id="${question.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-question ms-1" data-question-id="${question.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `
                    : ""
            }
            <div class="question-body">
                ${
                question.imageUrl
                    ? `
                    <div class="question-image">
                        <img src="${question.imageUrl}" alt="Question image" height="100px" width="100px" class="img-fluid">
                    </div>
                `
                    : ""
            }
                <div class="question-title">
                    ${index + 1}. ${question.title}
                    ${question.required ? '<span class="text-danger ms-1">*</span>' : ""}
                </div>
                ${
                question.comment
                    ? `
                    <div class="question-comment">
                        <i class="bi bi-info-circle me-1"></i>
                        ${question.comment}
                    </div>
                `
                    : ""
            }
                <div class="question-type-badge badge-${question.type.toLowerCase()}">
                    <i class="bi ${typeInfo.icon} me-1"></i>
                    ${typeInfo.label}
                </div>
                ${isPreviewMode ? renderAnswerField(question) : ""}
            </div>
        </div>
    `)

            return questionCard
        }

        function renderAnswerField(question) {
            switch (question.type) {
                case "RADIO":
                    return `
                        <div class="mt-3">
                            ${question.options
                        .map(
                            (option, idx) => `
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="radio-${question.id}" id="radio-${question.id}-${idx}" value="${option.value}">
                                        <label class="form-check-label d-flex justify-content-between align-items-center" for="radio-${question.id}-${idx}">
                                            <span>${option.text}</span>
                                            ${option.score !== undefined ? `<span class="score-display">Score: ${option.score}</span>` : ""}
                                        </label>
                                    </div>
                                `,
                        )
                        .join("")}
                        </div>
                    `

                case "SELECT":
                    return `
                        <div class="mt-3">
                            <select class="form-select">
                                <option value="">Select an option</option>
                                ${question.options
                        .map(
                            (option) => `
                                    <option value="${option.value}">${option.text}${option.score !== undefined ? ` (Score: ${option.score})` : ""}</option>
                                `,
                        )
                        .join("")}
                            </select>
                        </div>
                    `

                case "SLIDER":
                    if (!question.minValue && !question.maxValue) {
                        var options = question.options;
                        var scores = options.map(option => option.score);
                        var minScore = Math.min(...scores);
                        var maxScore = Math.max(...scores);
                    } else {
                        var options = [];
                        var scores = [];
                        var minScore = question.minValue;
                        var maxScore = question.maxValue;
                    }
                    minScore = (minScore > 0 && minScore != 'Infinity') ? minScore : 0;
                    maxScore = (maxScore >= 0) ? maxScore : 0;
                    var steps = question.step ?? 1;
                    var defaultValue = minScore;
                    let slider_html = `
                        <div class="mt-3">
<!--                            <input type="range" class="form-range slider-input" min="${minScore}" max="${maxScore}" step="${question.step}" value="${minScore}">-->
                            <div class="custom-tooltip">
                                <div class="tooltip-text slider-value">${minScore}</div>
                            </div>
                            <input type="range"
                               class="form-range custom-slider slider-input"
                               min="${minScore}"
                               max="${maxScore}"
                               step="${steps}"
                               value="${defaultValue}" />

                        <div class="range-labels">`;

                    if (maxScore > minScore) {
                        for (let i = minScore; i <= maxScore; i++) {
                            let foundText = '';

                            if (scores && scores.includes(i)) {
                                const matchedOption = options.find(opt => opt.score == i);
                                if (matchedOption) {
                                    foundText = matchedOption.text;
                                }
                            } else if (!scores) {
                                foundText = i;
                            }

                            slider_html += `<span>${foundText}</span>`;
                        }
                    } else {
                        slider_html += '<span>0</span>';
                    }
                    /*if (!options || options.length === 0){
                        if(maxScore>0){
                            let step = Math.round((maxScore - minScore) / 4);
                            for(let i = minScore; i <= maxScore; i += step){
                                slider_html += `<span>${i}</span>`;
                            }
                        }
                    }else{
                        options.forEach(function(opt) {
                            slider_html += `<span>${opt.text}</span>`;
                        });
                    }*/

                    slider_html += `</div>
                    </div>`;
                    return slider_html

                case "AMOUNT":
                    return `
                        <div class="mt-3">
                            <div class="input-group">
                                <span class="input-group-text">{{ currency_icon() }}</span>
                                <input type="number" class="form-control" placeholder="${question.placeholder || "Enter amount"}">
                            </div>
                        </div>
                    `

                case "TEXT":
                    return `
                        <div class="mt-3">
                            <input type="text" class="form-control" placeholder="${question.placeholder || "Enter your answer"}">
                        </div>
                    `

                case "COMMENT":
                    return `
                        <div class="mt-3">
                            <textarea class="form-control" rows="3" placeholder="${question.placeholder || "Enter your comment"}"></textarea>
                        </div>
                    `

                default:
                    return ""
            }
        }

        function setupDragAndDrop() {
            if (sortableInstance) {
                sortableInstance.destroy()
                sortableInstance = null
            }

            if (isPreviewMode) return

            const container = document.querySelector("#categoryContent .p-3")
            if (!container) return

            sortableInstance = Sortable.create(container, {
                handle: ".drag-handle",
                animation: 150,
                ghostClass: "sortable-ghost",
                chosenClass: "sortable-chosen",
                dragClass: "sortable-drag",
                onEnd: (evt) => {
                    const oldIndex = evt.oldIndex
                    const newIndex = evt.newIndex

                    if (oldIndex !== newIndex) {
                        const categoryQuestions = questions.filter((q) => q.categoryId === activeCategory)
                        const [removed] = categoryQuestions.splice(oldIndex, 1)
                        categoryQuestions.splice(newIndex, 0, removed)

                        questions = questions.filter((q) => q.categoryId !== activeCategory).concat(categoryQuestions)

                        saveDataToStorage()
                        updateCategoryContent()
                        showToast("Questions reordered", "info")
                    }
                },
            })
        }

        function populateOptionsWithScores(options, containerId, iconClass) {
            const container = $(containerId)
            container.empty()

            options.forEach((option) => {
                const optionHtml = `
                    <div class="option-item mb-2">
                        <div class="option-with-score">
                            <span class="input-group-text bg-white">
                                <i class="bi ${iconClass}"></i>
                            </span>
                            <input type="text" class="form-control option-text" placeholder="Option text" value="${option.text}">
                            <input type="number" class="form-control score-input" placeholder="Score" min="0" step="0.1" value="${option.score || 0}">
                            <button type="button" class="btn btn-outline-danger option-remove">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                `
                container.append(optionHtml)
            })

            updateRemoveButtons(containerId)
        }

        // Control Functions
        function togglePreviewMode() {
            isPreviewMode = !isPreviewMode
            const btn = $("#toggleModeBtn")

            if (isPreviewMode) {
                btn.html('<i class="bi bi-pencil-square"></i>').attr("title", "Edit Mode")
                hideQuestionBuilder()
            } else {
                btn.html('<i class="bi bi-eye"></i>').attr("title", "Preview Mode")
            }

            updateCategoryContent()
        }

        function clearAll() {
            Swal.fire({
                title: "Clear Everything?",
                text: "This will delete all categories and questions. This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, clear all!",
                cancelButtonText: "Cancel",
                confirmButtonClass: "btn btn-danger",
                cancelButtonClass: "btn btn-secondary",
                buttonsStyling: true,
            }).then((result) => {
                if (result.value) {
                    questions = []
                    categories = []
                    createDefaultCategory()
                    renderCategoryTabs()
                    updateCategoryContent()
                    hideQuestionBuilder()
                    showToast("Everything cleared", "info")
                }
            })
        }

        function saveQuestionnaire() {
            if (!questionnaireTitle.trim()) {
                showToast("Please set a questionnaire title first", "warning")
                return
            }

            if (questions.length === 0) {
                showToast("Please add at least one question", "warning")
                return
            }

            const data = {
                title: questionnaireTitle,
                categories: categories,
                questions: questions,
                createdAt: new Date().toISOString(),
                version: "1.0",
            }

            const blob = new Blob([JSON.stringify(data, null, 2)], {
                type: "application/json",
            })
            const url = URL.createObjectURL(blob)
            const a = document.createElement("a")
            a.href = url
            a.download = `questionnaire-${questionnaireTitle.replace(/[^a-z0-9]/gi, "-").toLowerCase()}.json`
            document.body.appendChild(a)
            a.click()
            document.body.removeChild(a)
            URL.revokeObjectURL(url)

            showToast("Questionnaire saved successfully", "success")
        }

        // Storage Functions
        function saveDataToStorage() {
            localStorage.setItem("questionnaire_questions", JSON.stringify(questions))
            localStorage.setItem("questionnaire_categories", JSON.stringify(categories))
            localStorage.setItem("questionnaire_active_category", String(activeCategory))
            localStorage.setItem("questionnaire_title", questionnaireTitle)
        }

        function loadDataFromStorage() {
            const storedQuestions = localStorage.getItem("questionnaire_questions")
            const storedCategories = localStorage.getItem("questionnaire_categories")
            const storedActiveCategory = localStorage.getItem("questionnaire_active_category")
            const storedTitle = localStorage.getItem("questionnaire_title")

            if (storedQuestions) {
                questions = JSON.parse(storedQuestions)
            }

            if (storedCategories) {
                categories = JSON.parse(storedCategories)
            }

            if (storedActiveCategory) {
                activeCategory = String(storedActiveCategory)
            }

            if (storedTitle) {
                questionnaireTitle = storedTitle
            }
        }

        function showToast(message, type = "success") {
            const toast = $("#toast")
            $("#toastMessage").text(message)

            toast.removeClass("bg-success bg-danger bg-info bg-warning bg-secondary")
            switch (type) {
                case "success":
                    toast.addClass("bg-success")
                    break
                case "danger":
                    toast.addClass("bg-danger")
                    break
                case "info":
                    toast.addClass("bg-info")
                    break
                case "warning":
                    toast.addClass("bg-warning")
                    break
                case "secondary":
                    toast.addClass("bg-secondary")
                    break
            }

            toastInstance.show()
        }

        // Save Button Handler (for your backend integration)
        $(document).on("click", ".saveButton", (e) => {
            e.preventDefault()

            if (!questionnaireTitle.trim()) {
                showToast("Please set a questionnaire title first", "warning")
                return
            }

            if (questions.length === 0) {
                showToast("Please add at least one question", "warning")
                return
            }

            const payload = {
                title: questionnaireTitle,
                categories: categories,
                questions: questions,
            }

            // Here you would make your AJAX call to save to backend
            // For now, we'll just show a success message
            showToast("Questionnaire saved successfully!", "success")

            // Uncomment and modify this section for your backend integration:

            let data = new FormData();
            data.append('_token', "{{ csrf_token() }}"); // If using Laravel
            data.append('title', questionnaireTitle);
            data.append('payload', JSON.stringify(payload));

            $.ajax({
                url: "{{route('admin.questionnaire.update',['id' => $questionnaire->id])}}", // Your save endpoint
                method: "POST",
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    // Show loading state
                },
                success: function (result) {
                    showToast(result.message || 'Questionnaire saved successfully!', 'success');
                    // Clear local storage if needed
                    localStorage.removeItem('questionnaire_questions');
                    localStorage.removeItem('questionnaire_categories');
                    localStorage.removeItem('questionnaire_active_category');
                    localStorage.removeItem('questionnaire_title');
                    // Redirect if needed
                    window.location.href = "{{route('admin.questionnaire.index')}}";
                },
                error: function (xhr) {
                    let data = xhr.responseJSON;
                    if (data && data.hasOwnProperty('message')) {
                        showToast(data.message, 'danger');
                    } else {
                        showToast('An error occurred while saving', 'danger');
                    }
                }
            });

        })

        // Clear Button Handler
        $(document).on("click", "#clearButton", (e) => {
            localStorage.removeItem("questionnaire_questions")
            localStorage.removeItem("questionnaire_categories")
            localStorage.removeItem("questionnaire_active_category")
            localStorage.removeItem("questionnaire_title")
            window.location.reload()
        })

    </script>
@endsection
