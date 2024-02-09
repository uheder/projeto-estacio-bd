<?php
// inicia os dados como vazios para alteração caso seja feito post
$nome = '';
$cpf = '';
$email = '';
$data_nascimento = '';

// altera os dados para os enviados
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $data_nascimento = date('Y-m-d H:i:s', strtotime($data_nascimento));
}

// aqui é feita a validação dos dados, retornando verdadeiro somente se todos os dados passarem
function validaDados($nome, $cpf, $email, $data_nascimento){
    if (empty($nome) || empty($cpf) || empty($email) || empty($data_nascimento)){
        return false;
    } elseif (strlen($nome) < 3 || strlen($nome) > 255) {
        echo "<p>Nome inválido</p>";
        return false;
    } elseif (strlen($cpf) != 11) {
        echo "<p>CPF inválido</p>";
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<p>Email inválido</p>";
        return false;
    } elseif (!isset($data_nascimento) || empty($data_nascimento)){
        return false;
    }
    return true;
}

// tudo validado, envia para o banco de dados

define('HOST', 'localhost');
define('DBNAME', 'cliente');
define('USER', 'root');
define('PASS', '');

try {
    if (validaDados($nome, $cpf, $email, $data_nascimento)){
        // header("Location: db_access.php");
        // exit;

    $dsn = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USER, PASS);
    $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // query insert
    $stmt = $dsn->prepare("INSERT INTO cliente (nome_cliente, cpf_cliente, email_cliente, data_nascimento_cliente) VALUES ( :nome, :cpf, :email, :data_nascimento)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->execute();  
    
    // $stmt->execute(array(':nome' => $nome, ':cpf' => $cpf, ':email' => $email, ':data_nascimento' => $data_nascimento));
    header("Location: lista_clientes.php");
    exit;
    } else{
        return '<p>Dados invalidos</p>';
    }
    // captura erro
} catch (PDOException $e) {
  echo '<p>Erro na conexão com o banco de dados: ' . $e->getMessage(). '</p><br>';
}