const js_mask_date = document.querySelector('.js-mask-date');
if (typeof (js_mask_date) !== undefined && js_mask_date !== null) {
    console.log('existe');
    VMasker(js_mask_date).maskPattern('99/99/9999');
}
// document.addEventListener('DOMContentLoaded', function () {
// });
