document.addEventListener('DOMContentLoaded', function () {
    const DOM_BTN_SUBMIT = document.getElementById('submitMainForm');
    const DOM_INPUT = document.getElementById('url');
    const DOM_ANSWER = document.getElementById('serverAnswer');

    DOM_BTN_SUBMIT.addEventListener("click", function (e) {
        e.preventDefault();
        processSubmit();
    });

    function processSubmit() {
        printAnswer('');
        if (!validateForm())
            return false;
        processRequest();
    }

    function validateForm() {
        let val = DOM_INPUT.value;
        let urlExp = /^(https?):\/\/[^\s$.?#].[^\s]*$/gi;
        let regex = new RegExp(urlExp);
        if (val.trim() === ""
            || !val.match(regex)
        ) {
            printAnswer('Type the correct url address into `url` field');
            return false;
        }
        return true;
    }

    function processRequest() {
        sendRequest()
            .then(res => res.json())
            .catch(error => {
                printAnswer(error);
            })
            .then(data => {
                printAnswer(data);
            });
    }

    function sendRequest() {
        showLoader();
        //Замечение разработчкика: не знаю, с какой целью в ТЗ отправка запроса через сырой JS, когда есть axios или jquery на худой конец. Но ладно.
        return fetch('/api/shortUrl', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                url: DOM_INPUT.value,
            })
        });
    }

    function printAnswer(result) {
        DOM_ANSWER.innerHTML = "";
        DOM_ANSWER.innerHTML = result;
        if (typeof result === 'object') {
            DOM_ANSWER.innerHTML = result.message ?? JSON.stringify(result);
        }
    }

    function showLoader()
    {
        printAnswer('Loading...');
    }
});
