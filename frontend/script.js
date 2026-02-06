//function to swap between signup and login forms
function toggleForm(formType) {
    //retrieving html elements for interaction
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const loginBtn = document.getElementById('loginBtn');
    const signupBtn = document.getElementById('signupBtn');

    //toggles corresponding form 
    if (formType === 'login') {
        //show container to show elements for login
        loginForm.style.display = 'flex';
        signupForm.style.display = 'none';
        loginBtn.classList.add('active');
        signupBtn.classList.remove('active');
    } else {
        //show container to show elements for sign up
        loginForm.style.display = 'none';
        signupForm.style.display = 'flex';
        signupBtn.classList.add('active');
        loginBtn.classList.remove('active');
    }
}