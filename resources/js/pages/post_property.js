// Moved verbatim from pages/post_property.blade.php (was an inline <script>).
document.addEventListener('DOMContentLoaded', function() {
// Radio card selection
document.querySelectorAll('.radio-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.radio-card').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// Property Type tabs
const propertyTypeBtns = document.querySelectorAll('#propertyTypeGroup .tab-btn');
propertyTypeBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        propertyTypeBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('propertyTypeInput').value = this.dataset.value;

        // Toggle category sets
        if (this.dataset.value === 'Residential') {
            document.getElementById('residentialCategories').style.display = 'flex';
            document.getElementById('commercialCategories').style.display = 'none';
        } else {
            document.getElementById('residentialCategories').style.display = 'none';
            document.getElementById('commercialCategories').style.display = 'flex';
        }
        // Clear previous category selection
        document.querySelectorAll('#categoryPills .pill-btn').forEach(p => p.classList.remove('active'));
        document.getElementById('propertyCategoryInput').value = '';
    });
});

// Category pills
document.querySelectorAll('#categoryPills .pill-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Only deselect pills in the same category set
        this.closest('.category-set').querySelectorAll('.pill-btn').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('propertyCategoryInput').value = this.dataset.value;
    });
});

// Furnished type tabs
document.querySelectorAll('.furnished-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.furnished-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('furnishedTypeInput').value = this.dataset.value;
    });
});

// Facing pills
document.querySelectorAll('.facing-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.facing-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('facingInput').value = this.dataset.value;
    });
});
});
