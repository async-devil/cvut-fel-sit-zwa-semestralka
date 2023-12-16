<?php

declare(strict_types=1);

namespace App;

require_once __DIR__ . "/../Router/HTTPException.php";

use App\HTTPException;

class Authentication
{

  private const CREDENTIALS_FILE = __DIR__ . "/credentials.env";
  private ?string $adminPasswordHash = null;

  public function __construct()
  {
    $this->createCredentialsFileIfAbsent();
    $this->getAdminCredential();

    session_start();
  }

  private function createCredentialsFileIfAbsent()
  {
    if (!file_exists(Authentication::CREDENTIALS_FILE)) {
      file_put_contents(Authentication::CREDENTIALS_FILE, "");
    }
  }

  private function getAdminCredential(): void
  {
    $this->adminPasswordHash = parse_ini_file(__DIR__ . "/credentials.env")["ADMIN_PASSWORD_HASH"] ?? null;
  }

  private function setAdminCredential(): void
  {
    file_put_contents(Authentication::CREDENTIALS_FILE, "ADMIN_PASSWORD_HASH='{$this->adminPasswordHash}'");
  }

  public function isNeedInit(): bool
  {
    return is_null($this->adminPasswordHash);
  }

  private function setPassword(string $password): void
  {
    $this->adminPasswordHash = password_hash($password, PASSWORD_DEFAULT);
    $this->setAdminCredential();

    $this->getAdminCredential();
  }

  public function register(string $password): void
  {
    $this->setPassword($password);

    $_SESSION["loggedIn"] = true;
  }

  public function logIn(string $password): void
  {
    if (!password_verify($password, $this->adminPasswordHash)) {
      HTTPException::sendException(401, "Incorrect password");
    }

    $_SESSION["loggedIn"] = true;
  }

  public function logOut(): void
  {
    session_unset();
    session_destroy();
  }

  public function isLoggedIn(): bool
  {
    return isset($_SESSION["loggedIn"]);
  }
}
