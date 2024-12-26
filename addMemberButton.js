function toggleForm() {
    const form = document.getElementById('addMemberModal');
    const currentDisplay = window.getComputedStyle(form).display; // Get the current display style
    if (currentDisplay === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
