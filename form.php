<?php
function validate(array $d): array {
    $errors = [];
    if (trim($d['guest_name'] ?? '') === '') $errors[] = 'Guest name is required.';
    if (!filter_var($d['email'] ?? '', FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (!in_array($d['room_type'] ?? '', ['Single', 'Double', 'Suite'])) $errors[] = 'Invalid room type.';
    if (($d['guests'] ?? 0) < 1) $errors[] = 'Guests must be at least 1.';
    if (empty($d['check_in']) || empty($d['check_out'])) $errors[] = 'Dates are required.';
    elseif ($d['check_out'] <= $d['check_in']) $errors[] = 'Check-out must be after check-in.';
    if (!in_array($d['status'] ?? '', ['Pending', 'Confirmed', 'Cancelled'])) $errors[] = 'Invalid status.';
    return $errors;
}

function render_form(array $b, array $errors, string $button) { ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><ul class="mb-0">
            <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form method="POST" class="card card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Guest Name</label>
                <input type="text" name="guest_name" class="form-control" value="<?= e($b['guest_name']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= e($b['email']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Room Type</label>
                <select name="room_type" class="form-select">
                    <?php foreach (['Single', 'Double', 'Suite'] as $t): ?>
                        <option <?= $b['room_type'] === $t ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Guests</label>
                <input type="number" name="guests" min="1" class="form-control" value="<?= e($b['guests']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Check-in</label>
                <input type="date" name="check_in" class="form-control" value="<?= e($b['check_in']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Check-out</label>
                <input type="date" name="check_out" class="form-control" value="<?= e($b['check_out']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php foreach (['Pending', 'Confirmed', 'Cancelled'] as $s): ?>
                        <option <?= $b['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-success"><?= e($button) ?></button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
<?php }

function page_start(string $title) { ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= e($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container"><a class="navbar-brand" href="index.php">🏨 Hotel Booking</a></div>
</nav>
<div class="container">
<?php }

function page_end() { ?>
</div></body></html>
<?php }