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
        
        input.files = dataTransfer.files;  // Update the input element with the new list of files
    }
</script>
