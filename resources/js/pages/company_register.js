// Moved verbatim from pages/company_register.blade.php (was an inline <script>).
// Reflect chosen file name under each upload box.
document.querySelectorAll('.upload-box input[type=file]').forEach(function (input) {
    input.addEventListener('change', function () {
        const label = input.closest('.upload-box').querySelector('.file-name');
        if (!label) return;
        label.textContent = input.files.length ? input.files[0].name : '';
    });
});
