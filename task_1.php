<?php
trait AppUserAuthentication
{
    private $appLogin = 'admin';
    private $appPassword = '12345';
    public function authenticate($login, $password)
    {
        if ($login === $this->appLogin && $password === $this->appPassword) {
            return true;
        }
        return false;
    }
}
trait MobileUserAuthentication
{
    private $mobileLogin = 'user';
    private $mobilePassword = '54321';
    public function authenticate($login, $password)
    {
        if ($login === $this->mobileLogin && $password === $this->mobilePassword) {
            return true;
        }
        return false;
    }
}
class User
{
    use AppUserAuthentication, MobileUserAuthentication {
        AppUserAuthentication::authenticate insteadof MobileUserAuthentication;
        MobileUserAuthentication::authenticate as mobileAuthenticate;
    }
    private $login;
    private $password;
    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }
    public function login()
    {
        if ($this->authenticate($this->login, $this->password)) {
            echo "пользователь приложения\n";
        } elseif ($this->mobileAuthenticate($this->login, $this->password)) {
            echo "пользователь мобильного приложения\n";
        } else {
            echo "Ошибка авторизации\n";
        }
    }
}
$user1 = new User('admin', '12345');
$user1->login(); // пользователь приложения
$user2 = new User('user', '54321');
$user2->login(); // пользователь мобильного приложения
$user3 = new User('test', 'test');
$user3->login(); // ошибка авторизации
?>
