var notAgentModal = document.getElementById('notAgentModal');
var applyAgentModal = document.getElementById('applyAgentModal');
var applyButton = document.getElementById('applyAgentButton');
var backButtonNotAgent = document.getElementById('backButtonNotAgent');
var savePropertyButtonHideIt = document.getElementById('save-property');
var submitAgentApplication = document.getElementById('submitAgentApplication');


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