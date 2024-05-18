<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
?>

<div class="container mt-5">
    <form method="post" action="/php/insert.php">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category-select">Vyberte kategorii VP:</label>
                    <select class="form-control" id="category-select" name="category-select">
                        <option label="Studia" value="Studia"></option>
                        <option label="DIGI kurzy" value="DIGI kurzy"></option>
                        <option label="Kmenové VP" value="Kmenové VP"></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nazev_VP">Zadejte název VP:</label>
                    <input type="text" class="form-control" id="nazev_VP" name="nazev_VP" placeholder="Jak se bude kurz jmenovat?">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="eduform-select">Vyberte formu realizace:</label>
                    <select class="form-control" id="eduform-select" name="eduform-select">
                        <option label="Prezenční" value="Prezenční"></option>
                        <option label="Online" value="Online"></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lektor_VP">Zadejte lektora VP:</label>
                    <input type="text" class="form-control" id="lektor_VP" name="lektor_VP" placeholder="Kdo bude kurz lektorovat?">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="anotace_VP">Vložte anotaci VP:</label>
                    <textarea class="form-control" id="anotace_VP" name="anotace_VP" rows="5" placeholder="Vložte anotaci VP"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cena_VP">Zadejte cenu kurzu:</label>
                    <input type="number" class="form-control" id="cena_VP" name="cena_VP" placeholder="Zadejte cenu kurzu" min="0" step="1000">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prihlaseni-link">Odkaz na přihlášení:</label>
                    <input type="text" class="form-control" id="prihlaseni-link" name="prihlaseni-link" placeholder="Vložte odkaz na přihlášení">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="multi-terms-checkbox" name="multi-terms-checkbox">
                <label class="form-check-label" for="multi-terms-checkbox">Více termínů VP</label>
            </div>
        </div>

        <div id="multi-terms" class="form-group" style="display:none;">
            <label for="terms-schedule">Rozpis termínů:</label>
            <textarea class="form-control" id="terms-schedule" name="terms-schedule" rows="5" placeholder="Zadejte rozpis termínů"></textarea>
        </div>

        <div id="single-term" class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="datetimepicker-date">Vyberte datum:</label>
                    <div class="input-group date" id="datetimepicker-date" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker-date" name="datetimepicker-date"/>
                        <div class="input-group-append" data-target="#datetimepicker-date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="datetimepicker-time-start">Čas Od:</label>
                    <div class="input-group date" id="datetimepicker-time-start" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker-time-start" name="datetimepicker-time-start"/>
                        <div class="input-group-append" data-target="#datetimepicker-time-start" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="datetimepicker-time-end">Čas Do:</label>
                    <div class="input-group date" id="datetimepicker-time-end" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker-time-end" name="datetimepicker-time-end"/>
                        <div class="input-group-append" data-target="#datetimepicker-time-end" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Vložit VP</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    $('#datetimepicker-date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#datetimepicker-time-start').datetimepicker({
        format: 'HH:mm'
    });
    $('#datetimepicker-time-end').datetimepicker({
        format: 'HH:mm'
    });

    $('#multi-terms-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('#multi-terms').show();
            $('#single-term').hide();
        } else {
            $('#multi-terms').hide();
            $('#single-term').show();
        }
    });
});
</script>


<?php
require INC . '/html_footer.php';
?>