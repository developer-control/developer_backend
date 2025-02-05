function initalizeNumericInput(element) {
    return new AutoNumeric(element, {
        digitGroupSeparator: ',',
        decimalCharacter: '.',
        currencySymbol: 'Rp ',
        unformatOnSubmit: true // Auto mengubah nilai saat submit
    });
}