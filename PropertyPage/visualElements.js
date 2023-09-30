const parentContainers = document.querySelectorAll(".parent-container");
const sidebarElements = document.querySelectorAll(".page-indicator-inner-container");

// Function to check if an element is in the viewport
function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    let offset = 300;
    // console.log(el);
    // console.log("top = " + rect.top );
    // console.log("bottom = " + rect.bottom );
    // console.log("window.innerHeight = " + (window.innerHeight - offset));
    // console.log("clientHeight = " + document.documentElement.clientHeight);
    
    
    return (
        rect.top >= 0 - offset &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight + offset || document.documentElement.clientHeight + offset) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function updateActivePageIndicator() {
    parentContainers.forEach(function(page) { // loop through each parent page
        const target = page.dataset.target; // associated sidebar element for this current parent page
        const sidebarElement = document.getElementById(target); // get the sidebar element
        // console.log("target = " + target);
        // console.log(sidebarElement);

        if (isElementInViewport(page)) { // if the parent page is in the viewport
            console.log("in viewport!!!!!!!!!!!!!!!!!!!!!!!!");
            sidebarElement.classList.add("current-page-bg-effect"); // add the background effect to sidebar element
        } else {
            if (sidebarElement) { //if not null
                sidebarElement.classList.remove("current-page-bg-effect");
            }
        }
    });
}

function scrollToPointOnPage(e) {
    const target = e.dataset.target;
    console.log(target);
    document.getElementById(target).scrollIntoView({behavior: 'smooth'});
}




// Initial check (in case user starts midway down the page)
updateActivePageIndicator();

// Listen for scroll events
window.addEventListener("scroll", updateActivePageIndicator);

// Listen for click on sidebar elements
// sidebarElements.forEach(function(element) {
//     element.addEventListener("click", function() {
//         scrollToPointOnPage(element);
//     });
// });
