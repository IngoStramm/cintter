function masks_init() {
    const js_mask_date = document.querySelector('.js-mask-date');
    if (typeof (js_mask_date) !== undefined && js_mask_date !== null) {
        VMasker(js_mask_date).maskPattern('99/99/9999');
    }
}

function tooltips_init() {

    const check_tooltips = document.getElementById('tooltip-texts');
    if (typeof (check_tooltips) === 'undefined' || check_tooltips === null) {
        console.log('não existe tooltip');
        return;
    }

    const inputs = check_tooltips.querySelectorAll('input');
    const arr_tooltips = [];
    Array.prototype.forEach.call(inputs, function (el, i) {
        arr_tooltips.push({
            'id': el.dataset.tooltipField,
            'text': el.id
        });
    });

    for (i = 0; i < arr_tooltips.length; i++) {
        const tooltip = arr_tooltips[i];
        const field = document.getElementById(tooltip.id);
        const text = document.getElementById(tooltip.text);

        if ((typeof (field) !== undefined && field !== null) && (typeof (text) !== undefined && text !== null) && (typeof (text.value) !== undefined && text.value !== null)) {
            const icon = document.createElement('span');
            const label = field.querySelector('label');
            icon.classList.add('cintter-tooltip-icon');
            icon.innerHTML = '&#63;';
            // field.querySelector('label').appendChild(icon);
            field.insertBefore(icon, field.firstElementChild.nextSibling);
            field.classList.add('has-tooltip');
            tippy(label, {
                content: text.value,
                placement: 'auto-end'
            });
        }

    }
}

document.addEventListener('DOMContentLoaded', function () {
    masks_init();
    tooltips_init();
});