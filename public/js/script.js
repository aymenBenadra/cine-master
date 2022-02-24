function preview() {
    let preview = document.getElementById('preview');
    preview.style.display = 'block';
    frame.src = URL.createObjectURL(event.target.files[0]);
}