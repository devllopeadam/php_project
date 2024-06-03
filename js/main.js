const imagePreview = document.getElementById('imagePreview');
const storedImage = getSrcImageFromLocalStorage();
if (storedImage) {
  imagePreview.src = storedImage;
  imagePreview.classList.remove('hidden');
}
document.getElementById('dropzone-file').addEventListener('change', function (event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      imagePreview.src = e.target.result;
      localStorage.setItem("srcProfile", e.target.result);
      imagePreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
});

function getSrcImageFromLocalStorage() {
  return localStorage.getItem('srcProfile');
}

document.querySelector('form').onsubmit = () => localStorage.setItem("srcProfile", "");

