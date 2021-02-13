<?php

require_once 'classes/session.php';
class SessionController extends Controller
{
    private $userSession;
    private $username;
    private $userid;
    private $session;
    private $sites;
    private $user;

    public function __construct()
    {
        parent :: __construct();
        $this->init();
    }

    //fin constructor

    public function init()
    {
        $this->session = new Session();

        $json = $this->getJSONFileConfig();

        $this->sites = $json['sites'];
        $this->defaultSites = $json['default-sites'];

        $this->validateSession();
    }

    //fin init

    private function getJSONFileConfig()
    {
        $string = file_get_contents('config/access.json');
        $json = json_decode($string, true);

        return $json;
    }

    //fin config json

    public function validateSession()
    {
        // echo 'validatesession';

        if ($this->existSession()) {
            $role = $this->getUserSessionData()->getRole();
            //si es publica
            if ($this->isPublic()) {
                $this->redirectDefaultSiteByRole($role);
            //fin ifinterior
            } else {
                //no existe
                if ($this->isAuthorized($role)) {
                    //puede pasar
                } else {
                    $this->redirectDefaultSiteByRole($role);
                }//fin ifelse interior
            }
        } else {
            if ($this->isPublic()) {
                //es publica no pasa nada
            } else {
                header('Location: '.constant('URL').'');
            }
        }
    }

    //fin valida session

    public function existSession()
    {
        if (!$this->session->exists()) {
            return false;
        }
        if ($this->session->getCurrentUser() == null) {
            return false;
        }

        $userid = $this->session->getCurrentUser();

        if ($userid) {
            return true;
        }

        return false;
    }

    //fin existe session

    public function getUserSessionData()
    {
        $id = $this->userid; //comprobar
        $this->user = new UserModel();
        $this->user->get($id);
        //echo 'getUserSessionData en sessioncontroller en classes'
        return $this->user;
    }

    //fin get

    public function inicialize($user)
    {
        $this->session->setCurrentUser($user->getId());
        $this->authorizeAccess($user->getRole());
    }

    private function isPublic()
    {
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace("/\?.*/", '', $currentURL);

        for ($i = 0; $i < sizeof($this->sites); ++$i) {
            if ($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['access'] === 'public') {
                return true;
            }//fin if
        }//fin for

        return false;
    }

    //fin ispublic

    private function redirectDefaultSiteByRole($rol)
    {
        $url = '';
        for ($i = 0; $i < sizeof($this->sites); ++$i) {
            if ($this->sites[$i]['role'] === $role) {
                $url = '/gimnasio/app/'.$this->sites[$i]['site'];   //tb modificado cuidado
                break;
            }//fin if
        }//fin for
        header('location: '.$url);
    }

    //fin redirige

    private function isAuthorize($role)
    {
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace("/\?.*/", '', $currentURL);

        for ($i = 0; $i < sizeof($this->sites); ++$i) {
            if ($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['role'] === $role) {
                return true;
            }//fin if
        }//fin for

        return false;
    }

    //fin esta autorizado

    private function getCurrentPage()
    {
        $actualLink = trim("$_SERVER[REQUEST_URI]");
        $url = explode('/', $actualLink);

        return $url[2];
    }

    //get pagina

    public function authorizeAccess($role)
    {
        //1 usuario 0 admin
        switch ($role) {
            case '1':
                $this->redirect($this->defaultSites['1'], []);
            break;
            case '0':
                $this->redirect($this->defaultSites['0'], []);
            break;
        }
    }

    //fin autprizar acceso

    public function logout()
    {
        $this->session->closeSession();
    }
}
