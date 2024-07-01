document.getElementById('images').addEventListener('change', handleFileSelect, false);

function handleFileSelect(event) {
    const files = event.target.files;
    const uploadedImagesDiv = document.getElementById('uploadedImages');

    // Iterate through selected files
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // Ensure it's an image file
        if (!file.type.startsWith('image/')) {
            continue;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            const img = document.createElement('img');
            img.classList.add('uploaded-image');
            img.src = event.target.result;

            // Create a container for the image with delete icon
            const imageContainer = document.createElement('div');
            imageContainer.classList.add('image-item');
            imageContainer.appendChild(img);

            // Create delete icon
            const deleteIcon = document.createElement('span');
            deleteIcon.classList.add('delete-icon');
            deleteIcon.innerHTML = '&times;'; // Using '×' for delete icon
            deleteIcon.onclick = function () {
                imageContainer.remove(); // Remove the image container on click
            };
            imageContainer.appendChild(deleteIcon);

            uploadedImagesDiv.appendChild(imageContainer);
        };

        reader.readAsDataURL(file);
    }
}