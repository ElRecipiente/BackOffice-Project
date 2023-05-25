<?php

namespace src\controllers;

use core\BaseController;
use src\models\User;
use src\models\UserHistory;


class UserController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new User;
    }

    public function users()
    {
        $users = $this->model->getAll();

        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('users/users.html.twig', ['users' => $users, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
            unset($_SESSION['popup']);
        } else {
            $this->render('users/users.html.twig', ['users' => $users, 'username' => $_SESSION['Admin']]);
        }
    }

    public function editUser()
    {
        $id = $_GET['userid'];
        $user = $this->model->getOne($id);

        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('users/edituser.html.twig', ['user' => $user, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
            unset($_SESSION['popup']);
        } else {
            $this->render('users/edituser.html.twig', ['user' => $user, 'username' => $_SESSION['Admin']]);
        }
        $this->render('users/edituser.html.twig', ['user' => $user, 'username' => $_SESSION['Admin']]);
    }

    public function updateThisUser()
    {
        if (($_POST['budget'] >= 0 && $_POST['budget'] <= 999) && !empty(trim($_POST['budget'])) && preg_match('/^[0-9]+$/', $_POST['budget'])) {
            $userid = $_GET['userid'];

            $user = $this->model->getOne($userid);

            //création d'un historique des modifications
            if ($user->budget != $_POST['budget']) {
                $budget = $_POST['budget'] - $user->budget;
                $userid =  $user->id;
                $admin = $_SESSION['Admin'];
                $history = new UserHistory();
                $history->insertHistory($admin, $userid, $budget);
            }

            $this->model->updateUser($userid);

            $_SESSION['popup'] = "La base de donnée a été mise à jour avec succès.";

            header('Location: /users');
            exit;
        } else {
            $id = $_GET['userid'];
            $_SESSION['popup'] = "Le champ budget doit être un nombre compris entre 0 et 999.";
            header('Location: /edituser?userid=' . $id);
            exit;
        }
    }

    public function newUser()
    {
        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('users/newuser.html.twig', ['popup' => $popup, 'username' => $_SESSION['Admin']]);
            unset($_SESSION['popup']);
        } else {
            $this->render('users/newuser.html.twig', ['username' => $_SESSION['Admin']]);
        }
    }

    public function addUser()
    {
        if ($_POST["password"] != $_POST["passwordverif"]) {
            $_SESSION['popup'] = "Les mots de passes ne sont pas identiques.";
            header('Location: /newuser');
            exit;
        } else if (!empty(trim($_POST['username'])) && !empty(trim($_POST['budget'])) && !empty(trim($_POST['password'])) && isset($_POST['isAdmin'])) {
            if (preg_match('/^[\wÀ-ÖØ-öø-ÿ]+$/u', $_POST['username']) &&  preg_match('/^[0-9]+$/', $_POST['budget'])) {
                $this->model->addNewUser();
                $_SESSION['popup'] = "L'entrée a été ajoutée à la base de donnée avec succès.";

                header('Location: /users');
                exit;
            } else {
                $_SESSION['popup'] = "Le nom utilisateur ou le budget comporte des caractères non acceptés. Caractères alphanumériques uniquement, et budget entre 0 et 999.";

                header('Location: /newuser');
                exit;
            }
        } else {
            $_SESSION['popup'] = "Tous les champs sont obligatoires.";

            header('Location: /newuser');
            exit;
        }
    }

    public function auth()
    {
        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('users/auth.html.twig', ['popup' => $popup]);
            unset($_SESSION['popup']);
        } else {
            $this->render('users/auth.html.twig');
        }
    }

    public function tryConnexion()
    {
        if (!empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
            $admin = $this->model->connect();

            if (!empty($admin)) {
                $_SESSION['Admin'] = $admin->username;
                $_SESSION['id'] = $admin->id;
                header('Location: /');
                exit;
            } else {
                $_SESSION['popup'] = "Identifiants incorrects.";
                header('Location: /auth');
                exit;
            }
        } else {
            $_SESSION['popup'] = "Tous les champs sont obligatoires.";
            header('Location: /auth');
            exit;
        }
    }

    public function displayJSON($id)
    {
        $user = $this->model->getOne($id);
        $data = json_encode($user);

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        echo $data;
    }

    public function disconnect()
    {
        $_SESSION['Admin'] = null;
        header('Location: /');
    }
}
