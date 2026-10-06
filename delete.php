<?php
require 'db.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('DELETE FROM bookings WHERE id = ?');
$stmt->execute([$id]);

header('Location: index.php?msg=' . urlencode('Booking deleted!'));
exit;