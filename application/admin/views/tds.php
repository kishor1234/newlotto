<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Income Tax Calculator</title>
        <style>
            article, aside, figure, footer, header, nav, section {
                display: block;
            }
            body {
                font-family: Arial, Helvetica, sans-serif;
                background-color: white;
                margin: 0 auto;
                width: 500px;
                border: 3px solid blue;
            }
            h1 {
                color: blue;
                margin-top: 0;
            }
            section {
                padding: 1em 2em;
            }
            label {
                float: left;
                width: 10em;
                text-align: right;
            }
            input {
                margin-left: 1em;
                margin-bottom: .5em;
            }
        </style>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script>
            var $ = function (id) {
                return document.getElementById(id);
            }
            var calculate_tax = function () {
                var total;
                var income = parseFloat($("income").value);
                function calcTaxes(amount) {
                    var calculate = 0;
                    if (amount > 85650) {
                        tax = (amount - 85650) * .28 + 870.0 + (35350 - 8700) * .15 + (89350 - 36900) * .25;
                    }
                    else if (amount > 35350) {
                        tax = (amount - 35350) * .25 + 870.0 + (35350 - 8700) * .15;
                    }
                    else if (amount > 8700) {
                        tax = (amount - 8700) * .15 + 870.0;
                    }
                    else {
                        tax = amount * .10;
                    }
                    tax += amount * .153;
                    return tax;
                    /*
                     10% on taxable income from $0 to $8,700, plus
                     15% on taxable income over $8,700 to $35,350, plus
                     25% on taxable income over $35,350 to $85,650, plus
                     */
                }
            }
            window.onload = function () {
                $("calculate").onclick = calculate_tax;
            }
        </script>
    </head>
    <body>
        <section>
            <h1>Income Tax Calculator</h1>
            <label>Enter taxable income:</label>
            <input type="text" id="income" />
            <input type="button" value="Calculate" name="calculate" id="calculate" /><br><br>
            <label>Income tax owed:</label>
            <input type="text" id="tax"><br>
        </section>
    </body>
</html>