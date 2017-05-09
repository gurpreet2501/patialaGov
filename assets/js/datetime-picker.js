 $(function() {
    $("#datepicker").datepicker({
    changeYear:true,
    changeMonth:true,
    yearRange: '1950:' + new Date().getFullYear().toString(),
    monthRange: "jan:dec",
    dateFormat: 'yy-mm-dd' //Mysql format to save securly in database
    });
});