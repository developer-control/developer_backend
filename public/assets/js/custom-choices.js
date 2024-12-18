// Inisialisasi Choices.js
function initializeChoice(element, items, id = null) {
    const choices = new Choices(element, {
        searchEnabled: true, // Aktifkan fitur pencarian
        // placeholderValue: 'select one...', // Placeholder default
        removeItemButton: true,
        placeholder: false,
        // placeholderValue: 'Pick an Strokes record',
        maxItemCount: 5,
        searchPlaceholderValue: 'This is a search placeholder...'
    });
    choices.clearChoices();
    choices.setChoices(items, 'value', 'label', true);
    choices.setChoiceByValue(id);
    // setInputChoices(choices, url);
    return choices;
}

function initializeChoiceInput(element) {
    const choices = new Choices(
        element,
        {
            allowHTML: true,
            delimiter: ',',
            editItems: true,
            duplicateItemsAllowed: false,
            removeItemButton: true,
            placeholderValue: 'please input tags here...',
        }
    );
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