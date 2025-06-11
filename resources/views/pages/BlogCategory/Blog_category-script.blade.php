<script>
    $('.Blog_category-delete-btn').click(function(event) {
        event.preventDefault();
        var submitURL = $(this).attr("data-url");
        Swal.fire({
            title: 'Are you sure you want to delete this Blog Category?',
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
    // document.getElementById('image').addEventListener('change', function(event) {
    //     document.getElementById('image-previews').innerHTML = '';

    //     const files = event.target.files; // Get the selected files
    //     const previewContainer = document.getElementById('image-previews'); 

    //     // Loop through all selected files
    //     for (let i = 0; i < files.length; i++) {
    //         const file = files[i];

    //         if (file.type.startsWith('image/')) {
    //             const reader = new FileReader();

    //             reader.onload = function(e) {
    //                 const previewWrapper = document.createElement('div');
    //                 previewWrapper.style.position = 'relative';
    //                 previewWrapper.style.display = 'inline-block';
    //                 previewWrapper.style.margin = '5px';

    //                 const image = document.createElement('img');
    //                 image.src = e.target.result;
    //                 image.style.width = '100px';
    //                 image.style.height = '100px';
    //                 image.style.objectFit = 'cover';

    //                 const deleteButton = document.createElement('button');
    //                 deleteButton.innerHTML = 'X';
    //                 deleteButton.style.position = 'absolute';
    //                 deleteButton.style.top = '-8px';
    //                 deleteButton.style.right = '-8px';
    //                 deleteButton.style.background = 'red';
    //                 deleteButton.style.color = 'white';
    //                 deleteButton.style.border = 'none';
    //                 deleteButton.style.borderRadius = '50%';
    //                 deleteButton.style.padding = '0 5px';

    //                 deleteButton.addEventListener('click', function() {
    //                     previewWrapper.remove(); 
    //                     event.target.value = ''; 
    //                 });

    //                 previewWrapper.appendChild(image);
    //                 previewWrapper.appendChild(deleteButton);

    //                 previewContainer.appendChild(previewWrapper);
    //             };
    //             reader.readAsDataURL(file);
    //         }
    //     }
    // });


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
        
        input.files = dataTransfer.files;  // Update the input element with the new list of files
    }
    $(document).ready(function () {
        var quill = new Quill('#quill_editor', {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        quill.on('text-change', function () {
            $('#description').val(quill.root.innerHTML);
            $('#description_error').text(''); // Clear error message
            $('#description').removeClass('is-invalid'); // Remove invalid class
        });
         // For Blog Category
        $(document).on("click", ".erp-Blog_category-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#Blog_category_form').attr("data-url");
            var data_id = $('#Blog_category_form').attr("data-id");
            var formData = new FormData($('#Blog_category_form')[0]);
             $('#description').val(quill.root.innerHTML);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('Blog_category-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });
        function handleFormErrors(errors) {
            $('.error').text(''); // Clear all errors first
            $('.input-error').removeClass('is-invalid');
            $('#designation_error').text(errors['designation'] || '');
            $('#message_error').text(errors['message'] || '');
            $('#keyword_error').text(errors['keyword'] || '');
            $('#page_error').text(errors['page'] || '');
            $('#name_error').text(errors['name'] || '');
            $('#image_error').text(errors['image'] || '');
            $('#link_error').text(errors['link'] || '');
            $('#status_error').text(errors['status'] || '');
            $('#parent_category_error').text(errors['parent_category_id'] || '');
            $('#description_error').text(errors['description'] || '');

            $('#category_name').addClass(errors['name']?'is-invalid':'');
            $('#sub_category_name').addClass(errors['name']?'is-invalid':'');
            $('#parent_category').addClass(errors['parent_category_id']?'is-invalid':'');
            $('.image-input-wrapper').addClass(errors['image']?'is-invalid':'');
            if(errors['title']) {
                $('#title_error').text(errors['title'][0]);
                $('#title').addClass('is-invalid');
            }
            if(errors['category']) {
                $('#category_error').text(errors['category'][0]);
                $('#category').addClass('is-invalid');
            }
           if(errors['blog_image']) {
                $('#blog_image_error').text(errors['blog_image'][0]);
                $('#Blog_image').addClass('is-invalid');
            }
            if(errors['shortdescription']) {
                $('#shortdescription_error').text(errors['shortdescription'][0]);
                $('#shortdescription').addClass('is-invalid');
            }
            if(errors['long_description']) {
                $('#long_description_error').text(errors['long_description'][0]);
                $('#long_description').addClass('is-invalid');
            }
            if(errors['related_blog']) {
                $('#related_blog_error').text(errors['related_blog'][0]);
                $('#related_blog').addClass('is-invalid');
            }
            if(errors['question']) {
                $('#question_error').text(errors['question'][0]);
                $('#question').addClass('is-invalid');
            }
            if(errors['answer']) {
                $('#answer_error').text(errors['answer'][0]);
                $('#answer').addClass('is-invalid');
            }
        }
    });
</script>
