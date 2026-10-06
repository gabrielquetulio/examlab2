<?php
require 'db.php';
require 'form.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM bookings WHERE id = ?');
$stmt->execute([$id]);
$b = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$b) { die('Booking not found.'); }
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $b = array_merge($b, $_POST);
    $errors = validate($b);

    if (!$errors) {
        $stmt = $pdo->prepare(
            'UPDATE bookings SET guest_name=?, email=?, room_type=?, guests=?,
             check_in=?, check_out=?, status=? WHERE id=?'
        );
        $stmt->execute([$b['guest_name'], $b['email'], $b['room_type'],
                        $b['guests'], $b['check_in'], $b['check_out'], $b['status'], $id]);
        header('Location: index.php?msg=' . urlencode('Booking updated!'));
        exit;
    }
}

page_start('Edit Booking');
echo '<h3>Edit Booking #' . $id . '</h3>';
render_form($b, $errors, 'Update');
page_end();