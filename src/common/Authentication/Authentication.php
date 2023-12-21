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

  private function createCredentialsFileIfAbsent(): void
  {
    if (!file_exists(Authentication::CREDENTIALS_FILE)) {
      file_put_contents(Authentication::CREDENTIALS_FILE, "");
    }
  }

  /**
   * read password hash from credentials.env, if absent, set to adminPasswordHash field null
   */
  private function getAdminCredential(): void
  {
    $this->adminPasswordHash = parse_ini_file(__DIR__ . "/credentials.env")["ADMIN_PASSWORD_HASH"] ?? null;
  }

  /**
   * reset password hash to credentials.env
   */
  private function setAdminCredential(): void
  {
    file_put_contents(Authentication::CREDENTIALS_FILE, "ADMIN_PASSWORD_HASH='{$this->adminPasswordHash}'");
  }

  /**
   * check if password is set
   */
  public function isNeedInit(): bool
  {
    return is_null($this->adminPasswordHash);
  }

  /**
   * hash password and puts it into credentials.env file
   */
  private function setPassword(string $password): void
  {
    $this->adminPasswordHash = password_hash($password, PASSWORD_DEFAULT);
    $this->setAdminCredential();

    $this->getAdminCredential();
  }

  /**
   * set password and "loggedIn" session field to true
   */
  public function register(string $password): void
  {
    $this->setPassword($password);

    $_SESSION["loggedIn"] = true;
  }

  /**
   * On invalid password die with 401 http code,
   * on valid, set "loggedIn" session field to true
   */
  public function logIn(string $password): void
  {
    if (!password_verify($password, $this->adminPasswordHash)) {
      HTTPException::sendException(401, "Incorrect password");
    }

    $_SESSION["loggedIn"] = true;
  }

  /**
   * destroy session
   */
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
