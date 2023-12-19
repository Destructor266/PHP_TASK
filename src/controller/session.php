<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../classes/admin.php';
require_once __DIR__ . '/../classes/client.php';
require_once __DIR__ . '/../tools/tools.php';

class Session
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function authentication($username, $password)
    {
        $usuaris = readtextfiles(FITXER_USUARIS);
        $autenticat = false;
        foreach ($usuaris as $usuari) {
            $dadesUsuari = explode(":", $usuari);
            $nomUsuari = $dadesUsuari[1];
            $ctsUsuari = $dadesUsuari[3];
            if (($nomUsuari == $username) && (password_verify($password, $ctsUsuari))) {
                $autenticat = true;
                break;
            } else  $autenticat = false;
        }

        return $autenticat;
    }

    public static function authoritation($username)
    {
        $usuaris = readtextfiles(FITXER_USUARIS);
        $objecte = null;
        $autoritzat = false;
        foreach ($usuaris as $usuari) {
            $dadesUsuari = explode(":", $usuari);
            $idUsuari = $dadesUsuari[0];
            $nomUsuari = $dadesUsuari[1];
            $email = $dadesUsuari[2];
            $ctsUsuari = $dadesUsuari[3];
            $tipusUsuari = $dadesUsuari[sizeof($dadesUsuari) - 1];
            if (($nomUsuari == $username) && ($tipusUsuari == ADMIN)) {
                $autoritzat = true;
                $objecte = new Admin();
                break;
            } else if (($nomUsuari == $username) && ($tipusUsuari == CLIENT)) {
                $autoritzat = true;
                $objecte = new Client($idUsuari, $nomUsuari, $email, $ctsUsuari);
                break;
            } else $autoritzat = false;
        }
        return [$autoritzat, $objecte];
    }

    public function startSession()
    {
        $autenticat = Session::authentication($this->username, $this->password);
        echo $autenticat;
        if ($autenticat) {
            [$autoritzat, $user] = Session::authoritation($this->username);
            echo $autoritzat;
            //var_dump($user);
            if ($autoritzat) {
                switch (get_class($user)) {
                    case 'Admin':
                        session_start();
                        $_SESSION['usuari'] = $user;
                        $_SESSION['expira'] = time() + TEMPS_EXPIRACIO;
                        header("Location: ./admin_dashboard.php");
                        exit();
                        break;
                    case 'Client':
                        session_start();
                        $_SESSION['usuari'] = $user;
                        $_SESSION['expira'] = time() + TEMPS_EXPIRACIO;
                        header("Location: ./client_dashboard.php");
                        exit();
                        break;
                    default:
                        header("Location: ./error_login.php");
                        break;
                }
            }
        } else {
            //header("Location: ../pages/error_autoritzacio.php");
        }
        return $autoritzat;
    }


    public static function endSession()
    {
        session_start();
        //Alliberant variables de sessió. Esborra el contingut de les variables de sessió del fitxer de sessió. Buida l'array $_SESSION. No esborra cookies
        session_unset();
        //Destrucció de la cookie de sessió dins del navegador
        $cookie_sessio = session_get_cookie_params();
        setcookie("PHPSESSID", "", time() - 3600, $cookie_sessio['path'], $cookie_sessio['domain'], $cookie_sessio['secure'], $cookie_sessio['httponly']); //Neteja cookie de sessió
        //Destrucció de la informació de sessió (per exemple, el fitxer de sessió  o l'identificador de sessió) 
        session_destroy();
        header("Location: index.php");
    }
}
