export function clearInputs(inputs) {
    inputs.forEach(({ elementId, originalValue }) => {
        const element = document.getElementById(elementId);
        if (element && element.value !== originalValue) {
            element.value = originalValue;
        }
    });
}
