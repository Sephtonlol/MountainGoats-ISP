// als de zoekbalk leeg is zal de Iframe automatisch sluiten
document.getElementById("searchBox").addEventListener("input", function() {
    var query = document.getElementById("searchBox").value;
    var searchUrl1 = "https://support.microsoft.com/search/results?query=" + encodeURIComponent(query);
    var searchFrame = document.getElementById("searchFrame");
    if (query.trim() === "") {
        // "if" zal die sluiten
        document.getElementById("searchFrame").src = "";
    } else {
        // "else" zal die open blijven
        document.getElementById("searchFrame").src = searchUrl1;
        // dit zorgt ervoor dazt scrollen werkt met gebruik van deze source in de Iframe
        searchFrame.removeAttribute("scrolling");
        searchFrame.setAttribute("scrolling", "yes");
    }
});

var button4 = document.getElementById("button4");
var searchUrl2 = "https://www.bing.com/translator";
button4.addEventListener("click", function() {
// Wanneer de knop wordt ingedrukt zal de zoekbalk automatisch leeg gemaakt worden
document.getElementById("searchBox").value = "";
    // opent een website in de Iframe
document.getElementById("searchFrame").src = searchUrl2;
});
var button7 = document.getElementById("button7");
var searchUrl3 = "https://www.bing.com/search?q=Bing+AI&showconv=1&FORM=hpcodx&itrid=654275aed15a494093ecbc9394a1f932";
var searchFrame = document.getElementById("searchFrame");
// Voeg een event listener toe aan de knop
button7.addEventListener("click", function() {
// Wanneer de knop wordt ingedrukt zal de zoekbalk automatisch leeg gemaakt worden
document.getElementById("searchBox").value = "";
    // opent een website in de Iframe
document.getElementById("searchFrame").src = searchUrl3;
searchFrame.removeAttribute("scrolling");
searchFrame.setAttribute("scrolling", "no");
});

const button = document.getElementById('mountainGoats');
const mountainGoatsByClass = document.getElementsByClassName("play");
const audio = new Audio("./Assets/goatScream.mp3");

let clickCount = 0;
let lastClickTime = 0;
button.addEventListener('click', () => {
  const currentTime = new Date().getTime();
//   telt alleen clicks binnen de 2 seconden time frame
  if (currentTime - lastClickTime > 2000) {
    clickCount = 0;
  }
  clickCount++;
  lastClickTime = currentTime;
  if (clickCount === 7) {
    audio.play();
    // reset de click counter na het bereiken van de 7 clicks
    clickCount = 0; 
  }
});

const specificImagePath = './Assets/helpHome.png';
const popupOverlay = document.querySelector('.popup-overlay');
const popupImage = document.getElementById('popupImage');

// Event listener for the helpButton
document.getElementById('helpButton').addEventListener('click', () => {
  // Set the source and dimensions of the popup image
  popupImage.src = specificImagePath;
  popupImage.style.maxWidth = '90%';
  popupImage.style.maxHeight = '90vh';

  // Display the popup overlay
  popupOverlay.style.display = 'flex'; // Use flex to center the content vertically and horizontally
});

// Close the popup overlay when the close button is clicked
document.querySelector('.popup-imsgespan').addEventListener('click', () => {
  // Hide the popup overlay
  popupOverlay.style.display = 'none';
});

