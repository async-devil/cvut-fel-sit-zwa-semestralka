import { sendData } from "./common/send-data.js";

window.onload = () => {
  const form = document.getElementById("register");

  const passwordRegExp = new RegExp(
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/m
  );

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const prefix = document.getElementById("prefix");

    const errorField = document.getElementById("errorField");

    const password = document.getElementById("password");
    const password2 = document.getElementById("password2");

    if (
      !password.value.match(passwordRegExp) ||
      !password2.value.match(passwordRegExp)
    ) {
      errorField.innerText =
        "Password must contain minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character";
      return;
    }

    if (password.value !== password2.value) {
      errorField.innerText = "Passwords must be equal";
      return;
    }

    void sendData(
      "POST",
      `${prefix.value ? `/${prefix.value}` : ""}/admin/register`,
      {
        password: password.value,
      }
    ).then((response) => {
      if (response.code !== 200) errorField.innerText = response.data.message;
      else location.reload();
    });
  });
};
