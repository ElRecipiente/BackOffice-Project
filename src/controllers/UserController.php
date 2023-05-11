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

        $this->render('users/users.html.twig', ['users' => $users, 'username' => $_SESSION['Admin']]);
    }

    public function editUser()
    {
        $id = $_GET['userid'];
        $user = $this->model->getOne($id);
        $this->render('users/edituser.html.twig', ['user' => $user, 'username' => $_SESSION['Admin']]);
    }

    public function updateThisUser()
    {
        if (!empty(trim($_POST['username'])) && !empty(trim($_POST['budget']))) {
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

            $popup = "La base de donnée a été mise à jour avec succès.";

            $users = $this->model->getAll();
            $this->render('users/users.html.twig', ['users' => $users, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
        } else {
            echo "<p class='error'>Tous les champs sont obligatoires.</p>";
            $id = $_GET['userid'];
            $user = $this->model->getOne($id);
            $this->render('users/edituser.html.twig', ['user' => $user, 'username' => $_SESSION['Admin']]);
        }
    }

    public function newUser()
    {
        $this->render('users/newuser.html.twig', ['username' => $_SESSION['Admin']]);
    }

    public function addUser()
    {
        if ($_POST["password"] != $_POST["passwordverif"]) {
            echo "<p class='error'>Les mots de passes ne sont pas identiques.</p>";
            $this->render('users/newuser.html.twig', ['username' => $_SESSION['Admin']]);
        } else if (!empty(trim($_POST['username'])) && !empty(trim($_POST['budget'])) && !empty(trim($_POST['password'])) && isset($_POST['isAdmin'])) {
            $this->model->addNewUser();
            $popup = "L'entrée a été ajoutée à la base de donnée avec succès.";

            $users = $this->model->getAll();
            $this->render('users/users.html.twig', ['users' => $users, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
        } else {
            echo "<p class='error'>Tous les champs sont obligatoires.</p>";

            $this->render('users/newuser.html.twig', ['username' => $_SESSION['Admin']]);
        }
    }

    public function auth()
    {
        $this->render('users/auth.html.twig');
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
                echo "<p class='error'>Identifiants incorrects.</p>";
                $this->render('users/auth.html.twig', ['username' => $_SESSION['Admin']]);
            }
        } else {
            echo "<p class='error'>Tous les champs sont obligatoires.</p>";
            $this->render('users/auth.html.twig', ['username' => $_SESSION['Admin']]);
        }
    }

    public function disconnect()
    {
        $_SESSION['Admin'] = null;
        header('Location: /');
    }

    public function whoIsConnect()
    {
    }
}
