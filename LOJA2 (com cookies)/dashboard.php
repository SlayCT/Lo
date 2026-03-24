 <?php
session_start();
 
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
 
$produtos = [
    ['id'=>1, 'nome'=>'Pelúcia Kuromi', 'preco'=>120, 'imagem'=>'https://i.pinimg.com/736x/b4/0c/3d/b40c3d6c32f1d90a4b3cf1367fbf368e.jpg'],
    ['id'=>2, 'nome'=>'Pelúcia Pompompurin', 'preco'=>120, 'imagem'=>'https://http2.mlstatic.com/D_NQ_NP_2X_814804-MLB76857939480_062024-F.webp'],
    ['id'=>3, 'nome'=>'Pelúcia Hello Kitty', 'preco'=>120, 'imagem'=>'https://cdn.awsli.com.br/2500x2500/2625/2625744/produto/352614999/d8edb187e72013e4dc5e898b574f0751-0e3qot5oi7.jpg'],
    ['id'=>4, 'nome'=>'Caneca My Melody', 'preco'=>60, 'imagem'=>'https://i.pinimg.com/736x/06/e8/56/06e8564cc164f1c31e564c5da74f6659.jpg'],
    ['id'=>5, 'nome'=>'Caneca Pompompurin', 'preco'=>60, 'imagem'=>'https://tse4.mm.bing.net/th/id/OIP.UlxmVEC9pQvGhxemPG9kTgHaHa?w=1024&h=1024&rs=1&pid=ImgDetMain&o=7&rm=3'],
    ['id'=>6, 'nome'=>'Mochila Hello Kitty', 'preco'=>180, 'imagem'=>'https://i.pinimg.com/736x/0b/0b/92/0b0b924df87eecb1861c0cd0541477d3.jpg'],
    ['id'=>7, 'nome'=>'Mochila Pompompurin', 'preco'=>180, 'imagem'=>'https://tse2.mm.bing.net/th/id/OIP.96TqV-UXrf2V9ITWOkpR1gHaHS?rs=1&pid=ImgDetMain&o=7&rm=3'],
    ['id'=>8, 'nome'=>'Mochila Kuromi', 'preco'=>180, 'imagem'=>'https://tse2.mm.bing.net/th/id/OIP.vdYA6c1z_qxYXtmeNPevLwHaHa?w=640&h=640&rs=1&pid=ImgDetMain&o=7&rm=3'],
    ['id'=>9, 'nome'=>'Mochila Cinnamon Roll', 'preco'=>180, 'imagem'=>'https://down-br.img.susercontent.com/file/sg-11134201-7rbm9-lnzcnenabqjibf'],
    ['id'=>10, 'nome'=>'Caneca Hello Kitty', 'preco'=>60, 'imagem'=>'https://down-tw.img.susercontent.com/file/be057d7acd4e76c28caa7888529838e5']
    
];
 
if (isset($_GET['comprar'])) {
 
    $id = (int) $_GET['comprar'];
 
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
 
   
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] += 1;
    } else {
        $_SESSION['carrinho'][$id] = 1;
    }
 
    header("Location: carrinho.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>SIS STORE</title>
<link rel="icon" href="SIS.STORE(3).png">
<style>

    body{
    font-family: Arial;
    background:#f5e6ff;
    text-align:center;
}

img {
    max-width: 100%;
    display: block;
    margin: auto;
    width: 15%;
}

.container-produtos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.produto{
    background:white;
    margin:15px;
    padding:15px;
    border-radius:15px;
    width:250px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.produto img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

button {
    color:black;
    border:none;
    padding:15px 48px;
    border-radius:30px;
    cursor:pointer;
    background: linear-gradient(90deg, #ff4fa3 , #d896ff);
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    font-weight:bold;
}

button:hover {
    transform: scale(1.05);
    opacity:0.9;
}

a{
    display:block;
    margin-top:10px;
}
h2{
    color:#a64dff;
    font-size: 36px;
    margin-bottom: 10px;
}

h3{
    font-size: 26px;
    margin-bottom: 20px;
}

.logo {
    width: 22%;
    max-width: 220px;
}

@media (max-width: 600px) {

    .container-produtos {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .produto {
        width: 90%;
        max-width: 320px;
        margin: 0;
    }

    .logo {
        width: 70%;
        max-width: 280px;
    }

    h2 {
        font-size: 34px;
    }

    h3 {
        font-size: 26px;
    }

    button {
        width: 100%;
        padding: 15px;
        font-size: 16px;
    }
}


</style>
</head>
<body>
 
<h2>💜 Olá, <?php echo $_SESSION['usuario']; ?></h2>
<h3>🛍️ Nossos produtos 🛍️</h3>
<img src="LOGOSIS2.png" class="logo" alt="SIS STORE">
 
<div class="container-produtos">
<?php foreach($produtos as $p){ ?>
<div class="produto">
    <img src="<?php echo $p['imagem']; ?>" alt="<?php echo $p['nome']; ?>">
   
    <p><strong><?php echo $p['nome']; ?></strong></p>
    <p>R$ <?php echo $p['preco']; ?></p>
    <a href="?comprar=<?php echo $p['id']; ?>">
        <button>Comprar</button>
    </a>
</div>
<?php } ?>
</div>
 
<div style="margin-top: 30px;">
    <a href="carrinho.php" style="color: #a64dff; text-decoration: none; font-weight: bold;">Ver Carrinho 🛒</a>
    <a href="login.php" style="color: #a64dff; text-decoration: none; font-weight: bold;">Sair</a>
</div>
 
</body>
</html>
