// const toggleButton = document.getElementById("language-toggle");
const languageContent = document.querySelector(
    ".PcHeader_languageContent__XFTE1"
);
// const arrowIcon = toggleButton.querySelector("img");
const languageItems = document.querySelectorAll(
    ".PcHeader_languageItem__DDFfF"
);
// const navItemText = toggleButton.querySelector(".PcHeader_navItemTxt__k3llp");

// Toggle dropdown visibility
// toggleButton.addEventListener("click", () => {
//     const isActive = languageContent.classList.toggle("active");

//     // Update arrow icon based on active state
//     if (isActive) {
//         arrowIcon.src = "images/arrow-up.png";
//     } else {
//         arrowIcon.src = "images/arrow-down.png";
//     }
// });

// Handle language item clicks
languageItems.forEach((item) => {
    item.addEventListener("click", () => {
        // Remove 'selected' class from all items
        languageItems.forEach((i) => i.classList.remove("selected"));

        // Add 'selected' class to the clicked item
        item.classList.add("selected");

        // Update the nav text to the selected language
        navItemText.textContent = item.getAttribute("data-lang");

        // Close the dropdown
        languageContent.classList.remove("active");
        arrowIcon.src = "images/arrow-down.png";
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const languageContent = document.querySelector(
        ".MLanguage_languageContent__fSXSD"
    );
    const toggleElements = document.querySelectorAll(
        ".MLanguage_languageIcon__BZdmX, .MLanguage_rightBox__V7A6C"
    );

    toggleElements.forEach((element) => {
        element.addEventListener("click", (event) => {
            event.stopPropagation(); // Prevent event bubbling
            languageContent.style.display =
                languageContent.style.display === "block" ? "none" : "block";
        });
    });

    // Optional: Hide content when clicking outside
    document.addEventListener("click", () => {
        languageContent.style.display = "none";
    });
});

function redirectToNewURL(languageCode) {
    // Get the current URL
    const currentURL = window.location.href;

    // Create a URL object to manipulate the parameters
    const url = new URL(currentURL);

    // Set the 'lang' parameter to the new language code
    url.searchParams.set("lang", languageCode);

    // Redirect to the updated URL
    window.location.href = url.toString();
}

const catalogBox = document.querySelector(".film_catalogBox__0DHTA");
const dialogContainer = document.querySelector(
    ".EpisodeDialog_dialogContainer__JCOtQ"
);
const closeIcon = document.querySelector(".EpisodeDialog_closeIcon__7oU_s");

catalogBox.addEventListener("click", function () {
    dialogContainer.hidden = false;
});

closeIcon.addEventListener("click", function () {
    dialogContainer.hidden = true;
});

function shareToFacebook() {
    var url = window.location.href;
    var facebookUrl =
        "https://www.facebook.com/sharer/sharer.php?u=" +
        encodeURIComponent(url);

    window.open(facebookUrl, "_blank", "width=600,height=400");
}
function shareToTwitter() {
    var urls = window.location.href;
    var twitterUrl =
        "https://twitter.com/share?text=DramaShort&url=" +
        encodeURIComponent(urls);

    window.open(twitterUrl, "_blank", "width=600,height=400");
}
function shareToInstagram() {
    var imageUrl = document.getElementById("imageToShare").src;
    var pageUrl = window.location.href;

    var message = "Watch Now: " + pageUrl;
    var instagramUrl =
        "https://www.instagram.com/create/story/?url=" +
        encodeURIComponent(imageUrl) +
        "&caption=" +
        encodeURIComponent(message);

    window.open(instagramUrl, "_blank");
}

function copyPageUrl() {
    var pageUrl = window.location.href;

    navigator.clipboard
        .writeText(pageUrl)
        .then(function () {})
        .catch(function (error) {});
}

function redirectToSearch(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        let searchQuery = event.target.value.trim();
        if (searchQuery) {
            let baseUrl = window.location.origin; // get the base URL without query params
            let newUrl = `${baseUrl}/search?q=${encodeURIComponent(
                searchQuery
            )}`; // append only the q parameter
            window.location.href = newUrl;
        }
    }
}

//video
