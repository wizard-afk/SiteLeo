<?php

class ErroController
{
    public function index()
    {
        // Exibe a página de erro com um layout bonito
        echo $this->erroPage();
    }

    private function erroPage()
    {
        return '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro - Página Não Encontrada</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    text-align: center;
                }
                .erro-container {
                    background-color: #fff;
                    padding: 40px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    max-width: 500px;
                    width: 100%;
                }
                .erro-container h1 {
                    font-size: 50px;
                    color: #e74c3c;
                    margin-bottom: 20px;
                }
                .erro-container p {
                    font-size: 18px;
                    margin-bottom: 20px;
                }
                .erro-container a {
                    text-decoration: none;
                    color: #4e2a84;
                    font-weight: bold;
                    font-size: 16px;
                    border: 2px solid #4e2a84;
                    padding: 10px 20px;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }
                .erro-container a:hover {
                    background-color: #4e2a84;
                    color: white;
                }
            </style>
        </head>
        <body>
            <div class="erro-container">
                <h1>404</h1>
                <p>Página Não Encontrada</p>
                <p>Desculpe, mas a página que você procurou não existe ou foi movida.</p>
                <a href="http://localhost/SiteLeo/index.php">Voltar para a Página Inicial</a>
            </div>
        </body>
        </html>
        ';
    }
}
