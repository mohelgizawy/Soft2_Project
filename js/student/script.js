function validationEmail() {
  let emailInput = document.getElementById("email-content");
  let email = emailInput.value;

  if (emailInput) {
    if (email.length == 0) {
      emailInput.style.border = "2px solid red";
      return false;
    } else if (!email.match(/\w+@\w+[.]\w+[.]\w+[.]\w+/)) {  // 5615616@ci.menofia.edu.eg
      emailInput.style.border = "2px solid red";
      return false;
    } else {
      emailInput.style.border = "2px solid green";
      return true;
    }
  } else {
    // Handle the case where the element is not found
    console.error("Email input element not found!");
  }
}

const inputImage = document.querySelector(`.edit-image input[type="file"]`);
const imageDisplay = document.querySelector(`.image img`);
const icon = document.querySelector(`.edit-image i`);

inputImage.onchange = (event) => {
  event.preventDefault();
  const file = event.target.files[0];
  imageDisplay.src = URL.createObjectURL(file);
};
icon.onclick = (event) => {
  event.preventDefault();
  inputImage.click();
};
