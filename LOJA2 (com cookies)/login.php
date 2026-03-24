<?php
session_start();
 
// Corrige problema de dados antigos (string em vez de array)
if (isset($_SESSION['usuarios_cadastrados'])) {
    foreach ($_SESSION['usuarios_cadastrados'] as $email => $dados) {
        if (!is_array($dados)) {
            unset($_SESSION['usuarios_cadastrados'][$email]);
        }
    }
} else {
    $_SESSION['usuarios_cadastrados'] = [];
}
 
$mensagem = "";
$tipo_form = (isset($_GET['modo']) && $_GET['modo'] == 'cadastro') ? 'cadastro' : 'login';
$email_cookie = $_COOKIE['email_lembrado'] ?? "";
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $email = htmlspecialchars($_POST['email']);
    $senha = $_POST['senha'];
 
    // LOGIN
    if ($_POST['acao'] == 'login') {
 
        if (
            isset($_SESSION['usuarios_cadastrados'][$email]) &&
            is_array($_SESSION['usuarios_cadastrados'][$email]) &&
            password_verify($senha, $_SESSION['usuarios_cadastrados'][$email]['senha'])
        ) {
 
            if (isset($_POST['lembrar'])) {
                setcookie("email_lembrado", $email, time() + (30 * 24 * 60 * 60), "/");
            } else {
                setcookie("email_lembrado", "", time() - 3600, "/");
            }
 
            $_SESSION['usuario'] = $_SESSION['usuarios_cadastrados'][$email]['nome'];
 
            header("Location: dashboard.php");
            exit();
 
        } else {
            $mensagem = "<p class='erro'>E-mail ou senha incorretos!</p>";
        }
    }
 
    // CADASTRO
    if ($_POST['acao'] == 'cadastrar') {
 
        $nome = htmlspecialchars($_POST['nome']);
 
        if (isset($_SESSION['usuarios_cadastrados'][$email])) {
 
            $mensagem = "<p class='erro'>Este e-mail já está cadastrado!</p>";
            $tipo_form = 'cadastro';
 
        } else {
 
            $_SESSION['usuarios_cadastrados'][$email] = [
                'nome' => $nome,
                'senha' => password_hash($senha, PASSWORD_DEFAULT)
            ];
 
            $mensagem = "<p class='sucesso'>Conta criada! Faça login.</p>";
            $tipo_form = 'login';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS STORE</title>
    <link rel="icon" href= SIS.STORE(3).png>
    <style>
        * { box-sizing: border-box; }
       
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e6ccff, #f5e6ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
 
        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 350px;
        }
 
        img {
            max-width: 100%;
        }
 
        .campo-texto {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 16px;
            outline-color: #a64dff;
        }
 
        button {
            background: #a64dff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            margin-top: 10px;
            font-size: 16px;
            transition: 0.3s;
        }
 
        button:hover { background: #8a2be2; }
 
        .erro { color: #ff4d4d; font-size: 14px; }
        .sucesso { color: #2ecc71; font-size: 14px; }
 
        .lembrar-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 10px 0;
            font-size: 14px;
        }
 
        input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
            width: auto;
        }
 
        .toggle-link { margin-top: 20px; font-size: 14px; }
        .toggle-link a { color: #a64dff; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
 
<div class="container">
    <img src="LOGOSIS.png" alt="SIS STORE">

    <?php echo $mensagem; ?>
 
    <?php if ($tipo_form == 'login'): ?>
        <form method="post">
            <input type="hidden" name="acao" value="login">
            <input type="email" name="email" class="campo-texto" placeholder="E-mail" value="<?php echo htmlspecialchars($email_cookie); ?>" required>
            <input type="password" name="senha" class="campo-texto" placeholder="Senha" required>
           
            <div class="lembrar-container">
                <input type="checkbox" name="lembrar" id="lembrar" <?php echo $email_cookie ? "checked" : ""; ?>>
                <label for="lembrar">Lembre-me</label>
            </div>
 
            <button type="submit">ENTRAR</button>
        </form>
        <div class="toggle-link">
            Não tem conta? <a href="?modo=cadastro">Cadastre-se</a>
        </div>
 
    <?php else: ?>
        <form method="post">
            <input type="hidden" name="acao" value="cadastrar">
            <input type="text" name="nome" class="campo-texto" placeholder="Nome Completo" required>
            <input type="email" name="email" class="campo-texto" placeholder="E-mail" required>
            <input type="password" name="senha" class="campo-texto" placeholder="Crie uma Senha" required>
            <button type="submit">CRIAR CONTA</button>
        </form>
        <div class="toggle-link">
            Já tem conta? <a href="?modo=login">Fazer Login</a>
        </div>
    <?php endif; ?>
</div>
 
</body>
</html>