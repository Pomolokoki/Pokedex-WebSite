// --- Rafraîchissement si bouton présent ---
const submitButton = document.getElementById('submitButton');
if (submitButton) {
  submitButton.addEventListener('click', function () {
    window.location.href = window.location.href;
  });
}

// --- Affichage / masquage du mot de passe ---
document.addEventListener("DOMContentLoaded", function () {
  const passwordInput = document.getElementById("pword");
  const toggle = document.getElementById("togglePassword");

  if (passwordInput && toggle) {
    toggle.addEventListener("click", function () {
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
    });
  }
});
