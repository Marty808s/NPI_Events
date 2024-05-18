<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
?>

<div class="container mt-5">
    <div class="form-group">
        <label for="categorySelection">Vyberte kategorii VP</label>
        <select class="form-control" id="category-select">
            <option label="Studia" value="string:Studia"></option>
            <option label="DIGI kurzy" value="string:DIGI kurzy"></option>
            <option label="Kmenove VP" value="string:Kmenové VP"></option>
        </select>
    </div>

    <div class="form-group">
        <label for="nazev_input">Zadejte název VP:</label>
        <input type="nazev_VP" class="form-control" id="nazev_VP" placeholder="Jak se bude kurz jmenovat?">
    </div>

    <div class="form-group">
        <label for="anotace_input">Vložte anotaci VP:</label>
        <textarea class="form-control" id="anotace_VP" rows="5"></textarea>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="datepicker">Vyberte datum:</label>
                <div class="input-group date" id="datepicker">
                    <input type="text" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        $('#datepicker').datepicker({
            format: "dd/mm/yy",
            todayBtn: "linked",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true
        });
    });
    </script>

</div>



<?php
require INC . '/html_footer.php';