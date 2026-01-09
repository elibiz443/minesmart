// Function to handle scroll event
window.onscroll = function() {
  var scrollButton = document.querySelector('.scroll-to-top');

  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
    scrollButton.style.display = 'block';
  } else {
    scrollButton.style.display = 'none';
  }
};

// Scroll to the top function
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}
