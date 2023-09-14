// Get allparentContainers
const parentContainers = document.querySelectorAll(".parent-container");

// Function to check if an element is in the viewport
function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function updateActivePageIndicator() {
    parentContainers.forEach(function(page) { // loop through each parent page
        const target = page.dataset.target; // associated sidebar element for this current parent page
        const sidebarElement = document.getElementById(target); // get the sidebar element

        if (isElementInViewport(page)) { // if the parent page is in the viewport
            sidebarElement.classList.add("current-page-bg-effect"); // add the background effect to sidebar element
        } else {
            sidebarElement.classList.remove("current-page-bg-effect");
        }
    });
}


// Listen for scroll events
window.addEventListener("scroll", updateActivePageIndicator);

// Initial check (in case user starts midway down the page)
updateActivePageIndicator();
