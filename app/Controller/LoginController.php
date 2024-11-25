<?php

class LoginController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('login.html');

        echo $template->render([]);
    }

    public function autenticar()
    {
        try {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if (empty($email) || empty($senha)) {
                throw new Exception("Preencha todos os campos.");
            }

            $usuario = Usuario::autenticar($email, $senha);

            // Se autenticar com sucesso, inicia sessão e redireciona
            $_SESSION['usuario'] = $usuario;

            if ($usuario['tipo'] === 'admin') {
                header('Location: http://localhost/siteleo/');
            } else {
                header('Location: http://localhost/siteleo/');
            }
            exit;

        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<script>location.href="http://localhost/siteleo/?pagina=login&metodo=index"</script>';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: http://localhost/siteleo/');
        exit;
    }
}
