
// Const declarations.
const amountField = document.querySelector('#inputAmount');
const dateField = document.querySelector('#inputDate');
const categoryField = document.querySelector('#inputCategory');

const limitInfoBox = document.querySelector('#limit_info_box');
const limitValueBox = document.querySelector('#limit_value_box');
const limitLeftBox = document.querySelector('#limit_left_box');

const limitInfo = document.createElement('p');
const limitValue = document.createElement('p');
const limitLeft = document.createElement('p');

// Rendering alert boxes.
const renderInfoBox = (field, limit) => {
    if (!!limit) {
        limitInfo.innerText = `You set the limit ${limit} PLN monthly for that category.`;      
    } else {
        limitInfo.innerText = `The limit for this category has not been set.`;
    }

    field.appendChild(limitInfo);
}



// Events logic.
const eventsAction = async (category, date, amount) => {
    if (!!category) {
        const limitInfoData = await getLimitForCategory(category);
        renderInfoBox(limitInfoBox, limitInfoData);
        /*
        if (!!date) {
            const monthlyExpenses = await getMonthlyExpenses(category, date);
            renderValueBox(limitValueBox, monthlyExpenses);

            if (!!amount && !!limitInfoData) {
                renderLeftBox(limitLeftBox, limitInfoData, monthlyExpenses, amount);
                showBox(limitInfoBox);
                //showBox(limitValueBox);
                //showBox(limitLeftBox);
            } else {
                showBox(limitInfoBox)
                //showBox(limitValueBox);
                //limitLeftBox.classList.remove('visible');
            }
        } else {
            showBox(limitInfoBox);
            //limitValueBox.classList.remove('visible');
            //limitLeftBox.classList.remove('visible');
        }
        */
    } else {
        //limitInfoBox.classList.remove('visible');
        //limitValueBox.classList.remove('visible');
        //limitLeftBox.classList.remove('visible');
    }
}

// Async fetch funtcions.
const getLimitForCategory = async (category) => {
    try {
        const res = await fetch(`../api/limit/${category}`);
        const data = await res.json();
        return data;
    } catch (e) {
        console.log('ERROR', e);
    }
}


// Event listeners.
amountField.addEventListener('change', async () => {
    const category = categoryField.options[categoryField.selectedIndex].value;
    const date = dateField.value;
    const amount = amountField.value;
    //alert(`Wybrana kategoria: ${category}\nData: ${date}\nKwota: ${amount}`);
    //console.log(category, date, amount);
    eventsAction(category, date, amount);
})

dateField.addEventListener('change', async () => {
    const category = categoryField.options[categoryField.selectedIndex].value;
    const date = dateField.value;
    const amount = amountField.value;
    //alert(`Wybrana kategoria: ${category}\nData: ${date}\nKwota: ${amount}`);
    //console.log(category, date, amount);
    eventsAction(category, date, amount);
})

categoryField.addEventListener('change', async () => {
    const category = categoryField.options[categoryField.selectedIndex].value;
    const date = dateField.value;
    const amount = amountField.value;
    //alert(`Wybrana kategoria: ${category}\nData: ${date}\nKwota: ${amount}`);
    //console.log(category, date, amount);
    eventsAction(category, date, amount);
})

