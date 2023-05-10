<?php

namespace src\controllers;

use core\BaseController;
use src\models\User;

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
            $id = $_GET['userid'];
            $this->model->updateUser($id);
            header('Location: /users');
            exit;
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
            header('Location: /users');
            exit;
        } else {
            echo "<p class='error'>Tous les champs sont obligatoires.</p>";

            $this->render('users/newuser.html.twig', ['username' => $_SESSION['Admin']]);
        }
    }

    public function auth()
    {
        $this->render('users/auth.html.twig', ['username' => $_SESSION['Admin']]);
    }

    public function tryConnexion()
    {
        if (!empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
            $admin = $this->model->connexion();

            if ($admin) {
                $_SESSION['Admin'] = $_POST['username'];
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
