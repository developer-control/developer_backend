// Inisialisasi Choices.js
function initializeChoice(element, items) {
    const choices = new Choices(element, {
        searchEnabled: true, // Aktifkan fitur pencarian
        // placeholderValue: 'select one...', // Placeholder default
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Pick an Strokes record',
        maxItemCount: 5,
        searchPlaceholderValue: 'This is a search placeholder...'
    });
     choices.setChoices(items, 'value', 'label', true);
    // setInputChoices(choices, url);
    return choices;
}

async function setInputChoices(url) {
    // let items ;
    return fetch(url) // Ganti dengan endpoint backend Anda
        .then(response => response.json())
        .then(result => {
            // console.log(result);
            // Format data untuk Choices.js
             return result.data.map(item => ({
                value: item.id, // Value
                label: item.name // Label
            }));
        });
}