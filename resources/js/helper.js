//Fungsi pilih bulan
function pilihBulan(bulan) {
	switch (bulan) {
		case "01":
			return "Januari";
			break;
		case "02":
			return "Pebruari";
			break;
		case "03":
			return "Maret";
			break;
		case "04":
			return "April";
			break;
		case "05":
			return "Mei";
			break;
		case "06":
			return "Juni";
			break;
		case "07":
			return "Juli";
			break;
		case "08":
			return "Agustus";
			break;
		case "09":
			return "September";
			break;
		case "10":
			return "Oktober";
			break;
		case "11":
			return "Nopember";
			break;
		case "12":
			return "Desember";
			break;
		default:
			break;
	}
}

function formatDate(dateString) {
	if (
		dateString === null ||
		dateString === "" ||
		dateString === 0 ||
		dateString === "0000-00-00"
	) {
		return "-";
	} else {
		const date = new Date(dateString);
		const day = String(date.getDate()).padStart(2, "0");
		const month = String(date.getMonth() + 1).padStart(2, "0");
		const year = date.getFullYear();
		return `${day}/${month}/${year}`;
	}
}
