<?php

class Usuario
{
    public static function autenticar($email, $senha)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha); // Sem segurança aqui
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado; // Retorna as informações do usuário
        } else {
            throw new Exception("E-mail ou senha incorretos.");
        }
    }
}
