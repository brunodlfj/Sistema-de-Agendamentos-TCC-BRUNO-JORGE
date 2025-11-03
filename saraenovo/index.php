<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarae IFFAR UG</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left-side img {
            width: 100%;
            max-width: 500px;
            height: auto;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .right-side form {
            display: flex;
            flex-direction: column;
            width: 80%;
        }

        .right-side label {
            margin-bottom: 5px;
        }

        .right-side input[type="text"], 
        .right-side input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }

        .right-side input[type="submit"] {
            padding: 10px;
            background-color: #fff;
            color: #006400;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .right-side input[type="submit"]:hover {
            background-color: #eee;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }

        a:hover {
            text-decoration: underline;
        }

        .right-side .register,
        .right-side .forgot-password {
            margin-bottom: 20px;
        }

        .left-side {
            display: none;
        }

        .right-side {
            width: 100%;
            background-color: #046536;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        @media only screen and (min-width:600px) {
            .left-side {
                width: 70%;
                background-color: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .right-side {
                width: 30%;
            }
        }

        .alert {
            background-color: rgb(180, 46, 46);
            color: rgb(247, 247, 247);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
        }

        .alert-success {
            background-color: rgb(46, 180, 46);
            color: rgb(247, 247, 247);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
        }

    </style>
</head>
<link rel="shortcut icon" type="/image/png" href="img/iconejanela.png" />
<body>
    <div class="container">
        <!-- Left Side -->
        <div class="left-side">
            <div class="content">
                <img src="img/logoetexto.png" alt="Logo">
            </div>
        </div>

        <!-- Right Side -->
        <div class="right-side">
            <h1>Login</h1><br>
            
            <?php
            session_start();
            if (isset($_SESSION['erro'])) {
                echo '<div class="alert">' . $_SESSION['erro'] . '</div>';
                unset($_SESSION['erro']); // Limpa a mensagem de erro
            }

            if (isset($_SESSION['sucesso'])) {
                echo '<div class="alert-success">' . $_SESSION['sucesso'] . '</div>';
                unset($_SESSION['sucesso']); // Limpa a mensagem de sucesso
            }
            ?>

            <form action="login.php" method="POST">
                <p>Ainda não possui cadastro?</p>
                <a href="formulario-cadastro.php" class="register">Cadastre-se</a>

                <label for="cpf">Usuário</label>
                <input type="text" name="cpf" id="cpf" placeholder="CPF" required> 

                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required><br>

                <input type="submit" name="submit" value="Entrar"><br><br>

                <p>Esqueceu sua senha?</p>
                <a href="form-recuperar-senha.php" class="forgot-password">Recuperar conta</a>
            </form>
        </div>
    </div>
</body>

</html>
