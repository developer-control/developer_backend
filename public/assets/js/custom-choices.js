// Inisialisasi Choices.js
function initializeChoice(element, url) {
    const choices = new Choices(element, {
        searchEnabled: true, // Aktifkan fitur pencarian
        placeholder: false,
        placeholderValue: 'select one...', // Placeholder default
        searchPlaceholderValue: 'This is a search placeholder...'
    });
    setInputChoices(choices, url);
    return choices;
}

function setInputChoices(choices, url, id = null) {
    fetch(url) // Ganti dengan endpoint backend Anda
        .then(response => response.json())
        .then(result => {
            // console.log(result);
            // Format data untuk Choices.js
            const items = result.data.map(item => ({
                value: item.id, // Value
                label: item.name // Label
            }));

            // Tambahkan opsi ke dropdown
            choices.setChoices(items, 'value', 'label', true);
            // set option untuk dropdown
            if (id) {
                choices.setChoiceByValue(id);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}