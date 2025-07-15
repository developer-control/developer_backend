// Function to preview the selected image
function uploadFile(input) {
    const file = input.files[0];
    const inputName = input.getAttribute('data-name');
    const inputFile = document.getElementById(inputName);
    const fileListContainer = document.getElementById(`fileList-${inputName}`);
    const progressContainer = document.getElementById(`view-progress-${inputName}`);
    if (file) {
        // Kosongkan UI sebelum upload baru
        fileListContainer.innerHTML = '';
        progressContainer.innerHTML = '';

        simulateUpload(file, inputFile, fileListContainer, progressContainer);
    }

    input.value = '';
}

function removeAsset(elementName) {
    const fileList = document.getElementById(`fileList-${elementName}`);
    const fileItem = fileList.firstElementChild;
    let asset = document.getElementById(elementName)
    fileList.removeChild(fileItem)
    // removeFileFromDatabase(asset.value);
    asset.value = '';
}

function simulateUpload(file, inputFile, fileListContainer, progressContainer) {
    // const previewImage = previewDiv.querySelector("img");
    const buttonSubmit = document.getElementById("submit-form");
    // previewImage.classList.add('d-none');
    buttonSubmit.classList.add('d-none');

    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar';
    progressBar.textContent = '0%';
    progressContainer.appendChild(progressBar);
    // let currentFile = inputFile.value;
    const formData = new FormData();
    formData.append('image', file);
    // Tambahkan nama file lama jika ada
    // if (currentFile) {
    //     formData.append('oldFile', currentFile);
    // }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', urlUploadFile, true);
    // Tambahkan CSRF token ke header
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    xhr.setRequestHeader('Accept', 'application/json'); // ⬅️ minta response JSON
    // Monitor progress upload
    xhr.upload.addEventListener('progress', (event) => {
        progressContainer.classList.remove('d-none')
        if (event.lengthComputable) {
            const percentComplete = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = percentComplete + '%';
            progressBar.textContent = percentComplete + '%';
        }
    });

    // Success handler
    xhr.onload = () => {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                progressBar.textContent = 'Uploaded';
                inputFile.value = response.filePath; // Simpan nama file di server
                const fileItem = document.createElement('div');
                fileItem.className =
                    'd-flex align-items-center justify-content-between border rounded p-2 mb-2';

                const fileName = document.createElement('a');
                fileName.innerHTML = `<i class="fas fa-bars me-2"></i> ${file.name}`;
                fileName.href = response.url;
                fileName.target = "_blank";
                fileItem.appendChild(fileName);


                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.className = 'btn btn-danger btn-sm my-auto';
                removeButton.addEventListener('click', () => {
                    // Remove file from UI
                    fileListContainer.removeChild(fileItem);

                    // Make API call to remove file from the database
                    removeFileFromDatabase(response.filePath);
                    progressContainer.classList.add('d-none')
                    progressContainer.removeChild(progressBar);
                    inputFile.value = '';
                });
                fileItem.appendChild(removeButton);
                fileListContainer.appendChild(fileItem);

            } else {
                progressBar.textContent = 'Failed';

                alert('File upload failed: ' + response.message);
            }
        } else {
            progressBar.textContent = 'Failed';
            const response = JSON.parse(xhr.responseText);
            // console.log(xhr)
            alert(response.message);
        }
        buttonSubmit.classList.remove('d-none');
    };

    // Error handler
    xhr.onerror = () => {
        progressBar.textContent = 'Failed';
        alert('An error occurred during the upload.');
        buttonSubmit.classList.remove('d-none');
    };

    // Send file data
    xhr.send(formData);
}

function removeFileFromDatabase(filePath) {
    fetch(urlRemoveFile, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            filePath
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {

                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: 'Hapus File Berhasil',
                    animation: false,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            } else {
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: 'Gagal Menghapus File',
                    animation: false,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                // alert(`Failed to remove file "${filePath}".`);
            }
        })
        .catch((error) => {
            Swal.fire({
                toast: true,
                icon: 'error',
                title: error,
                animation: false,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

        });
}

