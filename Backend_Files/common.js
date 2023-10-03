// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');
var profileModal = document.getElementById('profileModal');
var changePasswordModal = document.getElementById('changePasswordModal');
var confirmDeleteModal = document.getElementById('confirmDeleteModal');

// Get references to the buttons that open and close the modals
var loginButton = document.getElementById('loginButton');
var closeLoginButton = document.getElementById('closeButton');
var signupButton = document.getElementById('signupButton');
var closeSignupButton = document.getElementById('closeSignupButton');

var openModalBtn = document.getElementById('openModalBtn');
var closeModalBtn = document.getElementById('closeModalBtn');
var openChangePasswordModalBtn = document.getElementById('changePasswordBtn');
var closeChangePasswordModalBtn = document.getElementById('closeChangePasswordModalBtn');
var backButtonSignup = document.getElementById('backToLoginButton');
var backButtonProfile = document.getElementById('backToProfile');

var deleteProfileBtn = document.getElementById('deleteProfileBtn');
var closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
var cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

var changePasswordButtonFinal = document.getElementById('changePasswordButtonFinal');

var logoutButton = document.getElementById('logoutButton');

var settingsModal = document.getElementById('settingsModal');
var closeSettingsButton = document.getElementById('closeSettingsButton');
var settingsButton = document.getElementById('settingsButton');



//opening closing settings modal
if(settingsModal){
    settingsButton.addEventListener('click', function () {
        settingsModal.style.display = 'block';
    });
    closeSettingsButton.addEventListener('click', function () {
        settingsModal.style.display = 'none';
    });
    window.addEventListener('click', function (event) {
        if (event.target == settingsModal) {
            settingsModal.style.display = 'none';
        }
    });
}


// Event listeners to open and close profile
if (openModalBtn) {
    openModalBtn.addEventListener('click', function () {
        profileModal.style.display = 'block';
    });
}
if (backButtonProfile) {
    backButtonProfile.addEventListener('click', function () {
        changePasswordModal.style.display = 'none';
        confirmDeleteModal.style.display = 'none';
        profileModal.style.display = 'block';
    });
}

backButtonSignup.addEventListener('click', function () {
    signupModal.style.display = 'none';
    loginModal.style.display = 'block';
});

closeModalBtn.addEventListener('click', function () {
    profileModal.style.display = 'none';
});

// Event listeners to open and close change password modal
openChangePasswordModalBtn.addEventListener('click', function () {
    changePasswordModal.style.display = 'block';
    profileModal.style.display = 'none';
});


closeChangePasswordModalBtn.addEventListener('click', function () {
    changePasswordModal.style.display = 'none';
});

// Event listeners to open and close the login modal
if (loginButton) {
    loginButton.addEventListener('click', function () {
        loginModal.style.display = 'block';
    });
}
closeLoginButton.addEventListener('click', function () {
    loginModal.style.display = 'none';
});

// Event listener to open the signup modal
signupButton.addEventListener('click', function () {
    signupModal.style.display = 'block';
    loginModal.style.display = 'none'; // Hide the login modal when Signup is clicked
});

closeSignupButton.addEventListener('click', function () {
    signupModal.style.display = 'none';
});

// Event listeners to open/close confirm delete modal
deleteProfileBtn.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'block';
});

closeDeleteModalBtn.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'none';
});

cancelDeleteBtn.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'none';
});

// Event listener to close modals if clicked outside
window.addEventListener('click', function (event) {
    if (event.target == loginModal) {
        loginModal.style.display = 'none';
    }
    if (event.target == signupModal) {
        signupModal.style.display = 'none';
    }
    if (event.target == profileModal) {
        profileModal.style.display = 'none';
    }
    if (event.target == changePasswordModal) {
        changePasswordModal.style.display = 'none';
    }
    if (event.target == confirmDeleteModal) {
        confirmDeleteModal.style.display = 'none';
    }
});



function showPhoneSidebar() {
    //Buttons for sidebar open and close dont move it, for some reason it breaks idek
    var sidebarOuter = document.getElementById("outer-sidebar");
    var sidebar = document.getElementById("inner-sidebar");
    sidebarOuter.style.display = "block";
    sidebarOuter.style.zIndex = "100";
    sidebarOuter.style.position = "fixed";
    sidebarOuter.style.width = "30%";
    sidebar.style.width = "30%";
}

function hidePhoneSidebar() {
    //Buttons for sidebar open and close dont move it, for some reason it breaks idek
    var sidebarOuter = document.getElementById("outer-sidebar");
    var sidebar = document.getElementById("inner-sidebar");
    sidebarOuter.style.zIndex = "1";
    sidebarOuter.style.position = "static";
    sidebarOuter.style.width = "15%";
    sidebarOuter.style.display = "none";
    sidebar.style.width = "15%";

}