function previewImageUpload() {
    const $fileUpload = document.querySelector('input[type=file]');
    if (null === $fileUpload) {
        return false;
    }

    $fileUpload.addEventListener('change', ()=> {
        const reader = new FileReader();
        reader.readAsDataURL($fileUpload.files[0]);
        reader.onload = (e)=> {
            document.querySelector('.img-preview').src = e.target.result;
        };
    });
}


(function () {
    previewImageUpload();
})();








