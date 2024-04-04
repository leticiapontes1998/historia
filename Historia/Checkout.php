<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
  <h2 class="mb-4">Checkout</h2>
  <div class="row">
    <div class="col-md-6">
      <form action="salvar.php" method="post">
        <!-- Dados do Carrinho -->
        <div class="form-group">
          <label for="nome_livro">Nome do Livro:</label>
          <input type="text" class="form-control" name="nome_livro" placeholder="Digite o nome do livro" required>
        </div>
        <div class="form-group">
          <label for="preco">Preço:</label>
          <input type="text" class="form-control" name="nome_preco" placeholder="Digite o preço" required>
        </div>
        <div class="form-group">
          <label for="quantidade">Quantidade:</label>
          <input type="text" class="form-control" name="nome_quantidade" placeholder="Digite a quantidade" required>
        </div>
        <div class="form-group">
          <label for="total_pagar">Valor total:</label>
          <input type="text" class="form-control" name="total_pagar" readonly>
        </div>


        <script>

          
          document.addEventListener('DOMContentLoaded', function () {
            // Adiciona eventos de mudança nos campos de preço e quantidade
            document.getElementById('preco').addEventListener('input', calcularTotal);
            document.getElementById('quantidade').addEventListener('input', calcularTotal);

            // Função para calcular o valor total
            function calcularTotal() {
              var preco = parseFloat(document.getElementById('preco').value) || 0;
              var quantidade = parseInt(document.getElementById('quantidade').value) || 0;
              var total = preco * quantidade;

              // Atualiza o campo total_pagar
              document.getElementById('total_pagar').value = total.toFixed(2);
            }
          });
        </script>
      </form>
    </div>

    <!-- Formulário de Informações do Cliente e Pagamento -->
    <div class="col-md-6">
      <form action="salvar.php" method="post">
        <div class="form-group">
          <label for="fullName">Nome Completo</label>
          <input type="text" class="form-control" id="fullName" name="nome_cliente" placeholder="Digite seu nome completo" required>
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" class="form-control" id="email" name="nome_email" placeholder="Digite seu e-mail" required>
        </div>
        <div class="form-group">
          <label for="address">Endereço</label>
          <input type="text" class="form-control" id="address" name="nome_endereco" placeholder="Digite seu endereço" required>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="city">Cidade</label>
            <input type="text" class="form-control" id="city" name="nome_cidade" placeholder="Digite sua cidade" required>
          </div>
          <div class="form-group col-md-6">
            <label for="zipCode">CEP</label>
            <input type="text" class="form-control" id="zipCode" name="nome_CEP" placeholder="Digite seu CEP" required>
          </div>
        </div>
        <div class="form-group">
          <label for="paymentMethod">Método de Pagamento</label>
          <div class="form-check">
            <input type="radio" class="form-check-input" id="cashOnDelivery" name="paymentMethod" value="cash">
            <label class="form-check-label" for="cashOnDelivery">Pagamento na Entrega (Dinheiro)</label>
          </div>

          <div class="form-check">
            <input type="radio" class="form-check-input" id="pix" name="paymentMethod" value="pix">
            <label class="form-check-label" for="pix">PIX</label>
          </div>

          <div class="form-check">
            <input type="radio" class="form-check-input" id="card" name="paymentMethod" value="card">
            <label class="form-check-label" for="card">Cartão de Crédito</label>
          </div>

          <!-- Campos específicos para cartão -->
          <div id="cardFields" style="display: none;">
            <div class="form-group">
              <label for="cardNumber">Número do Cartão</label>
              <input type="text" class="form-control" id="cardNumber" placeholder="Digite o número do seu cartão">
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="expirationDate">Data de Expiração</label>
                <input type="text" class="form-control" id="expirationDate" placeholder="MM/AA">
              </div>
              <div class="form-group col-md-6">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" id="cvv" placeholder="Digite o CVV">
              </div>
            </div>
          </div>

          <!-- Campos específicos para PIX -->
          <div id="pixFields" style="display: none;">
            <div class="form-group">
              <label for="pixKey">Chave PIX</label>
              <input type="text" class="form-control" id="pixKey" placeholder="Digite sua chave PIX">
            </div>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-dark">Finalizar Compra</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var cardFields = document.getElementById('cardFields');
    var pixFields = document.getElementById('pixFields');
    var paymentMethodRadios = document.getElementsByName('paymentMethod');

    function handlePaymentMethodChange() {
      cardFields.style.display = 'none';
      pixFields.style.display = 'none';

      if (this.value === 'card') {
        cardFields.style.display = 'block';
      } else if (this.value === 'pix') {
        pixFields.style.display = 'block';
      }
    }

    // Adiciona o evento de mudança para os radios de método de pagamento
    paymentMethodRadios.forEach(function(radio) {
      radio.addEventListener('change', handlePaymentMethodChange);
    });
  });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Função para buscar o endereço pelo CEP
    function buscarEnderecoPorCEP(cep) {
      // Utilizando a API ViaCEP
      var apiUrl = 'https://viacep.com.br/ws/' + cep + '/json/';

      // Fazendo a requisição GET usando fetch
      fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
          // Preenchendo os campos com os dados do endereço
          document.getElementById('address').value = data.logradouro || '';
          document.getElementById('city').value = data.localidade || '';
        })
        .catch(error => console.error('Erro na requisição:', error));
    }

    // Evento de mudança no campo do CEP
    document.getElementById('zipCode').addEventListener('change', function() {
      var cep = this.value.replace(/\D/g, ''); // Removendo caracteres não numéricos

      if (cep.length === 8) {
        // Se o CEP tem o comprimento correto, busca o endereço
        buscarEnderecoPorCEP(cep);
      }
    });

    // Adicione aqui o restante do seu código JavaScript, se necessário
  });
</script>

</body>
</html>
