read -p "Enter server prefix: " prefix
echo "PREFIX=\"$prefix\"" > .env
echo "Initialized .env file"

touch common/Authentication/credentials.env
chmod 777 common/Authentication/credentials.env
echo "Initialized and granted access to common/Authentication/credentials.env file"

echo "[]" > common/Database/database.json
chmod 777 common/Database/database.json
echo "Initialized and granted access to common/Database/database.json file"

mkdir -p public/assets/uploads
chmod 777 public/assets/uploads
echo "Initialized and granted access to public/assets/uploads folder"