<?php

class Manual
{
    public static function selecionaTodos()
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM manuais ORDER BY id DESC";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Manual')) {
            $resultado[] = $row;
        }

        if (!$resultado) {
            throw new Exception("Não foi encontrado nenhum registro no banco.");
        }

        return $resultado;
    }

    public static function selecionaPorId($idManual)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM manuais WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idManual, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Manual');

        if (!$resultado) {
            throw new Exception("Não foi encontrado nenhum registro no banco.");
        }

        return $resultado;
    }

    public static function insert($dadosManual)
    {
        if (empty($dadosManual['titulo']) || empty($dadosManual['conteudo'])) {
            throw new Exception("Preencha todos os campos.");

            return false;
        }

        $con = Connection::getConn();

        $sql = $con->prepare('INSERT INTO manuais (titulo, conteudo) VALUES (:tit, :cont)');
        $sql->bindValue(':tit', $dadosManual['titulo']);
        $sql->bindValue(':cont', $dadosManual['conteudo']);
        $res = $sql->execute();

        if ($res == 0) {
            throw new Exception("Falha ao inserir manual.");

            return false;
        }

        return true;
    }

    public static function update($params)
    {
        $con = Connection::getConn();

        $sql = "UPDATE manuais SET titulo = :tit, conteudo = :cont WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':tit', $params['titulo']);
        $sql->bindValue(':cont', $params['conteudo']);
        $sql->bindValue(':id', $params['id']);
        $resultado = $sql->execute();

        if ($resultado == 0) {
            throw new Exception("Falha ao alterar manual.");

            return false;
        }

        return true;
    }

    public static function delete($id)
    {
        $con = Connection::getConn();

        $sql = "DELETE FROM manuais WHERE id = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $id);
        $resultado = $sql->execute();

        if ($resultado == 0) {
            throw new Exception("Falha ao deletar manual.");

            return false;
        }

        return true;
    }
}
