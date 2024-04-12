document.getElementById('closeButton').addEventListener('click', function() {
    var form = document.getElementById('AddResidentModalForm');
    form.reset();

    var imagePreview = document.getElementById('imagePreview');
    imagePreview.src = 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';
});
