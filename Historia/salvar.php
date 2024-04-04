<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o banco de dados (substitua as credenciais conforme necessário)
    $conn = mysqli_connect("localhost", "root", "root", "livraria");

    // Verifica se a conexão foi estabelecida com sucesso
    if (!$conn) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    // Verificação de valores antes da inserção
    if (isset($_POST['nome_livro'], $_POST['nome_preco'], $_POST['nome_quantidade'], $_POST['total_pagar'], $_POST['nome_cliente'], $_POST['nome_email'], $_POST['nome_endereco'], $_POST['nome_cidade'], $_POST['nome_CEP'], $_POST['paymentMethod'])) {

        // Dados do carrinho
        $nomeLivro = mysqli_real_escape_string($conn, $_POST['nome_livro']);
        $preco = mysqli_real_escape_string($conn, $_POST['nome_preco']);
        $quantidade = mysqli_real_escape_string($conn, $_POST['nome_quantidade']);
        $total = $preco * $quantidade;

        // Inserção na tabela Carrinho usando instruções preparadas
        $queryCarrinho = "INSERT INTO Carrinho (Nome_do_Livro, Preco, Quantidade, Total) VALUES (?, ?, ?, ?)";
        $stmtCarrinho = mysqli_prepare($conn, $queryCarrinho);
        mysqli_stmt_bind_param($stmtCarrinho, 'sssd', $nomeLivro, $preco, $quantidade, $total);

        if (mysqli_stmt_execute($stmtCarrinho)) {
            // Inserção bem-sucedida
        } else {
            echo "Erro na inserção Carrinho: " . mysqli_stmt_error($stmtCarrinho);
        }
        mysqli_stmt_close($stmtCarrinho);

        // Dados do checkout
        $nomeCliente = mysqli_real_escape_string($conn, $_POST['nome_cliente']);
        $email = mysqli_real_escape_string($conn, $_POST['nome_email']);
        $endereco = mysqli_real_escape_string($conn, $_POST['nome_endereco']);
        $cidade = mysqli_real_escape_string($conn, $_POST['nome_cidade']);
        $cep = mysqli_real_escape_string($conn, $_POST['nome_CEP']);
        $metodoPagamento = mysqli_real_escape_string($conn, $_POST['paymentMethod']);

        // Inserção na tabela Checkout usando instruções preparadas
        $queryCheckout = "INSERT INTO Checkout (Nome, Email, Endereco, Cidade, CEP, Metodo_de_Pagamento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtCheckout = mysqli_prepare($conn, $queryCheckout);
        mysqli_stmt_bind_param($stmtCheckout, 'ssssss', $nomeCliente, $email, $endereco, $cidade, $cep, $metodoPagamento);

        if (mysqli_stmt_execute($stmtCheckout)) {
            // Inserção bem-sucedida
        } else {
            echo "Erro na inserção Checkout: " . mysqli_stmt_error($stmtCheckout);
        }
        mysqli_stmt_close($stmtCheckout);

        // Dados do total da compra
        $totalPagar = mysqli_real_escape_string($conn, $_POST['total_pagar']);

        // Inserção na tabela TotalCompra usando instruções preparadas
        $queryTotalCompra = "INSERT INTO TotalCompra (Nome_do_Cliente, Total_a_Pagar) VALUES (?, ?)";
        $stmtTotalCompra = mysqli_prepare($conn, $queryTotalCompra);
        mysqli_stmt_bind_param($stmtTotalCompra, 'ss', $nomeCliente, $totalPagar);

        if (mysqli_stmt_execute($stmtTotalCompra)) {
            // Inserção bem-sucedida
        } else {
            echo "Erro na inserção TotalCompra: " . mysqli_stmt_error($stmtTotalCompra);
        }
        mysqli_stmt_close($stmtTotalCompra);

    } else {
        // Campos faltando, talvez redirecione ou exiba uma mensagem de erro
        echo "Campos do formulário incompletos.";
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
}
?>
