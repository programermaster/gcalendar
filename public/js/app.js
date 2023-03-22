
$(document).ready( function () {

 var firstOpen = true;
        var time;

        var dateToday = new Date();
        $('#datePicker').datetimepicker({
            format: 'DD-MM-YYYY',
             minDate: dateToday,
        })

        $('#timePicker').datetimepicker({
            useCurrent: false,
            format: "hh:mm A",
            minDate: moment()
        }).on('dp.show', function() {
            if(firstOpen) {
                time = moment().startOf('day');
                firstOpen = false;
            } else {
                time = "01:00 PM"
            }
            $(this).data('DateTimePicker').date(time);
        });


});
