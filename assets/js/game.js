// Cet événement s'assure que le code JS ne s'exécute qu'une fois que le DOM de la page est complètement chargé
document.addEventListener("DOMContentLoaded", () => {
  const startButton = document.getElementById("start-new-round");
  const revealButton = document.getElementById("reveal-number");
  const guessForm = document.getElementById("guess-form");
  const guessInput = document.getElementById("guess-input");
  const feedback = document.getElementById("feedback");
  const previousGuesses = document.getElementById("previous-guesses");

  // Start a new game round
  startButton.addEventListener("click", () => {
    const guessLimit =
      prompt("Enter the maximum number of guesses (minimum 4):", "4") || "4";
//Envoie une requête POST au serveur
    fetch("game.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },//Indique que les données sont envoyées sous la forme d'un formulaire
      body: new URLSearchParams({ action: "start", guess_limit: guessLimit }),//Contient les données à transmettre, ici l'action "start" et la limite de suppositions
    })
      .then((response) => response.json())
      .then((data) => {
        feedback.textContent = data.message;
        previousGuesses.textContent = "Your guesses: ";
        guessInput.disabled = false;
        guessInput.value = "";
      })
      .catch(console.error);
  });

  // Submit a guess
  guessForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const guess = guessInput.value;

    fetch("game.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ action: "guess", guess }),
    })
      .then((response) => response.json())
      .then((data) => {
        feedback.textContent = data.message;

        if (data.guesses) {
          previousGuesses.textContent =
            "Your guesses: " + data.guesses.join(", ");
        }

        if (data.status === "Success" || data.status === "Fail") {
          guessInput.disabled = true;
        } else {
          guessInput.value = "";
        }
      })
      .catch(console.error);
  });

  // Reveal the target number
  revealButton.addEventListener("click", () => {
    fetch("game.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ action: "reveal" }),
    })
      .then((response) => response.json())
      .then((data) => {
        feedback.textContent = data.message;
      })
      .catch(console.error);
  });
});
