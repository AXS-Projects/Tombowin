<?php
$ticketFile = __DIR__ . '/data/tickets.json';
$drawDate = date('c', strtotime('+1 week')); // data tombolei
if (!file_exists($ticketFile)) {
    file_put_contents($ticketFile, json_encode([]));
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 1);
    if ($name && $email && $quantity > 0) {
        $tickets = json_decode(file_get_contents($ticketFile), true);
        $tickets[] = [
            'name' => $name,
            'email' => $email,
            'quantity' => $quantity,
            'time' => date('c')
        ];
        file_put_contents($ticketFile, json_encode($tickets, JSON_PRETTY_PRINT));
        $message = 'Achiziție reușită! Mult succes!';
    } else {
        $message = 'Completați toate câmpurile!';
    }
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['message' => $message]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Tombowin</title>
    <link rel="stylesheet" href="public/assets/styles.css">
</head>
<body>
    <h1>Bine ați venit la Tombowin!</h1>
    <p>Cumpărați tichete pentru șansa de a câștiga premii precum mașini și telefoane.</p>
    <div id="countdown" data-end="<?= $drawDate ?>"></div>

    <?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <div id="ajax-message" class="message" style="display:none"></div>

    <form id="ticket-form" method="post" class="ticket-form">
        <label>Nume:
            <input type="text" name="name" required>
        </label>
        <label>Email:
            <input type="email" name="email" required>
        </label>
        <label>Număr tichete:
            <input type="number" name="quantity" min="1" value="1" required>
        </label>
        <button type="submit">Cumpără</button>
    </form>

    <script type="module" src="public/assets/main.js"></script>
</body>
</html>
