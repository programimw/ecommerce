const [selectField1, selectField2] = [document.getElementById("first-select"), document.getElementById("second-select")];
const [textInput1, textInput2] = [document.getElementById("left-text-input"), document.getElementById("right-text-input")];
const [symbol1, symbol2] = [document.getElementById("left-symbol"), document.getElementById("right-symbol")];
const [numberInput1, numberInput2] = [document.getElementById("left-number-input"), document.getElementById("right-number-input")];
const convertButton = document.querySelector(".convert");

const conversionRates = {
  USD: { Euro: 0.94, Lek: 92.2 },
  Euro: { USD: 1.06, Lek: 98.17 },
  Lek: { USD: 0.011, Euro: 0.01 },
};

class Currency {
  constructor(name, symbol) {
    this.name = name;
    this.symbol = symbol;
  }
}

const currencies = [new Currency("USD", "$"), new Currency("Euro", "€"), new Currency("Lek", "L")];

function updateFieldsBasedOnInput(textInput, selectField, symbolDisplay) {
  const inputValue = textInput.value;
  const currency = currencies.find((c) => c.name === inputValue);

  if (currency) {
    selectField.value = currency.name;
    symbolDisplay.textContent = currency.symbol;
  } else {
    selectField.value = "";
    symbolDisplay.textContent = "";
  }
}

function updateCurrencyFields(selectField, textInput, symbolDisplay) {
  const selectedCurrency = selectField.value;
  const currency = currencies.find((c) => c.name === selectedCurrency);

  if (currency) {
    textInput.value = currency.name;
    symbolDisplay.textContent = currency.symbol;
  }
}

function convertCurrency() {
  const fromCurrency = selectField1.value;
  const toCurrency = selectField2.value;
  const amount = parseFloat(numberInput1.value);

  if (fromCurrency && toCurrency && !isNaN(amount) && fromCurrency !== toCurrency) {
    const rate = conversionRates[fromCurrency][toCurrency];
    const convertedAmount = amount * rate;
    numberInput2.value = convertedAmount.toFixed(2);
  }
}

selectField1.addEventListener("change", () => updateCurrencyFields(selectField1, textInput1, symbol1));
selectField2.addEventListener("change", () => updateCurrencyFields(selectField2, textInput2, symbol2));

textInput1.addEventListener("input", () => updateFieldsBasedOnInput(textInput1, selectField1, symbol1));
textInput2.addEventListener("input", () => updateFieldsBasedOnInput(textInput2, selectField2, symbol2));

convertButton.addEventListener("click", convertCurrency);
