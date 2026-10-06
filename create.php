<?php
require 'db.php';
require 'form.php';

$b = ['guest_name' => '', 'email' => '', 'room_type' => 'Single', 'guests' => 1,
      'check_in' => '', 'check_out' => '', 'status' => 'Pending'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $b = array_merge($b, $_POST);
    $errors = validate($b);

    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO bookings (guest_name, email, room_type, guests, check_in, check_out, status)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$b['guest_name'], $b['email'], $b['room_type'],
                        $b['guests'], $b['check_in'], $b['check_out'], $b['status']]);
        header('Location: index.php?msg=' . urlencode('Booking created!'));
        exit;
    }
}

page_start('New Booking');
echo '<h3>New Booking</h3>';
render_form($b, $errors, 'Save');
page_end();