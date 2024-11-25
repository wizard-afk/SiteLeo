<?php 

	class AdminController
	{
		public function index()
		{
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('admin.html');

			$objPostagens = Postagem::selecionaTodos();
			$objManuais = Manual::selecionaTodos(); // Busca os manuais

			$con = Connection::getConn();
			$sql = "SELECT id, email, tipo FROM usuarios";
			$stmt = $con->prepare($sql);
			$stmt->execute();
			$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$parametros = array();
			$parametros['postagens'] = $objPostagens;
			$parametros['manuais'] = $objManuais; // Adiciona os manuais
			$parametros['usuarios'] = $usuarios;

			$conteudo = $template->render($parametros);
			echo $conteudo;
		}

		public function create()
		{
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('create.html');

			$parametros = array();

			$conteudo = $template->render($parametros);
			echo $conteudo;
		}

		public function insert()
		{
			try {
				Postagem::insert($_POST);

				echo '<script>alert("Publicação inserida com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch(Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=create"</script>';
			}
			
		}

		public function change($paramId)
		{
			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('update.html');

			$post = Postagem::selecionaPorId($paramId);

			$parametros = array();
			$parametros['id'] = $post->id;
			$parametros['titulo'] = $post->titulo;
			$parametros['conteudo'] = $post->conteudo;

			$conteudo = $template->render($parametros);
			echo $conteudo;
		}

		public function update()
		{
			try {
				Postagem::update($_POST);

				echo '<script>alert("Publicação alterada com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=change&id='.$_POST['id'].'"</script>';
			}
		}

		public function delete($paramId)
		{
			try {
				Postagem::delete($paramId);

				echo '<script>alert("Publicação deletada com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			}
			
		}
		//logindaq

			public function createUser()
		{
			// Verifica se o usuário logado é admin
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('create_user.html');

			echo $template->render([]);
		}

		public function insertUser()
		{
			// Verifica se o usuário logado é admin
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			try {
				$email = $_POST['email'] ?? '';
				$senha = $_POST['senha'] ?? '';
				$tipo = $_POST['tipo'] ?? '';

				if (empty($email) || empty($senha) || empty($tipo)) {
					throw new Exception("Todos os campos são obrigatórios.");
				}

				// Insere o usuário no banco de dados
				$con = Connection::getConn();
				$sql = "INSERT INTO usuarios (email, senha, tipo) VALUES (:email, :senha, :tipo)";
				$stmt = $con->prepare($sql);
				$stmt->bindValue(':email', $email);
				$stmt->bindValue(':senha', $senha); // Sem hash, como solicitado
				$stmt->bindValue(':tipo', $tipo);
				$stmt->execute();

				echo '<script>alert("Usuário cadastrado com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("' . $e->getMessage() . '");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=createUser"</script>';
			}
		}

		//manualdaq

		// Método para exibir a página de criação de manual
		public function createManual()
		{
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('create_manual.html');

			echo $template->render([]);
		}

		// Método para inserir um novo manual no banco de dados
		public function insertManual()
		{
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			try {
				Manual::insert($_POST);

				echo '<script>alert("Manual inserido com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("' . $e->getMessage() . '");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=createManual"</script>';
			}
		}

		// Método para exibir a página de edição de manual
		public function changeManual($id)
		{
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			$manual = Manual::selecionaPorId($id);

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('update_manual.html');

			$parametros = ['manual' => $manual];

			echo $template->render($parametros);
		}

		// Método para atualizar manual
		public function updateManual()
		{
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			try {
				Manual::update($_POST);

				echo '<script>alert("Manual alterado com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("' . $e->getMessage() . '");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=changeManual&id=' . $_POST['id'] . '"</script>';
			}
		}

		// Método para deletar manual
		public function deleteManual($id)
		{
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
				header('Location: http://localhost/siteleo/?pagina=login&metodo=index');
				exit;
			}

			try {
				Manual::delete($id);

				echo '<script>alert("Manual deletado com sucesso!");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("' . $e->getMessage() . '");</script>';
				echo '<script>location.href="http://localhost/siteleo/?pagina=admin&metodo=index"</script>';
			}
		}

	}