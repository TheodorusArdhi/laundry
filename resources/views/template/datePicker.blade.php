<script>$('.select2').select2();</script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.id.min.js') }}"></script>
<script>
    $('.input-group.date').datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        language: "id",
        autoclose: true,
        todayHighlight: true
    });
    $('.input-daterange').datepicker({
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
        language: "id",
        format: 'dd/mm/yyyy'
    })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>