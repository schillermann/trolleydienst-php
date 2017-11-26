function submitForm(button) {
    document.getElementById('loading-screen').style.display = 'block';
    button.form.submit();
    //setTimeout(function() { button.form.submit(); }, 200);
    //return true;
}