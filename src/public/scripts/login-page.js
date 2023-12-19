import { sendData } from "./common/send-data.js";

window.onload = () => {
  const form = document.getElementById("login");

  const passwordRegExp = new RegExp(
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/m
  );

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const prefix = document.getElementById("prefix");

    const errorField = document.getElementById("errorField");

    const password = document.getElementById("password");

    if (!password.value.match(passwordRegExp)) {
      errorField.innerText =
        "Password must contain minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character";
      return;
    }

    void sendData(
      "POST",
      `${prefix.value ? `/${prefix.value}` : ""}/admin/login`,
      {
        password: password.value,
      }
    ).then((response) => {
      if (response.code !== 200) errorField.innerText = response.data.message;
      else location.reload();
    });
  });
};
