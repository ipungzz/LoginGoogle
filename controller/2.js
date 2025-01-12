var countdownInterval;

function startCountdown() {
    var countdownElement = document.getElementById("countdown");
    var now = new Date().getTime(); // Waktu sekarang
    var timeRemaining = endTime - now;

    if (timeRemaining <= 0) {
        countdownElement.innerHTML = "Kirim Ulang OTP";
        countdownElement.style.pointerEvents = "auto"; // Aktifkan klik
        return;
    }

    countdownElement.style.pointerEvents = "none"; // Nonaktifkan klik
    countdownInterval = setInterval(function () {
        now = new Date().getTime();
        timeRemaining = endTime - now;

        if (timeRemaining <= 0) {
            clearInterval(countdownInterval);
            countdownElement.innerHTML = "Kirim Ulang OTP";
            countdownElement.style.pointerEvents = "auto"; // Aktifkan klik
        } else {
            var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
            countdownElement.innerHTML = " ( " + minutes + "m " + seconds + "s )";
        }
    }, 1000);
}

function resetCountdown() {
    clearInterval(countdownInterval); // Hentikan countdown yang sedang berjalan

    // Kirim ulang OTP melalui Fetch API
    var nomer = document.getElementById("nomer").value;
    var pesan = document.getElementById("pesan").value;

    fetch('controller/1.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            nomer: nomer,
            pesan: pesan,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                alert('OTP dikirim ulang!');
                endTime = new Date().getTime() + 5 * 60 * 1000; // Update endTime menjadi 5 menit lagi
                startCountdown(); // Mulai countdown kembali
            } else {
                alert('Gagal mengirim ulang OTP: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Terjadi kesalahan:', error);
        });
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