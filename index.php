<?php
	session_start();

	require_once 'app/Core/Core.php';

	require_once 'lib/Database/Connection.php';

	require_once 'app/Controller/HomeController.php';
	require_once 'app/Controller/ErroController.php';
	require_once 'app/Controller/PostController.php';
	require_once 'app/Controller/SobreController.php';
	require_once 'app/Controller/AdminController.php';

	require_once 'app/Model/Postagem.php';
	require_once 'app/Model/Comentario.php';

	require_once 'app/Controller/LoginController.php';
	require_once 'app/Model/Usuario.php';

	require_once 'app/Controller/ManualController.php';
	require_once 'app/Model/Manual.php';

	require_once 'vendor/autoload.php';


	$template = file_get_contents('app/Template/estrutura.html');

	ob_start();
		$core = new Core;
		$core->start($_GET);

		$saida = ob_get_contents();
	ob_end_clean();

	$tplPronto = str_replace('{{area_dinamica}}', $saida, $template);
	//echo $tplPronto;
	$loader = new \Twig\Loader\ArrayLoader(['estrutura' => $tplPronto]);
	$twig = new \Twig\Environment($loader);
	$dadosUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
	echo $twig->render('estrutura', ['usuario' => $dadosUsuario]);


	
