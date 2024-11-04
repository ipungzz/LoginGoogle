<?php
// Set waktu akhir countdown dalam detik dari sekarang (misalnya 1 menit = 60 detik)
$time_limit = 60; // Durasi waktu mundur (dalam detik)

// Mendapatkan waktu sekarang dalam format timestamp
$current_time = time();

// Menentukan waktu akhir countdown
$end_time = $current_time + $time_limit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Realtime</title>
</head>
<body>

<!-- Menampilkan countdown -->
<h1>Waktu Mundur: <span id="countdown"></span></h1>
<script src="controller/cd.js"></script>
<script>var endTime = <?php echo $end_time * 1000; ?>; // Convert to milliseconds</script>
<script>startCountdown();</script>
</body>
</html>