<?php

class ManualController
{
    public function index()
    {
        $manuais = Manual::selecionaTodos();

        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('manuais.html');

        $parametros = array();
        $parametros['manuais'] = $manuais;

        echo $template->render($parametros);
    }
    public function visualizar($id)
    {
        try {
            $manual = Manual::selecionaPorId($id); // Busca o manual pelo ID
    
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('manual_single.html'); // View detalhada
    
            $parametros = array();
            $parametros['manual'] = $manual;
    
            echo $template->render($parametros); // Renderiza a página do manual
        } catch (Exception $e) {
            echo '<p>Erro: ' . $e->getMessage() . '</p>';
        }
    }    
}
