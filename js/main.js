//show the chosen picture in the book form before sending it
var coverInput = document.getElementById('cover');

if (coverInput) {
    coverInput.addEventListener('change', function () {
        var file = coverInput.files[0];
        if (!file || !/^image\/(jpeg|png)$/.test(file.type)) {
            return;
        }

        var reader = new FileReader();
        reader.onload = function (event) {
            var preview = document.getElementById('cover-preview');

            //first picture: replace the empty box by an image
            if (!preview) {
                var placeholder = document.getElementById('cover-placeholder');
                preview = document.createElement('img');
                preview.id = 'cover-preview';
                preview.className = 'book-form__cover';
                preview.alt = '';
                placeholder.parentNode.replaceChild(preview, placeholder);
            }
            preview.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
}
