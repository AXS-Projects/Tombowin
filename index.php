<?php
$ticketFile = __DIR__ . '/data/tickets.json';
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

    <?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

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
