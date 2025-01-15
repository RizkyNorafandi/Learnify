$(document).ready(function () {
	$("#loginForm").on("submit", function (e) {
		e.preventDefault(); // Mencegah form dari pengiriman default

		// Ambil data dari form
		const formData = $(this).serializeArray();

		// Konversi ke format JSON
		const jsonData = {};
		$.each(formData, function (index, field) {
			jsonData[field.name] = field.value;
		});

		// Validasi dasar
		if (!jsonData.email || !jsonData.password) {
			alert("Email dan password harus diisi.");
			return;
		}

		// Tampilkan indikator loading
		$("#loading-indicator").removeClass("hidden");

		// Kirim data ke server
		$.ajax({
			url: `${baseUrl}Api/auth/login`, // Ganti dengan URL endpoint login
			type: "POST",
			contentType: "application/json",
			data: JSON.stringify(jsonData), // Pastikan data dikirim dalam format JSON
			success: function (response) {
				$("#loading-indicator").addClass("hidden"); // Sembunyikan indikator loading
				if (response.status) {
					alert("Login berhasil!"); // Tindakan setelah login berhasil
					// Redirect atau lakukan tindakan lain
				} else {
					// Tampilkan pesan kesalahan
					$("#error-message").removeClass("hidden").html(response.message);
				}
			},
			error: function (xhr, status, error) {
				$("#loading-indicator").addClass("hidden"); // Sembunyikan indikator loading
				$("#error-message")
					.removeClass("hidden")
					.text("Terjadi kesalahan: " + xhr.responseText);
			},
		});
	});
});
