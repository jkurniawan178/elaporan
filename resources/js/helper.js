//fungsi pilih pihak
function pilihPihak(alur, jenis, pihak) {
	if (alur == "16" || jenis == "346" || jenis == "341") {
		switch (pihak) {
			case "p":
				return "Pemohon";
				break;
			case "kp":
				return "Kuasa Pemohon";
				break;
			case "t":
				return "Termohon";
				break;
			case "kt":
				return "Kuasa Termohon";
				break;
			default:
				return "Lainnya";
				break;
		}
	} else {
		switch (pihak) {
			case "p":
				return "Penggugat";
				break;
			case "kp":
				return "Kuasa Penggugat";
				break;
			case "t":
				return "Tergugat";
				break;
			case "kt":
				return "Kuasa Tergugat";
				break;
			default:
				return "Lainnya";
				break;
		}
	}
}
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

function jenisDelegasi(kodeDelegasi) {
	switch (kodeDelegasi) {
		case "1":
			return "Panggilan";
			break;
		case "2":
			return "Pemberitahuan";
			break;
		case "3":
			return "Pbt Akta Bdg";
			break;
		case "4":
			return "Pbt Mem Bdg";
			break;
		case "5":
			return "Pbt Inz Bdg";
			break;
		case "6":
			return "Pbt Put Bdg";
			break;
		case "7":
			return "Pbt Akta Kas";
			break;
		case "8":
			return "Pbt Mem Kas";
			break;
		case "9":
			return "Pbt Kon Mem Kas";
			break;
		case "10":
			return "Pbt Put Kas";
			break;
		case "11":
			return "Pbt Akta PK";
			break;
		case "12":
			return "Pbt Mem PK";
			break;
		case "13":
			return "Pbt Kon Mem PK";
			break;
		case "14":
			return "Pbt Put PK";
			break;
		case "15":
			return "Lain-Lain";
			break;
		case "16":
			return "Pbt Kon Mem Bdg";
			break;
		case "17":
			return "Penawaran Konsinyasi";
			break;
		default:
			return "";
			break;
	}
}
