<?php include ("../global/header.php");
include __DIR__ . "/../conexao.php";
require __DIR__ . "/../login/auth.php";

$usuario_id = $_SESSION['usuario_id'];
// Buscar dados do usuário
$sql = "SELECT foto FROM login WHERE id = $usuario_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();


$mensagem = ''; // texto da notificação
$tipo = '';     // tipo da notificação (success, info, error)

if (isset($_SESSION['mensagem'])) {
  $mensagem = $_SESSION['mensagem'];
  $tipo = $_SESSION['tipo'] ?? 'success';
  unset($_SESSION['mensagem']); // remove a mensagem após exibir
  unset($_SESSION['tipo']);
}

// Atualizar a foto de perfil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto"])) {
  $arquivo = $_FILES["foto"];

  if ($arquivo["error"] == 0) {
      $ext = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
      $novo_nome = "user_" . $usuario_id . "." . $ext; // nome único por usuário
      $destino = __DIR__ . "/../uploads/" . $novo_nome;

      // Move para a pasta uploads
      if (move_uploaded_file($arquivo["tmp_name"], $destino)) {
        // Define a mensagem
        if (empty($user['foto'])) {
          $_SESSION['mensagem'] = "Foto salva com sucesso!";
        } else {
          $_SESSION['mensagem'] = "Foto atualizada com sucesso!";
        }
        $_SESSION['tipo'] = "success";

        // Atualiza no banco
        $sqlUpdate = "UPDATE login SET foto = '$novo_nome' WHERE id = $usuario_id";
        $conn->query($sqlUpdate);

        $user['foto'] = $novo_nome;
        // REDIRECIONA para a mesma página para evitar resubmissão
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

      } else {
        $_SESSION['mensagem'] = "Erro ao enviar a foto!";
        $_SESSION['tipo'] = "error";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
      }
  }
}


$sql = "SELECT nome, sobrenome, email, foto FROM login WHERE id = $usuario_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Atualizar dados do perfil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar_dados'])) {
    $nome = $conn->real_escape_string($_POST['nome']);
    $sobrenome = $conn->real_escape_string($_POST['sobrenome']);
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];

    // Se o usuário digitou uma nova senha, criptografa
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE login SET nome='$nome', sobrenome='$sobrenome', email='$email', senha='$senhaHash' WHERE id=$usuario_id";
    } else {
        $sqlUpdate = "UPDATE login SET nome='$nome', sobrenome='$sobrenome', email='$email' WHERE id=$usuario_id";
    }

    if ($conn->query($sqlUpdate)) {
        $_SESSION['mensagem'] = "Dados atualizados com sucesso!";
        $_SESSION['tipo'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar os dados!";
        $_SESSION['tipo'] = "error";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<link rel="stylesheet" href="../src/css/perfil.css">

<div id="toast" class="<?= $tipo ?>" style="display:none;">
    <?= $mensagem ?>
</div>

<div class="container">
    <h2>Escolha sua foto de perfil para mostrar para os usuários!!</h2>

    <form method="POST" enctype="multipart/form-data">
      <label for="file-upload" class="profile-pic">
        <?php if (!empty($user['foto'])): ?>
          <img id="preview" src="../uploads/<?= $user['foto'] ?>" alt="Foto de perfil">
        <?php else: ?>
          <i class="fa-solid fa-user"></i>
          <img id="preview" src="" alt="" style="display:none;">
        <?php endif; ?>
      </label>
      <input type="file" id="file-upload" name="foto" accept="image/*">
      <br>
      <button type="submit">Salvar Foto</button>
    </form>

    <hr>

    <!-- Alterar Dados -->
    <form method="POST" class="form-dados">
      <label>Nome:</label>
      <input type="text" name="nome" value="<?= htmlspecialchars($user['nome']) ?>" required><br>

      <label>Sobrenome:</label>
      <input type="text" name="sobrenome" value="<?= htmlspecialchars($user['sobrenome']) ?>" required><br>

      <label>Email:</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

      <label>Nova Senha (deixe em branco se não quiser alterar):</label>
      <div class="senha-container">
        <input type="password" name="senha" id="senha">
        <span class="toggle-senha" onclick="toggleSenha()">
          <i class="fa-solid fa-eye"></i>
        </span>
      </div>

      <button type="submit" name="atualizar_dados">Salvar Alterações</button>
    </form>

</div>

<script src="../src/js/perfil.js"></script>

<?php include ("../global/footer.php") ?>