<?php
include 'header.php';
?>
    <main>
        <a id="add" class="waves-effect waves-light btn" href="#modal1">Add</a>
        <a id="delete" class="waves-effect waves-light btn disabled" href="#modal2"><i class="material-icons left">remove</i>Remove</a>
        <a id="edit" class="waves-effect waves-light btn disabled" href="#modal3"><i class="material-icons left">edit</i>Edit</a>
        <div class="container">
            <table id="documents" class="striped"></table>
        </div>
        <div id="modal1" class="modal">
            <form>
            <div class="modal-content">
                <h4>Add a promo</h4>

                    <div class="input-field col s12">
                        <select id="select_cycle">
                            <option value="" disabled selected>Choisissez un cycle</option>
                            <option id="other" value="other">Autre</option>
                        </select>
                        <label>Cycle</label>
                    </div>
                    <div id="other_cycle" class="input-field col s6" style="display: none">
                        <input placeholder="Autre cycle" id="cycle" type="text" class="validate">
                        <label for="cycle">Nouveau cycle</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="select_annee">
                            <option value="" disabled selected>Choisissez une année</option>
                        </select>
                        <label>Année</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="select_loc">
                            <option value="" disabled selected>Localisation</option>
                            <option id="other" value="other">Autre</option>
                        </select>
                        <label>Localisation</label>
                    </div>
                    <div id="other_loc" class="input-field col s6" style="display: none">
                        <input placeholder="Nouvelle ville" id="loc" type="text" class="validate">
                        <label for="loc">Nouvelle localisation</label>
                    </div>

            </div>
            <div class="modal-footer">
                <a id="add" href="/promos" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
            </form>
        </div>
        <div id="modal2" class="modal">
            <div class="modal-content">
                <p>Ëtes-vous sûr(e) de vouloir supprimer cette promo ?</p>

            </div>
            <div class="modal-footer">
                <a href="#!" id="del" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Disagree</a>
            </div>
        </div>
        <div id="modal3" class="modal">
            <div class="modal-content">
                <h4>Edit this promo</h4>
                <form>
                    <div class="input-field col s12">
                        <select id="edit_select_cycle">
                            <option value="" disabled selected>Choisissez un cycle</option>
                            <option id="other" value="other">Autre</option>
                        </select>
                        <label>Cycle</label>
                    </div>
                    <div id="edit_other_cycle" class="input-field col s6" style="display: none">
                        <input placeholder="Autre cycle" id="edit_cycle" type="text" class="validate">
                        <label for="edit_cycle">Nouveau cycle</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="edit_select_annee">
                            <option value="" disabled selected>Choisissez une année</option>
                        </select>
                        <label>Année</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="edit_select_loc">
                            <option value="" disabled selected>Localisation</option>
                            <option id="other" value="other">Autre</option>
                        </select>
                        <label>Localisation</label>
                    </div>
                    <div id="edit_other_loc" class="input-field col s6" style="display: none">
                        <input placeholder="Nouvelle ville" id="edit_loc" type="text" class="validate">
                        <label for="edit_loc">Nouvelle localisation</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a id="post_edit" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {

            $("#add").click(function () {
                cycle = $("#select_cycle").val();
                loc = $("#select_loc").val();
                annee = $("#select_annee").val();
                if (cycle=='other'){
                    cycle = $("#cycle").val();
                    $.post( "api/cycles", { cycle: cycle});
                }
                if (loc == 'other'){
                    loc = $("#loc").val();
                    $.post( "api/locs", {loc: loc});
                }
                console.log(cycle);
                console.log(loc);
                console.log(annee);
                var post = $.post( "api/promos", { cycle: cycle, loc: loc, annee: annee });
            });

            $("#del").click(function () {
                var row = table.row('.selected').data();
                var id = row['id'];
                console.log(row);
                console.log(id);
                $.post( "api/promos", { id: id, _method: "DELETE" });
                table.ajax.reload();
            });

            $("#post_edit").click(function () {
                cycle = $("#edit_select_cycle").val();
                loc = $("#edit_select_loc").val();
                annee = $("#edit_select_annee").val();
                row = table.row('.selected').data();
                id = row['id'];
                if (cycle=='other'){
                    cycle = $("#edit_cycle").val();
                    $.post( "api/cycles", { cycle: cycle});
                }
                if (loc == 'other'){
                    loc = $("#edit_loc").val();
                    $.post( "api/locs", {loc: loc});
                }
                console.log(cycle);
                console.log(loc);
                console.log(annee);
                $.post( "api/promos", {id: id, cycle: cycle, loc: loc, annee: annee, _method: "PUT" });
                table.ajax.reload();
            });
            //perso
            $("#select_cycle").on('change',function(){
                if( $(this).val()==="other"){
                    $("#other_cycle").show()
                }
                else{
                    $("#other_cycle").hide()
                }
            });
            $("#select_loc").on('change',function(){
                if( $(this).val()==="other"){
                    $("#other_loc").show()
                }
                else{
                    $("#other_loc").hide()
                }
            });
            $("#edit_select_cycle").on('change',function(){
                if( $(this).val()==="other"){
                    $("#edit_other_cycle").show()
                }
                else{
                    $("#edit_other_cycle").hide()
                }
            });
            $("#edit_select_loc").on('change',function(){
                if( $(this).val()==="other"){
                    $("#edit_other_loc").show()
                }
                else{
                    $("#edit_other_loc").hide()
                }
            });

            $.getJSON( "api/cycles", function( data ) {
                $.each( data, function( key, val ) {
                    $("#select_cycle").append("<option value="+val+">"+val+"</option>");
                    $("#edit_select_cycle").append("<option value="+val+">"+val+"</option>");
                });
                $(document).ready(function() {
                    $('select').material_select();
                });

            });
            $.getJSON( "api/locs", function( data ) {
                $.each( data, function( key, val ) {
                    $("#select_loc").append("<option value="+val+">"+val+"</option>");
                    $("#edit_select_loc").append("<option value="+val+">"+val+"</option>");
                });
                $(document).ready(function() {
                    $('select').material_select();
                });

            });
            $.getJSON( "api/annees", function( data ) {
                $.each( data, function( key, val ) {
                    $("#select_annee").append("<option value="+val+">"+val+"</option>");
                    $("#edit_select_annee").append("<option value="+val+">"+val+"</option>");
                });
                $(document).ready(function() {
                    $('select').material_select();
                });

            });

            //materialize
            $('select').material_select();
            $(".modal").modal();

            //datatable
             var table = $("#documents").DataTable({
                oLanguage: {
                    sUrl: "/js/French.json",
                },
                processing: true,
                ajax: {
                    url: '/api/promos',
                    dataSrc: ''
                },
                columns: [{
                    data: "cycle",
                    title: "Cycle"
                }, {
                    data: "annee",
                    title: "Année"
                }, {
                    data: "loc",
                    title: "Localisation"
                },
                ],
                paging: false,
                info: false,
                order: [
                    [0, "asc"]
                ],
            });
            $("#documents tbody").on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $("#delete").addClass('disabled');
                    $("#edit").addClass('disabled');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    $("#delete").removeClass('disabled');
                    $("#edit").removeClass('disabled');
                }
                var row = table.row('.selected').data();
                var cycle = row['cycle'];
                var loc = row['loc'];
                var annee = row['annee'];
                console.log(row);
                console.log(cycle,loc,annee);
                $('#edit_select_cycle option[value="' + cycle + '"]').prop('selected', true);
                $('#edit_select_loc option[value="' + loc + '"]').prop('selected', true);
                $('#edit_select_annee option[value="' + annee + '"]').prop('selected', true);
                $('select').material_select();
            } );
        });
    </script>
<?php
include 'footer.php';
?>