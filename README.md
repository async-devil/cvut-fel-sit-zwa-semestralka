# ČVUT FEL SIT ZWA (Foundations of Web Applications) semester project &middot; [![wakatime](https://wakatime.com/badge/user/bc8fa60c-fa34-4507-b70f-24bdba32a74d/project/338614b2-17af-4f50-af64-c46db5f16371.svg)](https://wakatime.com/badge/user/bc8fa60c-fa34-4507-b70f-24bdba32a74d/project/338614b2-17af-4f50-af64-c46db5f16371)

## ZWA Recipes

ZWA Recipes is a website on which website owner can publish recipes.
In the beginning, the website has no registered admin, so the owner
signs up himself.

Admin is capable of uploading any file on the server and then adding a
link to it into the recipe, or set recipe preview image. Recipe content is
storing in the HTML format, so admin has freedom of customization.

## Local deployment

**Requires docker**

```bash
sudo docker compose up
```

After executing following command, apache server will be started on <http://localhost:80>

## Production deployment

```bash
git clone https://github.com/async-devil/cvut-fel-sit-zwa-semestralka
mv cvut-fel-sit-zwa-semestralka/src www

cd www
bash init.sh
```

After executing following command, project will be initialized and started in root of your apache folder on <http://localhost:80>
