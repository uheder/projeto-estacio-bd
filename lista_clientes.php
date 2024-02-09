<?php

define('HOST', 'localhost');
define('DBNAME', 'cliente');
define('USER', 'root');
define('PASS', '');

$dsn = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USER, PASS);
$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista Clientes</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container"></div>
  <h2>Tabela de Clientes</h2>
    <table class="table table-bordered table-hover table-responsive w-100">
    <thead>
      <!-- table heads titulos -->
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">CPF</th>
        <th scope="col">Email</th>
        <th scope="col">Data de Nascimento</th>
      </tr>
    </thead>
      <tbody>
      <?php
      // monta a tabela com dados cadastrados
        try {
          $stmt = $dsn->query("SELECT * FROM cliente");
          while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";
          }
        } catch (PDOException $e) {
            echo 'Erro na consulta: ' . $e->getMessage();
            exit();
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
