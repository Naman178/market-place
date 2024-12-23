<script>
    $('.Blog-delete-btn').click(function(event) {
        event.preventDefault();
        var submitURL = $(this).attr("data-url");
        Swal.fire({
            title: 'Are you sure you want to delete this Blog?',
            //text: 'If you delete this, it will be gone forever.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4caf50',
            cancelButtonColor: '#f44336',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = submitURL;
            }
        });
    });

    document.getElementById('image').addEventListener('change', function(event) {
        document.getElementById('image-previews').innerHTML = '';

        const files = event.target.files; // Get the selected files
        const previewContainer = document.getElementById('image-previews');

        // Loop through all selected files
        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.style.position = 'relative';
                    previewWrapper.style.display = 'inline-block';
                    previewWrapper.style.margin = '5px';

                    const image = document.createElement('img');
                    image.src = e.target.result;
                    image.style.width = '100px';
                    image.style.height = '100px';
                    image.style.objectFit = 'cover';

                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = 'X';
                    deleteButton.style.position = 'absolute';
                    deleteButton.style.top = '-8px';
                    deleteButton.style.right = '-8px';
                    deleteButton.style.background = 'red';
                    deleteButton.style.color = 'white';
                    deleteButton.style.border = 'none';
                    deleteButton.style.borderRadius = '50%';
                    deleteButton.style.padding = '0 5px';

                    deleteButton.addEventListener('click', function() {
                        previewWrapper.remove();
                        event.target.value = '';
                    });

                    previewWrapper.appendChild(image);
                    previewWrapper.appendChild(deleteButton);

                    previewContainer.appendChild(previewWrapper);
                };
                reader.readAsDataURL(file);
            }
        }
    });


    function removeImageFromInput(file) {
        // This function will remove the image file from the input element
        let input = document.getElementById('image');
        let dataTransfer = new DataTransfer();

        // Loop through the files and only add those that are not the removed image
        Array.from(input.files).forEach(f => {
            if (f !== file) {
                dataTransfer.items.add(f);
            }
        });

        input.files = dataTransfer.files; // Update the input element with the new list of files
    }

    tinymce.init({
        selector: '#short-description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    tinymce.init({
        selector: '#long-description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    $(document).ready(function() {
        $('#related_blog').select2();
    });

    $('#add-section').click(function () {
        var sectionIndex = $('.blog-section').length + 1;

        // Append a new section container with type selector
        var newSection = `
            <div class="row mt-2 blog-section" id="section-${sectionIndex}">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group col-md-12 select_type">
                                <label for="select-type-${sectionIndex}">Select Type</label>
                                <select name="select-type" id="select-type-${sectionIndex}" class="form-control select-type">
                                    <option value="heading-description-image">Heading - Description - Image</option>
                                    <option value="heading-image-description">Heading - Image - Description</option>
                                    <option value="image-description-heading">Image - Description - Heading</option>
                                    <option value="heading-description-image-description">Heading - Description - Image - Description</option>
                                </select>
                            </div>
                            <div id="content-container-${sectionIndex}"></div>
                            <button type="button" class="btn btn-danger remove-section" data-section-id="section-${sectionIndex}">Remove Section</button>
                        </div>
                    </div>
                </div>
            </div>`;

        // Append the new section to the container
        $('#blog-sections').append(newSection);

        // Handle dynamic type selection
        $(`#select-type-${sectionIndex}`).change(function () {
            var selectedType = $(this).val();
            $('.select_type').hide();
            var updatedContent = getSectionHtml(selectedType, sectionIndex);
            $(`#content-container-${sectionIndex}`).html(updatedContent);

            // Initialize TinyMCE for new textareas in the section
            initializeTinyMCE(`#content-container-${sectionIndex} textarea`);
        });

        // Initialize default type selection
        $(`#select-type-${sectionIndex}`).trigger('change');

        // Attach remove button functionality
        $(`#section-${sectionIndex} .remove-section`).click(function () {
            var sectionId = $(this).data('section-id');
            tinymce.remove(`#content-container-${sectionIndex} textarea`); // Cleanup TinyMCE
            $(`#${sectionId}`).remove();
        });
    });
    $(document).on('click', '.edit-remove-section', function () {
        var sectionIndex = $(this).data('section-index'); 
        var sectionId = $(this).data('section-id'); 
        var blog_id = $(this).data('blog-id');
        // Cleanup TinyMCE Editor for this specific section
        tinymce.remove(`#content-container-${sectionIndex} textarea`);

        var submitUrl = "{{ route('deleteSection') }}";
        $('#' + sectionId).remove();
        
        $.ajax({
            url: submitUrl,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',  
                section_id: sectionIndex, 
                blog_id: blog_id, 
            },
            success: function(response) {
                console.log('Section removed successfully');
            },
            error: function(xhr, status, error) {
                console.log('An error occurred: ' + error);
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Loop through each select element and bind change event
        document.querySelectorAll('.select_type').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const sectionIndex = selectElement.dataset.sectionIndex;
                const selectedType = selectElement.value;
                const contentContainer = document.querySelector(`#section-${sectionIndex} .dynamic-content`);
                
                // Call a function to dynamically render the content based on the selected type
                renderContentByType(contentContainer, selectedType, sectionIndex);
                reinitializeTinyMCE();
            });

            // Initial render based on the pre-selected value (in case of edit)
            const initialSelectedType = selectElement.value;
            const sectionIndex = selectElement.dataset.sectionIndex;
            const contentContainer = document.querySelector(`#section-${sectionIndex} .dynamic-content`);
            renderContentByType(contentContainer, initialSelectedType, sectionIndex);
            reinitializeTinyMCE();
        });

        function renderContentByType(container, type, index) {
            let contentHtml = '';
            let imageUrl = '';
            // Replace the PHP values in HTML with JavaScript variables.
            const headingValue = document.querySelector(`#heading-${index}`).value || '';
            const description1Value = document.querySelector(`#description-${index}`).value || '';
            const imageUrlInput = document.getElementById(`image-url-${index}`);

            if (imageUrlInput) {
                // Get the src attribute value
                imageUrl = imageUrlInput.src;
                console.log(imageUrl); // Output the image URL
            } else {
                console.error(`Element with ID image-url-${index} not found`);
            }


            if (type === 'heading-description-image') {
                contentHtml = `
                    <div class="content-option" id="content-option-heading-description-image">
                        <div class="form-group heading-field">
                            <label for="heading-${index}">Heading</label>
                            <input type="text" class="form-control" id="heading-${index}" name="heading_${index}" value="${headingValue}">
                        </div>
                        <div class="form-group description-field">
                            <label for="description-${index}">Description</label>
                            <textarea class="form-control tinymce-textarea" id="description-${index}" name="description_${index}">${description1Value}</textarea>
                        </div>
                        <div class="form-group image-field">
                            <label for="image-${index}">Image</label>
                            <input type="file" class="form-control" id="image-${index}" name="image_${index}">
                            <img id="image-url-${index}"  src="${imageUrl}" alt="Image not found" width="100px">
                        </div>
                    </div>
                `;
            } else if (type === 'heading-image-description') {
                contentHtml = `
                    <div class="content-option" id="content-option-heading-image-description">
                        <div class="form-group heading-field">
                            <label for="heading-${index}">Heading</label>
                            <input type="text" class="form-control" id="heading-${index}" name="heading_${index}" value="${headingValue}">
                        </div>
                        <div class="form-group image-field">
                            <label for="image-${index}">Image</label>
                            <input type="file" class="form-control" id="image-${index}" name="image_${index}">
                            <img id="image-url-${index}" src="${imageUrl}" alt="Image not found" width="100px">
                        </div>
                        <div class="form-group description-field">
                            <label for="description-${index}">Description</label>
                            <textarea class="form-control tinymce-textarea" id="description-${index}" name="description_${index}">${description1Value}</textarea>
                        </div>
                    </div>
                `;
            } else if (type === 'image-description-heading') {
                contentHtml = `
                    <div class="content-option" id="content-option-image-description-heading">
                        <div class="form-group image-field">
                            <label for="image-${index}">Image</label>
                            <input type="file" class="form-control" id="image-${index}" name="image_${index}">
                            <img id="image-url-${index}" src="${imageUrl}" alt="Image not found" width="100px">
                        </div>
                        <div class="form-group description-field">
                            <label for="description-${index}">Description</label>
                            <textarea class="form-control tinymce-textarea" id="description-${index}" name="description_${index}">${description1Value}</textarea>
                        </div>
                        <div class="form-group heading-field">
                            <label for="heading-${index}">Heading</label>
                            <input type="text" class="form-control" id="heading-${index}" name="heading_${index}" value="${headingValue}">
                        </div>
                    </div>
                `;
            } else if (type === 'heading-description-image-description') {
                contentHtml = `
                    <div class="content-option" id="content-option-heading-description-image-description">
                        <div class="form-group heading-field">
                            <label for="heading-${index}">Heading</label>
                            <input type="text" class="form-control" id="heading-${index}" name="heading_${index}" value="${headingValue}">
                        </div>
                        <div class="form-group description-field">
                            <label for="description-${index}">Description</label>
                            <textarea class="form-control tinymce-textarea" id="description-${index}" name="description_${index}">${description1Value}</textarea>
                        </div>
                        <div class="form-group image-field">
                            <label for="image-${index}">Image</label>
                            <input type="file" class="form-control" id="image-${index}" name="image_${index}">
                            <img id="image-url-${index}" src="${imageUrl}" alt="Image not found" width="100px">
                        </div>
                        <div class="form-group description-field">
                            <label for="description2-${index}">Description</label>
                            <textarea class="form-control tinymce-textarea" id="description2-${index}" name="description2_${index}">${description1Value}</textarea>
                        </div>
                    </div>
                `;
            }

            // Update the content area with the generated HTML
            container.innerHTML = contentHtml;
            initializeTinyMCE(container);
        }
    });




    $(document).ready(function () {
        // Update content on type change
        $(".select_type").change(function () {
            let sectionIndex = $(this).data('index');
            let selectedType = $(this).val();

            // Hide all content options for the section
            $(".content-section[data-index=" + sectionIndex + "] .content-type-fields > div").hide();

            // Show content option based on selected type
            $(".content-section[data-index=" + sectionIndex + "] .content-type-fields div[data-type='" + selectedType + "']").show();
        });

        // Initialize visibility based on existing select_type value
        $(".select_type").each(function () {
            let sectionIndex = $(this).data('index');
            let selectedType = $(this).val();
            $(".content-section[data-index=" + sectionIndex + "] .content-type-fields div[data-type='" + selectedType + "']").show();
        });

    });


    function getSectionHtml(type, sectionIndex) {
        let html = `
            <div class="col-md-12 mb-3 section-container" id="section-${sectionIndex}">
                <div class="form-group">
                    <label for="select-type-${sectionIndex}">Select Type</label>
                    <select name="select_type_${sectionIndex}" id="select-type-${sectionIndex}" class="form-control select-type" data-section-index="${sectionIndex}">
                        <option value="heading-description-image">Heading - Description - Image</option>
                        <option value="heading-image-description">Heading - Image - Description</option>
                        <option value="image-description-heading">Image - Description - Heading</option>
                        <option value="heading-description-image-description">Heading - Description - Image - Description</option>
                    </select>
                </div>
                <div class="dynamic-content">
                    ${generateContent(type, sectionIndex)}
                </div>
            </div>`;
        return html;
    }

    function generateContent(type, sectionIndex) {
        let content = '';
        switch (type) {
            case 'heading-description-image':
                content = `
                    <div class="form-group">
                        <label for="heading-${sectionIndex}">Heading</label>
                        <input type="text" class="form-control" id="heading-${sectionIndex}" name="heading_${sectionIndex}">
                    </div>
                    <div class="form-group">
                        <label for="description-${sectionIndex}">Description</label>
                        <textarea class="form-control tinymce-textarea" id="description-${sectionIndex}" name="description_${sectionIndex}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image-${sectionIndex}">Image</label>
                        <input type="file" class="form-control" id="image-${sectionIndex}" name="image_${sectionIndex}">
                    </div>`;
                break;

            case 'heading-image-description':
                content = `
                    <div class="form-group">
                        <label for="heading-${sectionIndex}">Heading</label>
                        <input type="text" class="form-control" id="heading-${sectionIndex}" name="heading_${sectionIndex}">
                    </div>
                    <div class="form-group">
                        <label for="image-${sectionIndex}">Image</label>
                        <input type="file" class="form-control" id="image-${sectionIndex}" name="image_${sectionIndex}">
                    </div>
                    <div class="form-group">
                        <label for="description-${sectionIndex}">Description</label>
                        <textarea class="form-control tinymce-textarea" id="description-${sectionIndex}" name="description_${sectionIndex}"></textarea>
                    </div>`;
                break;

            case 'image-description-heading':
                content = `
                    <div class="form-group">
                        <label for="image-${sectionIndex}">Image</label>
                        <input type="file" class="form-control" id="image-${sectionIndex}" name="image_${sectionIndex}">
                    </div>
                    <div class="form-group">
                        <label for="description-${sectionIndex}">Description</label>
                        <textarea class="form-control tinymce-textarea" id="description-${sectionIndex}" name="description_${sectionIndex}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="heading-${sectionIndex}">Heading</label>
                        <input type="text" class="form-control" id="heading-${sectionIndex}" name="heading_${sectionIndex}">
                    </div>`;
                break;

            case 'heading-description-image-description':
                content = `
                    <div class="form-group">
                        <label for="heading-${sectionIndex}">Heading</label>
                        <input type="text" class="form-control" id="heading-${sectionIndex}" name="heading_${sectionIndex}">
                    </div>
                    <div class="form-group">
                        <label for="description1-${sectionIndex}">Description 1</label>
                        <textarea class="form-control tinymce-textarea" id="description1-${sectionIndex}" name="description_${sectionIndex}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image-${sectionIndex}">Image</label>
                        <input type="file" class="form-control" id="image-${sectionIndex}" name="image_${sectionIndex}">
                    </div>
                    <div class="form-group">
                        <label for="description2-${sectionIndex}">Description 2</label>
                        <textarea class="form-control tinymce-textarea" id="description2-${sectionIndex}" name="description2_${sectionIndex}"></textarea>
                    </div>`;
                break;

            default:
                console.error('Invalid type');
        }
        return content;
    }

    // Initialize or reinitialize TinyMCE editor
    function initializeTinyMCE(selector) {
        tinymce.init({
            selector: selector, // Target all textareas with class 'tinymce-textarea'
            menubar: false,
            plugins: 'advlist autolink lists link image charmap print preview anchor',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
            height: 200, // Adjust as needed
        });
    }

    // Function to reinitialize TinyMCE when required
    function reinitializeTinyMCE() {
        tinymce.remove('.tinymce-textarea'); // Remove all existing TinyMCE instances
        initializeTinyMCE('.tinymce-textarea'); // Reinitialize on all elements
    }

    // Ensure TinyMCE is initialized when the page is loaded or after adding a new section
    document.addEventListener('DOMContentLoaded', function() {
        initializeTinyMCE('.tinymce-textarea'); // Initialize TinyMCE on page load
    });


    // Function to add a new section dynamically
    let sectionIndex = 0;
    function addNewSection(type = 'heading-description-image') {
        const container = document.getElementById('sections-container');
        const html = getSectionHtml(type, sectionIndex++);
        container.insertAdjacentHTML('beforeend', html);
        reinitializeTinyMCE();
    }

    // Event listener for dynamically changing section type
    document.addEventListener('change', (e) => {
        if (e.target && e.target.classList.contains('select-type')) {
            const sectionIndex = e.target.dataset.sectionIndex;
            const newType = e.target.value;
            const dynamicContent = document.querySelector(`#section-${sectionIndex} .dynamic-content`);
            dynamicContent.innerHTML = generateContent(newType, sectionIndex);
            reinitializeTinyMCE();
        }
    });

    // Add event listener to the button to add a new section
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('add-section-btn').addEventListener('click', () => {
            addNewSection();
        });
    });

    // Initialize TinyMCE initially in case there are predefined elements
    initializeTinyMCE('.tinymce-textarea');


    function confirmStatusChange(blogId,status) {
        console.log(blogId,status);
        var submitUrl = "{{ route('updateStatus') }}";
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to change the status of this blog?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: submitUrl,  
                    type: 'POST',
                    data: {
                        id: blogId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Updated!',
                            'Blog status has been updated.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire(
                            'Error!',
                            'There was an error updating the status.',
                            'error'
                        );
                    }
                });
            } else {
                location.reload();
            }
        });
    }


</script>
