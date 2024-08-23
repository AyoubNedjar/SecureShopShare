<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<!-- FancyBox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>    

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const photoGallery = document.getElementById('photo-gallery');
    const addImageButton = document.getElementById('add-image-button');
    const addImageSection = document.getElementById('add-image-section');
    const galleryTitle = document.getElementById('gallery-title');
    const menuIcon = document.getElementById('menu-icon');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const statusMessage = document.getElementById('status-message');
    const placeholders = document.querySelector('.placeholders');
    let activeCategory = null;
    let activeImage = null;

    // Show the welcome message as a pop-up for 3 seconds if it's the first login
    if (statusMessage) {
        statusMessage.classList.remove('hidden');
        setTimeout(() => {
            statusMessage.classList.add('fade-out');
        }, 3000);
    }

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.dataset.category;
            if (activeCategory === category) {
                photoGallery.classList.add('hidden');
                addImageSection.classList.add('hidden');
                activeCategory = null;
            } else {
                activeCategory = category;
                galleryTitle.textContent = category.charAt(0).toUpperCase() + category.slice(1);
                photoGallery.classList.remove('hidden');
                addImageSection.classList.add('hidden');

                // Display images by category
                const imageItems = placeholders.querySelectorAll('.image-item');
                imageItems.forEach(item => {
                    if (item.dataset.category === category) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
        });
    });

    addImageButton.addEventListener('click', function() {
        addImageSection.classList.toggle('hidden');
    });

    menuIcon.addEventListener('click', function() {
        dropdownMenu.classList.toggle('hidden');
    });

    document.querySelector(".dropzone").addEventListener('change', function() {
        readFile(this);
    });

    document.querySelectorAll('.dropzone-wrapper').forEach(function(dropzone) {
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragover');
        });
    });

    document.querySelectorAll('.reset-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var form = this.closest('form');
            var boxZone = form.querySelector('.preview-zone .box-body');
            var previewZone = form.querySelector('.preview-zone');
            boxZone.innerHTML = '';
            previewZone.classList.add('hidden');
        });
    });

    // Supprimer une image
    document.querySelectorAll('.delete-image-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            showDeleteConfirmation(form);
        });
    });

    // Add jQuery validation to the form
    $("#add-image-form").validate({
        rules: {
            category: {
                required: true
            },
            image: {
                required: true,
                extension: "png|jpeg|jpg|bmp"
            },
            description: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            category: {
                required: "Please select a category"
            },
            image: {
                required: "Please select an image",
                extension: "Only png, jpeg, jpg, bmp images are allowed."
            },
            description: {
                required: "Please enter a description",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            if (element.attr('name') === 'image') {
                error.insertAfter("#image-error");
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });

    // Image click handling
    const images = document.querySelectorAll('.image-item img');
    images.forEach(img => {
        img.addEventListener('click', function(e) {
            if (activeImage) {
                activeImage.classList.remove('fullscreen');
            }
            if (activeImage !== this) {
                this.classList.add('fullscreen');
                activeImage = this;
            } else {
                activeImage = null;
            }
            e.stopPropagation();
        });
    });

    // Hide active image on document click
    document.addEventListener('click', function() {
        if (activeImage) {
            activeImage.classList.remove('fullscreen');
            activeImage = null;
        }
    });

    // Prevent event propagation to document when clicking on the image itself
    document.querySelectorAll('.image-item img').forEach(img => {
        img.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    function sortImages() {
        const sortOrder = document.getElementById('sort-order-select').value;
        window.location.href = '{{ route("dashboard") }}?sort=' + sortOrder;
    }

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var validateImageType = ['image/png', 'image/bmp', 'image/jpeg', 'image/jpg'];

                var htmlPreview = '';
                if (!validateImageType.includes(input.files[0].type)) {
                    htmlPreview =
                        '<p>Image preview not available</p>' +
                        '<p>' + input.files[0].name + '</p>';
                } else {
                    htmlPreview =
                        '<img src="' + e.target.result + '" class="image-preview" />' +
                        '<p>' + input.files[0].name + '</p>';
                }
                var wrapperZone = input.closest('.dropzone-wrapper');
                var previewZone = wrapperZone.nextElementSibling;
                var boxZone = previewZone.querySelector('.box-body');

                wrapperZone.classList.remove('dragover');
                previewZone.classList.remove('hidden');
                boxZone.innerHTML = htmlPreview;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Functions for delete confirmation dialog
    function showDeleteConfirmation(form) {
        const overlay = document.getElementById('delete-confirmation-overlay');
        const confirmationDialog = document.getElementById('delete-confirmation');
        overlay.classList.remove('hidden');
        confirmationDialog.classList.remove('hidden');
        confirmationDialog.form = form;
    }

    window.confirmDelete = function(button) {
        const form = button.closest('form');
        showDeleteConfirmation(form);
    }

    window.cancelDelete = function() {
        const overlay = document.getElementById('delete-confirmation-overlay');
        const confirmationDialog = document.getElementById('delete-confirmation');
        overlay.classList.add('hidden');
        confirmationDialog.classList.add('hidden');
        confirmationDialog.form = null;
    }

    window.confirmDeleteAction = function() {
        const confirmationDialog = document.getElementById('delete-confirmation');
        const form = confirmationDialog.form;
        if (form) {
            form.submit();
        }
        cancelDelete();
    }
});
</script>
