// LIGHT AND DARK MODE ------------------------------------------------------
const userPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
const savedTheme = localStorage.getItem("theme");

const themeBtn = document.getElementById("btn-theme");

let isDark = userPrefersDark || savedTheme === "dark";

// Makes switchThemeBtnText only do anything if its button exists
let switchThemeBtnText = null
if (themeBtn){
    switchThemeBtnText = (() => {themeBtn.innerText = "Set theme to " + (isDark ? "light" : "dark")});
    switchThemeBtnText();
}

// If the dark theme is already chosen, apply it
if (savedTheme){
    // If the user has set mode to dark mode, set site to dark mode
    document.body.classList.toggle("dark-theme", savedTheme === "dark");

} else if (userPrefersDark){
    // If the user's browser is set to dark mode, set site to dark mode
    document.body.classList.toggle("dark-theme");
}

// Switch between the light and dark themes
function toggleTheme(){

    console.log(localStorage)
    // Switches between dark and light mode
    // Sets isDark to true if the .dark-theme was already on the body tag
    isDark = document.body.classList.toggle("dark-theme");

    // If .dark-theme was removed from the body, set "theme" to "light"
    localStorage.setItem("theme", isDark ? "dark" : "light")

    if (switchThemeBtnText){
        switchThemeBtnText();
    }
}


// FONT SIZES ------------------------------------------------------
let savedFontSize = localStorage.getItem("fontSize");

// If there is already a font size setting, apply it
if (savedFontSize){
    document.body.classList.add("txt-" + savedFontSize);
}

// Change the font setting in localstorage and apply an appropriate class to body
function setFontSize(fontSize){
    
    // Get the current font size setting
    savedFontSize = localStorage.getItem("fontSize");

    // Remove the current font size setting if present
    if (savedFontSize){
        document.body.classList.remove("txt-" + savedFontSize);
    } 

    // Store font size in local storage and apply the right size to the body tag
    localStorage.setItem("fontSize", fontSize)
    document.body.classList.add("txt-" + fontSize);
}
