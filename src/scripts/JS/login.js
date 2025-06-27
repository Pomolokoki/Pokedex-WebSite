document.getElementById("submitButton").addEventListener("click", function () {
  window.location.href = window.location.href;
});
const modal = document.getElementById("resetModal");
const showBtn = document.getElementById("showResetModal");
const closeBtn = document.querySelector(".close");

showBtn.addEventListener("click", function (e) {
  e.preventDefault();
  modal.style.display = "block";
});

closeBtn.addEventListener("click", function () {
  modal.style.display = "none";
});

window.addEventListener("click", function (e) {
  if (e.target === modal) {
    modal.style.display = "none";
  }
});

document.addEventListener("DOMContentLoaded",function(){
  const url = new URL(window.location);
  if (url.searchParams.get("reset") === "success"){
    url.searchParams.delete("reset");
    window.history.replaceState({},document.title,url.pathname)
  }
});