var notAgentModal = document.getElementById('notAgentModal');
var applyAgentModal = document.getElementById('applyAgentModal');
var applyButton = document.getElementById('applyAgentButton');
var backButtonNotAgent = document.getElementById('backButtonNotAgent');
var savePropertyButtonHideIt = document.getElementById('save-property');
var submitAgentApplication = document.getElementById('submitAgentApplication');
var loginButtonCreatePage = document.getElementById('loginButtonCreatePage');
var addMenityButton = document.getElementById('addAmenities');
var amenityModal = document.getElementById('ammenityModal');
var closeLoginButton = document.getElementById('closeButton');
var notLoggedInModal = document.getElementById('notLoggedInModal');
var amenityTable = document.getElementById("ammenityTable");
var submitAmmenityButton = document.getElementById("submitAmmenities");

submitAmmenityButton.addEventListener('click', function () {
    var checkBoxes = amenityTable.getElementsByTagName("INPUT");
    var names = amenityTable.getElementsByClassName("name");
    arr = [];
    arr2 = [];
        for (let i = 0; i < checkBoxes.length; i++) {
            if(checkBoxes[i].checked){
                arr.push(i)
        }
    }
    count = 0;
    for (let i = 0; i < names.length; i++) {
        if(arr.includes(i)){
            arr2.push(names[i].textContent);
        }
    }
    console.log(arr2);
        amenityModal.style.display = 'block';
    });

if(addMenityButton){
    addMenityButton.addEventListener('click', function () {
    amenityModal.style.display = 'block';
    });
    window.addEventListener('click', function (event) {
        if (event.target == amenityModal) {
            amenityModal.style.display = 'none';
        }
    });
}
if(loginButtonCreatePage){//we are clicking the login button on create page 
    
    loginButtonCreatePage.addEventListener('click', function () {//make sure that when you click the button login comes up
        loginModal.style.display = 'block';
        notLoggedInModal.style.display = 'none';
    });
    //once login is up we need to check a few things
    //1. is that clicking close or outside of the modal it just brings you back to notLoggedInModal
    //2. we need to make sure that clicking outside of the modal for login/signup also brings you back to the notLoggedInModal
    // we will do this by getting rid of the event listeners that do that and rewrite them

    closeLoginButton.removeEventListener('click', null);
    closeLoginButton.addEventListener('click', function () {
        loginModal.style.display = 'none';
        notLoggedInModal.style.display = 'block';
    });

    closeSignupButton.removeEventListener('click', null);

    closeSignupButton.addEventListener('click', function () {
        signupModal.style.display = 'none';
        loginModal.style.display = 'block';
    });

    window.removeEventListener('click', null);
    window.addEventListener('click', function (event) {
        if (event.target == loginModal) {
            loginModal.style.display = 'none';
            notLoggedInModal.style.display = 'block';
        }
        if (event.target == signupModal) {
            signupModal.style.display = 'none';
            notLoggedInModal.style.display = 'block';
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


}

if (notAgentModal && applyAgentModal && applyButton && backButtonNotAgent && submitAgentApplication) {
    savePropertyButtonHideIt.style.display = 'none';


    submitAgentApplication.addEventListener('mouseenter', function() {
        submitAgentApplication.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        submitAgentApplication.style.color = '#202024';
    });

    submitAgentApplication.addEventListener('mouseleave', function() {
        submitAgentApplication.style.backgroundColor = '#ad5511'; // Change back to the normal color
        submitAgentApplication.style.color = '#d9d9d9';
    });

    backButtonNotAgent.addEventListener('mouseenter', function() {
        backButtonNotAgent.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        backButtonNotAgent.style.color = '#202024';
    });

    backButtonNotAgent.addEventListener('mouseleave', function() {
        backButtonNotAgent.style.backgroundColor = '#ad5511'; // Change back to the normal color
        backButtonNotAgent.style.color = '#d9d9d9';
    });

    applyButton.addEventListener('mouseenter', function() {
        applyButton.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        applyButton.style.color = '#202024';
    });

    applyButton.addEventListener('mouseleave', function() {
        applyButton.style.backgroundColor = '#ad5511'; // Change back to the normal color
        applyButton.style.color = '#d9d9d9';
    });
    applyButton.addEventListener('click', function () {
        notAgentModal.style.display = 'none';
        applyAgentModal.style.display = 'block';
    });

    backButtonNotAgent.addEventListener('click', function () {
        applyAgentModal.style.display = 'none';
        notAgentModal.style.display = 'block';
    });

    window.addEventListener('click', function (event) {
        if (event.target == applyAgentModal) {
            applyAgentModal.style.display = 'none';
            notAgentModal.style.display = 'block';
        }
    });
}var notAgentModal = document.getElementById('notAgentModal');
var applyAgentModal = document.getElementById('applyAgentModal');
var applyButton = document.getElementById('applyAgentButton');
var backButtonNotAgent = document.getElementById('backButtonNotAgent');
var savePropertyButtonHideIt = document.getElementById('save-property');
var submitAgentApplication = document.getElementById('submitAgentApplication');
var loginButtonCreatePage = document.getElementById('loginButtonCreatePage');
var notLoggedInModal = document.getElementById('notLoggedInModal');




if(loginButtonCreatePage){//we are clicking the login button on create page 
    
    loginButtonCreatePage.addEventListener('click', function () {//make sure that when you click the button login comes up
        loginModal.style.display = 'block';
        notLoggedInModal.style.display = 'none';
    });
    //once login is up we need to check a few things
    //1. is that clicking close or outside of the modal it just brings you back to notLoggedInModal
    //2. we need to make sure that clicking outside of the modal for login/signup also brings you back to the notLoggedInModal
    // we will do this by getting rid of the event listeners that do that and rewrite them

    closeLoginButton.removeEventListener('click', null);
    closeLoginButton.addEventListener('click', function () {
        loginModal.style.display = 'none';
        notLoggedInModal.style.display = 'block';
    });

    closeSignupButton.removeEventListener('click', null);

    closeSignupButton.addEventListener('click', function () {
        signupModal.style.display = 'none';
        loginModal.style.display = 'block';
    });

    window.removeEventListener('click', null);
    window.addEventListener('click', function (event) {
        if (event.target == loginModal) {
            loginModal.style.display = 'none';
            notLoggedInModal.style.display = 'block';
        }
        if (event.target == signupModal) {
            signupModal.style.display = 'none';
            notLoggedInModal.style.display = 'block';
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


}

if (notAgentModal && applyAgentModal && applyButton && backButtonNotAgent && submitAgentApplication) {
    savePropertyButtonHideIt.style.display = 'none';


    submitAgentApplication.addEventListener('mouseenter', function() {
        submitAgentApplication.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        submitAgentApplication.style.color = '#202024';
    });

    submitAgentApplication.addEventListener('mouseleave', function() {
        submitAgentApplication.style.backgroundColor = '#ad5511'; // Change back to the normal color
        submitAgentApplication.style.color = '#d9d9d9';
    });

    backButtonNotAgent.addEventListener('mouseenter', function() {
        backButtonNotAgent.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        backButtonNotAgent.style.color = '#202024';
    });

    backButtonNotAgent.addEventListener('mouseleave', function() {
        backButtonNotAgent.style.backgroundColor = '#ad5511'; // Change back to the normal color
        backButtonNotAgent.style.color = '#d9d9d9';
    });

    applyButton.addEventListener('mouseenter', function() {
        applyButton.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        applyButton.style.color = '#202024';
    });

    applyButton.addEventListener('mouseleave', function() {
        applyButton.style.backgroundColor = '#ad5511'; // Change back to the normal color
        applyButton.style.color = '#d9d9d9';
    });
    applyButton.addEventListener('click', function () {
        notAgentModal.style.display = 'none';
        applyAgentModal.style.display = 'block';
    });

    backButtonNotAgent.addEventListener('click', function () {
        applyAgentModal.style.display = 'none';
        notAgentModal.style.display = 'block';
    });

    window.addEventListener('click', function (event) {
        if (event.target == applyAgentModal) {
            applyAgentModal.style.display = 'none';
            notAgentModal.style.display = 'block';
        }
    });
}