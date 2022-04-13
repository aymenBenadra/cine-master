function preview() {
    let preview = document.getElementById('preview');
    preview.style.display = 'block';
    frame.src = URL.createObjectURL(event.target.files[0]);
}

// A function to replace the image in the avatar input field with the image in the preview if the user chooses to change it
function changeAvatar() {
    let avatar = document.getElementById('avatar');
    let preview = document.getElementById('preview');
    // replace avatar src with the src file name of the preview image
    avatar.src = URL.createObjectURL(event.target.files[0]);
    alert('Avatar changed!', avatar.src);

    return false;
}