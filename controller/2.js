function startCountdown() {
    var countdownElement = document.getElementById("countdown");
    var nomer = document.getElementById("nomer").value;
    var pesan = document.getElementById("pesan").value;
    // Update setiap 1 detik (1000 ms)
    var countdownInterval = setInterval(function() {
        // Mendapatkan waktu sekarang
        var now = new Date().getTime();

        // Menghitung selisih waktu antara sekarang dan waktu akhir
        var timeRemaining = endTime - now;

        // Menghitung menit dan detik yang tersisa
        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        // Menampilkan waktu mundur dalam format menit:detik
        countdownElement.innerHTML = "Dalam " + minutes + "m " + seconds + "s ";

        // Jika waktu sudah habis
        if (timeRemaining < 0) {
            clearInterval(countdownInterval);
            countdownElement.innerHTML = '<a href="#" onclick="sendOTP(\'' + nomer + '\', \'' + pesan + '\'); return false;"> Click Here</a>';
        }
    }, 1000); // Update tiap 1 detik
}

function sendOTP(nomer,pesan) {

    fetch('controller/1.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'nomer': nomer,
            'pesan': pesan
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message); // Menampilkan pesan dari PHP
        } else {
            alert('Terjadi kesalahan: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Terjadi kesalahan:', error);
    });
}