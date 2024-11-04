<?php
// Fungsi yang akan dipanggil
function sendwa($nosend,$pesand)
	{
        $url = "localhost:8080/postapi?";
        $key = "SIPALINGNT";
		global $conn;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url/postapi",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "nomer=$nosend&pesan=$pesand&key=$key",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded"
			),
		));
		curl_exec($curl);

		curl_close($curl);
		return mysqli_affected_rows($conn);

	};

// Mendapatkan data dari permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomer = isset($_POST['nomer']) ? $_POST['nomer'] : '';
    $pesan = isset($_POST['pesan']) ? $_POST['pesan'] : '';

    // Memanggil fungsi dan mengembalikan hasil
    $result = sendwa($nomer, $pesan);

    // Mengembalikan respons sebagai JSON
    echo json_encode(['status' => 'success', 'message' => $result]);
}
?>