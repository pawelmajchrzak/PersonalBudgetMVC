
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
        limitInfo.innerText = `${limit}`; //limit  
    } else {
        limitInfo.innerText = `-`; //nie ma limitu
    }

    field.appendChild(limitInfo);
}

const renderValueBox = (field, monthlyExpenses) => {
    if (!!monthlyExpenses) {
        limitValue.innerText = `${monthlyExpenses} zł`;   //dotychczas wydano
    } else {
        limitValue.innerText = `0 zł`; //nic nie wydano jeszcze
    }

    field.appendChild(limitValue);
}

const renderLeftBox = (field, limitInfoData, monthlyExpenses, amount) => {
    //limitLeft.innerText = `${(limitInfoData - monthlyExpenses - amount).toFixed(2)} zł`; //wydatki+kwota wpisana  
    limitLeft.innerText = `${(limitInfoData - monthlyExpenses - amount).toFixed(2)} zł`; //wydatki+kwota wpisana  

    (limitInfoData - monthlyExpenses - amount).toFixed(2) < 0 ?  field.classList.add('break_limit') :  field.classList.remove('break_limit');

    field.appendChild(limitLeft);
}
/*
const showBox = (box) => {
    box.classList.add('visible');
}
*/

// Events logic.
const eventsAction = async (category, date, amount) => {
    if (category && date && amount) {

        const limitInfoData = await getLimitForCategory(category);
        const monthlyExpenses = await getMonthlyExpenses(category, date);

        renderInfoBox(limitInfoBox, limitInfoData);
        renderValueBox(limitValueBox, monthlyExpenses);
        renderLeftBox(limitLeftBox, limitInfoData, monthlyExpenses, amount);
    }  


        //showBox(limitInfoBox);
        //showBox(limitValueBox);
        //showBox(limitLeftBox);
        /*
        if (date) {


            if (amount && limitInfoData) {

            } else {
                //showBox(limitInfoBox)
                //showBox(limitValueBox);
                limitLeftBox.classList.remove('visible');
            }
        } else {
            //showBox(limitInfoBox);
            limitValueBox.classList.remove('visible');
            limitLeftBox.classList.remove('visible');
        }
        
    } else {
        limitInfoBox.classList.remove('visible');
        limitValueBox.classList.remove('visible');
        limitLeftBox.classList.remove('visible');
        */
    
    
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

const getMonthlyExpenses = async (category, date) => {
    try {
        const res = await fetch(`../api/limitSum/${category}/${date}`);
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
    if (category != "cat0")
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

