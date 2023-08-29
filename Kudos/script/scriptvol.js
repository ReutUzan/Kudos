function submitForm(message) {
    if (confirm(message)) {
        document.getElementById('myform').submit();
        return true;
    } else {
        return false;
    }
}