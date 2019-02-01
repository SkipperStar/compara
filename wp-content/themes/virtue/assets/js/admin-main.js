let valueFrom = [];
let valueTo = [];
let tableRows = [];
let options = "";
let check;
let errorMsg;
let dataFromDb;
let allTabs = []; //  All currincies tabs

// Hide all Draft Posts
let pageNow = window.location.href;
if (pageNow === 'http://bank.loc/wp-admin/edit.php?post_type=deposits') {
    $('table.wp-list-table tbody tr.status-draft').remove();
}

$(document).ready(function(){

    // Data from Database
    if (metaDataDatabase){
        dataFromDb = JSON.parse(metaDataDatabase); // get data from db
    }

    // Data of Taxonomy
    if (taxonomyTermJson) {
        $bankTerms = JSON.parse(taxonomyTermJson);
        $.each($bankTerms, function (key, value) {
            options += '<option value="'+value+'">'+value+'</option>';
        });
    }


    // ************************ if Data form Database exist ******************************************************
    // Data from Database
    if (dataFromDb && dataFromDb[''] !== '') {
        $.each(dataFromDb, function (key, value) {

            if (dataFromDb[key] === '') {
                return;
            }

            //Variables from Database for inputs
            let arrayOfDataDb = Object.values(dataFromDb[key]);
            let term = arrayOfDataDb[0];
            let rates = Object.values(arrayOfDataDb[1]);
            let table = arrayOfDataDb[2];

            // Append Data from Database
            $('#currencyTab').append(`<li class=\"nav-item\" data-tab=\"${key}\"><a class=\"nav-link\" data-toggle=\"tab\" href=\"#${key}\" role=\"tab\">${key}</a></li>`);
            $('#currencyContent').append(`
                <div class="tab-pane" id="${key}" role="tabpanel">
                    <div class="p-4">
                        <div class="form-group">
                            <label for="selectTerm">Select Term</label>
                            <select class="form-control" id="selectTerm${key}" name="select${key}['term']">
                                `+options+`
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="rateFrom">Rate from</label>
                                    <input type="number" id="rateFrom" class="form-control" value="${rates[0]}" placeholder="from" name="select${key}['rates']['From']">
                                </div>
                                <div class="col">
                                    <label for="rateTo">Rate to</label>
                                    <input type="number" id="rateTo" class="form-control" value="${rates[1]}" placeholder="to" name="select${key}['rates']['To']">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input id="slider-${key}" type="text" class="span2 sliderSelect" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[0,320000]"/>
                            <br>
                            <br>
                            
                            <div class="row">
                                <div class="col">
                                    <label for="valueFrom">Value From</label>
                                    <input type="number" id="valueFrom${key}" class="form-control" placeholder="from">
                                </div>
                                <div class="col">
                                    <label for="valueTo">Value To</label>
                                    <input type="number" id="valueTo${key}" class="form-control" placeholder="to">
                                </div>
                                <div class="col">
                                    <label for="valueTo">Rate for range</label>
                                    <input type="number" id="rateForRange${key}" class="form-control" placeholder="rate">
                                </div>
                                <div class="col">
                                    <button type="button" class="btn" data-type="plus" id="addToTable">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <br>
                            <br>
                            <table class="table table-hover" id="tableOfRates${key}">
                              <thead>
                                <tr>
                                  <th scope="col">Term</th>
                                  <th scope="col">From</th>
                                  <th scope="col">To</th>
                                  <th scope="col">Rate</th>
                                  <th scope="col">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                                <!--Content generate-->
                              </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="select${key}['tableData']" id="tableData${key}"> 
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger deleteCurrencyTab" data-id="${key}">Delete Currency</button>
                        </div>
                    </div>
                </div>
                
            `);

            //append table data to input
            $('#tableData'+key).val(table);

            //Generate array with all tabs
            addTabsToArr();
            // If Table of data exist append this data
            if (table) {
                let tableArr = JSON.parse(table);
                $.each(tableArr, function (k, val) {
                    if (val !== null) {
                        $('#tableOfRates' + key + ' tbody').append(`
                        <tr data-name="line-${val['from']}-${val['to']}-${val['rate']}" data-from="${val['from']}" data-to="${val['to']}" data-rate="${val['rate']}" data-term="${val['term']}"> 
                              <td class="currencyInfo">${val['term']}</td>
                              <td class="currencyInfo">${val['from']}</td>
                              <td class="currencyInfo">${val['to']}</td>
                              <td class="currencyInfo">${val['rate']}</td>
                              <td><button type="button" class="btn btn-danger" data-type="minus" id="deleteFromTable" data-line="line-${val['from']}-${val['to']}-${val['rate']}">-</button></td> 
                        </tr>
                        `);
                    }
                })
            }


            // Initialize slider and setting up
            let bSlider = $("#slider-"+key);

            bSlider.slider({
                min: 0,
                max: 1000000,
                tooltip: 'always',
                labelledby: ['valueFrom', 'valueTo']
            });

            bSlider.on('change', function () {
                let allValues = $(this).slider('getValue');
                valueFrom[key] = allValues[0];
                valueTo[key] = allValues[1];
                $('input#valueFrom'+key).val(valueFrom[key]);
                $('input#valueTo'+key).val(valueTo[key]);
            });

            $(document).on('keyup', 'input#valueFrom'+key+', input#valueTo'+key, function () {
                let inputValueFrom = parseInt($('input#valueFrom'+key).val());
                let inputValueTo = parseInt($('input#valueTo'+key).val());

                bSlider.slider('setValue', [inputValueFrom, inputValueTo]);
            });

            // End initialize

            //Delete Line From Table Function

            $(document).on('click', 'button#deleteFromTable', function () {
                let searchId = $(this).data('line');
                let sTerm = $('#tableOfRates'+key+' tbody tr[data-name="'+searchId+'"]').attr('data-term');
                let sFrom = $('#tableOfRates'+key+' tbody tr[data-name="'+searchId+'"]').attr('data-from');
                let sTo = $('#tableOfRates'+key+' tbody tr[data-name="'+searchId+'"]').attr('data-to');
                let sRate = $('#tableOfRates'+key+' tbody tr[data-name="'+searchId+'"]').attr('data-rate');
                let searchLine = {'term': sTerm, 'from': sFrom, 'to': sTo, 'rate': sRate};
                $.each(tableRows, function (k, val) {
                    if (JSON.stringify(searchLine)===JSON.stringify(val)) {
                        delete tableRows[k];
                    }
                });
                $('#tableOfRates'+key+' tbody tr[data-name="'+searchId+'"]').remove();
                // let serialDataTable = allTabs.toString();
                // $('#tableData'+value).val(serialDataTable); // Add data table to hidden input
                $('#tableData'+key).val(tableRows);

            });

            //Delete Line From Rate Table End

            // Add Line to Table
            $(document).on('click', 'button#addToTable', function () {

                let tTerm = $('#selectTerm'+key).val();
                let tFrom = $('input#valueFrom'+key).val();
                let tTo = $('input#valueTo'+key).val();
                let tRate = $('input#rateForRange'+key).val();
                let inputData = {'term': tTerm,'from': tFrom,'to': tTo, 'rate': tRate};
                let checkEqual = [];

                if (tTerm && tFrom && tTo && tRate !== '') {

                    $.each(tableRows, function (k, val) {

                        if (JSON.stringify(inputData)===JSON.stringify(val)) {
                            checkEqual.push(false);
                        } else {
                            checkEqual.push(true);
                        }

                    });

                    check = checkEqual.some(function (item) {  // есть хоть один false
                        return item === false;
                    });

                    if (!check) {
                        tableRows.push(inputData);
                        $('#tableOfRates'+key+' tbody').append(`
                            <tr data-name="line-${tFrom}-${tTo}-${tRate}" data-from="${tFrom}" data-to="${tTo}" data-rate="${tRate}" data-term="${tTerm}">
                              <td class="currencyInfo">${tTerm}</td>
                              <td class="currencyInfo">${tFrom}</td>
                              <td class="currencyInfo">${tTo}</td>
                              <td class="currencyInfo">${tRate}</td>
                              <td><button type="button" class="btn btn-danger" data-type="minus" id="deleteFromTable" data-line="line-${tFrom}-${tTo}-${tRate}">-</button></td>
                            </tr>
                        `);
                        let serialDataTable = JSON.stringify(tableRows);
                        $('#tableData'+key).val(serialDataTable); // Add data table to hidden input
                    } else {
                        errorMsg = 'These values ​​are already in the table!';
                        $('#errorMsg div').text(errorMsg);
                        $("#errorMsg").show().delay(4000).fadeOut();
                    }
                }
            });

            // Add to Table end

        });
    }
    // End append Data from Database
    // ************************ if Data from Database exist ******************************************************



    addTabsToArr();

    //Delete Currency Tab
    $(document).on('click', ".deleteCurrencyTab", function () {
        let tabId = $(this).data("id");
        $('#currencyTab').find(`li.nav-item[data-tab='${tabId}']`).remove(); //Delete Tab
        $('#currencyContent').find("#" + tabId).remove();          //Delete Tab Content
        if (allTabs) {
            deleteTabFromArr(tabId);
        }
    });


    $('#currencySelect').click(function () {
        $currency = $(this).val();
        $existCurrencyTab = []; // array with exist tabs in Nav tabs 'ul'
        $('#currencyTab li a').each(function (i) {
            let value = $(this).text();
            $existCurrencyTab.push(value);
        });
        $arrCurrency = [];      // array with selected items in select box(select currency)
        $.each($currency, function (key, value) {
            $arrCurrency.push(value);
        });

        $.each($arrCurrency, function (key, value) {
            if ( $.inArray( value , $existCurrencyTab ) === -1 ) {
                allTabs.push(value); // add tab after click on select
                let serializeTabs = allTabs.toString();
                $('#arrayCurrency').val(serializeTabs);

                $('#currencyTab').append(`<li class=\"nav-item\" data-tab=\"${value}\"><a class=\"nav-link\" data-toggle=\"tab\" href=\"#${value}\" role=\"tab\">${value}</a></li>`);
                $('#currencyContent').append(`
                    <div class="tab-pane" id="${value}" role="tabpanel">
                        <div class="p-4">
                            <div class="form-group">
                                <label for="selectTerm">Select Term</label>
                                <select class="form-control" id="selectTerm${value}" name="select${value}['term']">
                                    `+options+`
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="rateFrom">Rate from</label>
                                        <input type="number" id="rateFrom" class="form-control" placeholder="from" name="select${value}['rates']['From']">
                                    </div>
                                    <div class="col">
                                        <label for="rateTo">Rate to</label>
                                        <input type="number" id="rateTo" class="form-control" placeholder="to" name="select${value}['rates']['To']">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input id="slider-${value}" type="text" class="span2 sliderSelect" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[0,320000]"/>
                                <br>
                                <br>
                                <div class="errBlock" id="errorMsg">
                                    <div class="alert alert-danger" role="alert"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="valueFrom">Value From</label>
                                        <input type="number" id="valueFrom${value}" class="form-control" placeholder="from">
                                    </div>
                                    <div class="col">
                                        <label for="valueTo">Value To</label>
                                        <input type="number" id="valueTo${value}" class="form-control" placeholder="to">
                                    </div>
                                    <div class="col">
                                        <label for="valueTo">Rate for range</label>
                                        <input type="number" id="rateForRange${value}" class="form-control" placeholder="rate">
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn" data-type="plus" id="addToTable">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <br>
                                <table class="table table-hover" id="tableOfRates${value}">
                                  <thead>
                                    <tr>
                                      <th scope="col">Term</th>
                                      <th scope="col">From</th>
                                      <th scope="col">To</th>
                                      <th scope="col">Rate</th>
                                      <th scope="col">Delete</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <!--Content generate-->
                                  </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="select${value}['tableData']" id="tableData${value}"> 
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger deleteCurrencyTab" data-id="${value}">Delete Currency</button>
                            </div>
                        </div>
                    </div>
                    
                `);
            }
            // Initialize slider and setting up
            let bSlider = $("#slider-"+value);

            bSlider.slider({
                min: 0,
                max: 1000000,
                tooltip: 'always',
                labelledby: ['valueFrom', 'valueTo']
            });

            bSlider.on('change', function () {
                let allValues = $(this).slider('getValue');
                valueFrom[value] = allValues[0];
                valueTo[value] = allValues[1];
                $('input#valueFrom'+value).val(valueFrom[value]);
                $('input#valueTo'+value).val(valueTo[value]);
            });

            $(document).on('keyup', 'input#valueFrom'+value+', input#valueTo'+value, function () {
                let inputValueFrom = parseInt($('input#valueFrom'+value).val());
                let inputValueTo = parseInt($('input#valueTo'+value).val());

                bSlider.slider('setValue', [inputValueFrom, inputValueTo]);

            });

            // End initialize

            // Add to Table
            $(document).on('click', 'button#addToTable', function () {

                let tTerm = $('#selectTerm'+value).val();
                let tFrom = $('input#valueFrom'+value).val();
                let tTo = $('input#valueTo'+value).val();
                let tRate = $('input#rateForRange'+value).val();
                let inputData = {'term': tTerm,'from': tFrom,'to': tTo, 'rate': tRate};
                let checkEqual = [];

                if (tTerm && tFrom && tTo && tRate !== '') {
                    $.each(tableRows, function (k, val) {

                        if (JSON.stringify(inputData)===JSON.stringify(val)) {
                            checkEqual.push(false);
                        } else {
                            checkEqual.push(true);
                        }

                    });

                    check = checkEqual.some(function (item) {  // есть хоть один false
                        return item === false;
                    });

                    if (!check) {
                        tableRows.push(inputData);
                        $('#tableOfRates'+value+' tbody').append(`
                            <tr data-name="line-${tFrom}-${tTo}-${tRate}" data-from="${tFrom}" data-to="${tTo}" data-rate="${tRate}" data-term="${tTerm}">
                              <td class="currencyInfo">${tTerm}</td>
                              <td class="currencyInfo">${tFrom}</td>
                              <td class="currencyInfo">${tTo}</td>
                              <td class="currencyInfo">${tRate}</td>
                              <td><button type="button" class="btn btn-danger" data-type="minus" id="deleteFromTable" data-line="line-${tFrom}-${tTo}-${tRate}">-</button></td>
                            </tr>
                        `);
                        let serialDataTable = JSON.stringify(tableRows);
                        $('#tableData'+value).val(serialDataTable); // Add data table to hidden input
                    } else {
                        errorMsg = 'These values ​​are already in the table!';
                        $('#errorMsg div').text(errorMsg);
                        $("#errorMsg").show().delay(4000).fadeOut();
                    }
                }
            });

            // Add to Table end

            //Delete Line From Rate Table
            $(document).on('click', 'button#deleteFromTable', function () {
                let searchId = $(this).data('line');
                let sTerm = $('#tableOfRates'+value+' tbody tr[data-name="'+searchId+'"]').attr('data-term');
                let sFrom = $('#tableOfRates'+value+' tbody tr[data-name="'+searchId+'"]').attr('data-from');
                let sTo = $('#tableOfRates'+value+' tbody tr[data-name="'+searchId+'"]').attr('data-to');
                let sRate = $('#tableOfRates'+value+' tbody tr[data-name="'+searchId+'"]').attr('data-rate');
                let searchLine = {'term': sTerm, 'from': sFrom, 'to': sTo, 'rate': sRate};
                $.each(tableRows, function (k, val) {
                    if (JSON.stringify(searchLine)===JSON.stringify(val)) {
                        delete tableRows[k];
                    }
                });
                $('#tableOfRates'+value+' tbody tr[data-name="'+searchId+'"]').remove();
                // let serialDataTable = allTabs.toString();
                // $('#tableData'+value).val(serialDataTable); // Add data table to hidden input

                $('#tableData'+key).val(tableRows);
            });

            //Delete Line From Rate Table End

        });

    });

});

// Custom Functions

/*
** Function for collect exists tabs
 */
function addTabsToArr() {

    // initialize array with tabs values and append to hidden input
    $('#currencyTab li a').each(function () {
        let nameCurrency = $(this).text();
        if ( $.inArray( nameCurrency , allTabs ) === -1 ) {
            allTabs.push(nameCurrency);
        }
    });
    let serializeTabs = allTabs.toString();
    $('#arrayCurrency').val(serializeTabs); //input data to hidden input with Tabs
    return allTabs;

}

/*
* Function for delete tabs from array
* currencyName : id
*/
function deleteTabFromArr(currencyName) {

    allTabs = $.grep(allTabs, function (value) {
        return value != currencyName;
    });
    let serializeTabs = allTabs.toString();
    $('#arrayCurrency').val(serializeTabs);
    return allTabs;

}