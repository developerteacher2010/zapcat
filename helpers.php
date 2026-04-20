<?php

// ❌ NÃO coloque include aqui dentro

function redirecionar($url) {
    header("Location: " . $url);
    exit;
}

function exigir_login_cliente() {
    if (!isset($_SESSION['empresa_id'])) {
        redirecionar("login.php");
    }
}

function empresa_logada($conn) {
    if (!isset($_SESSION['empresa_id'])) {
        return null;
    }

    $id = (int) $_SESSION['empresa_id'];

    $res = $conn->query("SELECT * FROM empresas WHERE id = $id LIMIT 1");

    if ($res && $res->num_rows > 0) {
        return $res->fetch_assoc();
    }

    return null;
}

function assinatura_ativa($empresa) {
    if (!$empresa) return false;

    if ($empresa['status'] !== 'ativo') return false;

    if (!empty($empresa['data_expiracao'])) {
        return strtotime($empresa['data_expiracao']) >= strtotime(date('Y-m-d'));
    }

    return true;
}

function acesso_liberado($empresa) {
    if (!$empresa) return false;

    if (isset($empresa['tipo_acesso'])) {
        if ($empresa['tipo_acesso'] === 'gratis' || $empresa['tipo_acesso'] === 'vip') {
            return true;
        }
    }

    return assinatura_ativa($empresa);
}

function e($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}