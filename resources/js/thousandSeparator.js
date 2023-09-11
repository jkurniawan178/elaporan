//------------------------------------------------------------------------------------------
//--------------------------function that handle thosand separator--------------------------

// Function to remove Indonesian thousand separators
function removeThousandSeparator(formattedNumber) {
	return formattedNumber.replace(/\./g, "");
}

// Function to add Indonesian thousand separators
function addThousandSeparator(number) {
	if (number == null || number == "0") {
		return "-";
	} else {
		let rawNumber = number.toString().replace(/,|\.00$/g, "");
		return rawNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}
	// return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Function to format the input value
function formatInputValue(inputElement) {
	// Get the current input value without dots
	let inputValue = removeThousandSeparator(inputElement.value);

	// Convert the value to a number (removes leading zeros, etc.)
	let number = parseFloat(inputValue);

	// Check if the value is a valid number
	if (!isNaN(number)) {
		// Format the number with Indonesian thousand separators and display it
		inputElement.value = addThousandSeparator(number);
	}
}
