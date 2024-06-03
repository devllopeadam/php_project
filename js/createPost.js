const title = document.querySelector('input[name="title"]');
const content = document.querySelector('textarea');
const dropzone = document.getElementById('dropzone');
const input = dropzone.querySelector('input[type="file"]');
const preview = document.getElementById('preview');

dropzone.addEventListener('dragover', e => {
  e.preventDefault();
  dropzone.classList.add('border-indigo-600');
});

dropzone.addEventListener('dragleave', e => {
  e.preventDefault();
  dropzone.classList.remove('border-indigo-600');
});

dropzone.addEventListener('drop', e => {
  e.preventDefault();
  dropzone.classList.remove('border-indigo-600');
  let file = e.dataTransfer.files[0];
  input.files = e.dataTransfer.files;  // Programmatically set the dropped file to the file input
  displayPreview(file);
});

input.addEventListener("change", function (e) {
  let file = e.target.files[0];
  displayPreview(file);
});

function displayPreview(file) {
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      localStorage.setItem("src", preview.src);
      preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
}
