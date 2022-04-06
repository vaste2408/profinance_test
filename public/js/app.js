/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

document.addEventListener('DOMContentLoaded', function () {
  var DOM_BTN_SUBMIT = document.getElementById('submitMainForm');
  var DOM_INPUT = document.getElementById('url');
  var DOM_ANSWER = document.getElementById('serverAnswer');
  DOM_BTN_SUBMIT.addEventListener("click", function (e) {
    e.preventDefault();
    processSubmit();
  });

  function processSubmit() {
    printAnswer('');
    if (!validateForm()) return false;
    processRequest();
  }

  function validateForm() {
    var val = DOM_INPUT.value;
    var urlExp = /^(https?):\/\/[^\s$.?#].[^\s]*$/gi;
    var regex = new RegExp(urlExp);

    if (val.trim() === "" || !val.match(regex)) {
      printAnswer('Type the correct url address into `url` field');
      return false;
    }

    return true;
  }

  function processRequest() {
    sendRequest().then(function (res) {
      return res.json();
    })["catch"](function (error) {
      printAnswer(error);
    }).then(function (data) {
      printAnswer(data);
    });
  }

  function sendRequest() {
    showLoader(); //Замечение разработчкика: не знаю, с какой целью в ТЗ отправка запроса через сырой JS, когда есть axios или jquery на худой конец. Но ладно.

    return fetch('/api/shortUrl', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        url: DOM_INPUT.value
      })
    });
  }

  function printAnswer(result) {
    DOM_ANSWER.innerHTML = "";
    DOM_ANSWER.innerHTML = result;

    if (_typeof(result) === 'object') {
      var _result$message;

      DOM_ANSWER.innerHTML = (_result$message = result.message) !== null && _result$message !== void 0 ? _result$message : JSON.stringify(result);
    }
  }

  function showLoader() {
    printAnswer('Loading...');
  }
});
/******/ })()
;