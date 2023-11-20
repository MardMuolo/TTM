import './bootstrap';
import 'admin-lte';
import $ from 'jquery';
import select2 from 'select2';
import Stepper from 'bs-stepper'
import.meta.glob([
    '../images/**',
    '../fonts/**',
  ]);
window.jQuery = window.$ = $
window.select2 = select2
window.stepper = Stepper
document.addEventListener('DOMContentLoaded', function(e) {
  e.preventDefault();
  window.stepper = new Stepper(document.querySelector('.bs-stepper'))
})
select2()
//import 'select2'
//window.select2 = select2