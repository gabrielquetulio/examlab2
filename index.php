<?php
require 'db.php';
require 'form.php';

$bookings = $pdo->query('SELECT * FROM bookings ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

page_start('All Bookings');
?>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= e($_GET['msg']) ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between mb-3">
    <h3>All Bookings</h3>
    <a href="create.php" class="btn btn-primary">+ New Booking</a>
</div>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr><th>#</th><th>Guest</th><th>Email</th><th>Room</th><th>Guests</th>
            <th>Check-in</th><th>Check-out</th><th>Status</th><th width="150">Actions</th></tr>
    </thead>
    <tbody>
    <?php if (!$bookings): ?>
        <tr><td colspan="9" class="text-center">No bookings yet.</td></tr>
    <?php endif; ?>
    <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= e($b['guest_name']) ?></td>
            <td><?= e($b['email']) ?></td>
            <td><?= e($b['room_type']) ?></td>
            <td><?= $b['guests'] ?></td>
            <td><?= e($b['check_in']) ?></td>
            <td><?= e($b['check_out']) ?></td>
            <td><?= e($b['status']) ?></td>
            <td>
                <a href="edit.php?id=<?= $b['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $b['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this booking?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php page_end(); ?>