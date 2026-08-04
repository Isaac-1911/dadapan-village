document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-image-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;

            const targetId = input.dataset.imagePreview;
            const preview = document.getElementById(targetId);
            const placeholder = document.getElementById(`${targetId}-placeholder`);

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    });
});
