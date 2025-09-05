<?php
$logPath = __DIR__ . "/simulations/simulacao_emails.log";

if (!file_exists($logPath)) {
    echo "<h2 style='color:red;'>Aucun e-mail simulé pour le moment.</h2>";
    exit;
}


$conteudo = file_get_contents($logPath);
$conteudoFormatado = nl2br(htmlspecialchars($conteudo));

echo "<h2>📧 E-mails simulés</h2>";
echo "<pre style='background:#f4f4f4; padding:20px; border-radius:10px; font-family:monospace;'>$conteudoFormatado</pre>";
