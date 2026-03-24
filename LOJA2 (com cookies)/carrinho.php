<?php
session_start();
 
error_reporting(E_ALL);
ini_set('display_errors', 1);
 
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
 
if (!isset($_SESSION["carrinho"])) {
    $_SESSION["carrinho"] = [];
}
 
// REMOVER
if (isset($_POST["remover"])) {
    $id = $_POST["remover"];
 
    if (isset($_SESSION["carrinho"][$id])) {
        $_SESSION["carrinho"][$id]--;
 
        if ($_SESSION["carrinho"][$id] <= 0) {
            unset($_SESSION["carrinho"][$id]);
        }
    }
 
    header("Location: carrinho.php");
    exit();
}

$produtos = [
    1 => ['nome'=>'Pelúcia Kuromi','preco'=>120, 'imagem' => 'https://i.pinimg.com/736x/b4/0c/3d/b40c3d6c32f1d90a4b3cf1367fbf368e.jpg'],
    2 => ['nome'=>'Caneca My Melody','preco'=>60, 'imagem' => 'https://i.pinimg.com/736x/06/e8/56/06e8564cc164f1c31e564c5da74f6659.jpg'],
    3 => ['nome'=>'Mochila Hello Kitty','preco'=>180, 'imagem' => 'https://i.pinimg.com/736x/0b/0b/92/0b0b924df87eecb1861c0cd0541477d3.jpg']
];
 
$pedido_finalizado = false;
$itens_pedido = [];
$total_pedido = 0;

if (isset($_POST["finalizar"])) {
    foreach ($_SESSION["carrinho"] as $id => $quantidade) {
        if (isset($produtos[$id])) {
            $p = $produtos[$id];
            $itens_pedido[] = [
                'nome' => $p['nome'],
                'quantidade' => $quantidade,
                'preco' => $p['preco']
            ];
            $total_pedido += $p['preco'] * $quantidade;
        }
    }

    $_SESSION["carrinho"] = [];
    $pedido_finalizado = true;
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Carrinho - SIS STORE</title>
    <link rel="icon" href= SIS.STORE(3).png>
    <style>
        body { font-family: Arial; background:#f5e6ff; text-align:center; padding: 20px; }
        .item-carrinho {
            background: white;
            margin: 10px auto;
            padding: 15px;
            border-radius: 15px;
            width: 350px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .item-carrinho img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; }
        .total-box { font-size: 20px; font-weight: bold; color: #a64dff; margin: 20px; }
        .botao-remover {
            background-color: #ff8fa3; color: white; border: none;
            padding: 5px 10px; border-radius: 10px; cursor: pointer;
        }
        .btn-finalizar {
            background: #741570;
            color: white; border: none;
            padding: 15px 30px; border-radius: 25px;
            font-size: 18px; cursor: pointer; font-weight: bold;
        }
        .btn-finalizar:hover { background: #8c1280; }

        .pedido-box {
    background: white;
    padding: 25px;
    border-radius: 20px;
    width: 350px;
    margin: 20px auto;
    box-shadow: 0 6px 10px rgba(0,0,0,0.1);
}

.lista-itens {
    text-align: left;
    margin: 15px 0;
    font-size: 16px;
}

.lista-itens p {
    margin: 5px 0;
}

.btn-finalizar {
    display: inline-block;
    margin-top: 15px;
}

img {
        max-width: 100%;
        display: block;
        margin: auto;
        width: 15%;
    }

    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
<?php if ($pedido_finalizado): ?>

    <img src="LOGOSIS2.png" alt="SIS STORE">

    <div class="pedido-box">

    <h2>💜 Pedido Finalizado!</h2>
    <p>Obrigada pela sua compra na SIS STORE 🛍️✨</p>

    <div class="lista-itens">
        <?php foreach ($itens_pedido as $item): ?>
            <p>
                🧸 <strong><?php echo $item['nome']; ?></strong>
                (<?php echo $item['quantidade']; ?>x)
            </p>
        <?php endforeach; ?>
    </div>

    <div class="total-box">
        Total pago: R$ <?php echo $total_pedido; ?>
    </div>

</div>

    <br>
    <a href="dashboard.php" class="btn-finalizar">Voltar para loja</a>

<?php else: ?>
 
<h2>🛒 Seu Carrinho</h2>
 
<?php
$total = 0;
 
if (empty($_SESSION["carrinho"])) {
    echo "<p>O carrinho está vazio!</p>";
} else {
    foreach ($_SESSION["carrinho"] as $id => $quantidade) {
        if (isset($produtos[$id])) {
            $p = $produtos[$id];
            $total += $p['preco'] * $quantidade;
            ?>
            <div class="item-carrinho">
                <img src="<?php echo $p['imagem']; ?>">
                <div>
                    <strong><?php echo $p['nome']; ?></strong><br>
                    Qtd: <?php echo $quantidade; ?><br>
                    R$ <?php echo $p['preco']; ?>
                </div>
                <form method="post">
                    <input type="hidden" name="remover" value="<?php echo $id; ?>">
                    <button type="submit" class="botao-remover">❌</button>
                </form>
            </div>
            <?php
        }
    }
    echo "<div class='total-box'>Total: R$ " . $total . "</div>";
    ?>
   
    <form method="post">
        <button type="submit" name="finalizar" class="btn-finalizar">
    💜 Finalizar Pedido
</button>
    </form>
<?php } ?>

<?php endif; ?>
 
<?php if (!$pedido_finalizado): ?>
<br>
<a href="dashboard.php" style="color: #a64dff; text-decoration: none; font-weight: bold;">
⬅ Voltar para a loja
</a>

<?php endif; ?>

</body>
</html>