import { sendData } from "./common/send-data.js";

window.onload = () => {
  const form = document.getElementById("recipe");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const prefix = document.getElementById("prefix");
    const operation = document.getElementById("operation");

    const errorField = document.getElementById("errorField");

    const id = document.getElementById("id");

    const name = document.getElementById("name");
    const description = document.getElementById("description");
    const source = document.getElementById("source");
    const previewImage = document.getElementById("previewImage");
    const tag = document.getElementById("tag");
    const content = document.getElementById("content");

    if (
      !name.value ||
      !description.value ||
      !source.value ||
      !previewImage.value ||
      !tag.value ||
      !content.value
    ) {
      errorField.innerText = "Fields must not be empty";
      return;
    }

    if (operation.value === "create") {
      return void sendData(
        "POST",
        `${prefix.value ? `/${prefix.value}/` : ""}/recipes`,
        {
          name: name.value,
          description: description.value,
          source: source.value,
          previewImage: previewImage.value,
          tag: tag.value,
          content: content.value,
        }
      ).then((response) => {
        if (response.code !== 201) errorField.innerText = response.data.message;
        else
          location.href = `${
            prefix.value ? `/${prefix.value}/` : ""
          }/recipes/catalog/all`;
      });
    } else if (operation.value === "update") {
      return void sendData(
        "POST",
        `${prefix.value ? `/${prefix.value}` : ""}/recipes/update/${id.value}`,
        {
          name: name.value,
          description: description.value,
          source: source.value,
          previewImage: previewImage.value,
          tag: tag.value,
          content: content.value,
        }
      ).then((response) => {
        if (response.code !== 200) errorField.innerText = response.data.message;
        else
          location.href = `${prefix.value ? `/${prefix.value}` : ""}/recipes/${
            id.value
          }`;
      });
    } else {
      errorField.innerText = "Unknown operation value";
    }
  });
};
