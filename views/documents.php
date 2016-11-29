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
                    <h4>Add a document</h4>
                        <div class="input-field col s12">
                            <select id="select_promo">
                                <option value="" disabled selected>choisissez une promo</option>
                                <option id="other" value="other">Autre</option>
                            </select>
                            <label>Promo</label>
                        </div>
                        <div id="other_cycle" class="input-field col s6" style="display: none">
                            <input placeholder="Autre cycle" id="cycle" type="text" class="validate">
                            <label for="cycle">Rang</label>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>File</span>
                                <input type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <select id="select_loc">
                                <option value="" disabled selected>Localisation</option>
                                <option id="other" value="other">Autre</option>
                            </select>
                            <label>Localisation</label>
                        </div>
                        <div id="other_loc" class="input-field col s6" style="display: none">
                            <input placeholder="Nouvelle Ville" id="loc" type="text" class="validate">
                            <label for="loc">Nouvelle Localisation</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                </div>
            </form>
        </div>
        <div id="modal2" class="modal">
            <div class="modal-content">
                <p>Ëtes vous sure de vouloir supprimer cette promo ?</p>

            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Disagree</a>
            </div>
        </div>
        <div id="modal3" class="modal">
            <div class="modal-content">
                <h4>Edit a document</h4>
                <form>
                    <div class="input-field col s12">
                        <select id="edit_select_promo">
                            <option value="" disabled selected>Choisissez une promo</option>
                        </select>
                        <label>Promo</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" id="input_rank" class="autocomplete">
                        <label for="autocomplete-input">Rang</label>
                    </div>
                    <div id="other_rank" class="input-field col s6" style="display: none">
                        <input placeholder="Autre rang" id="rank" type="text" class="validate">
                        <label for="rank">Nouveau rang</label>
                    </div>
                    <div class="input-field col s12">

                        <label>Fichier</label>
                    </div>
                    <div id="other_file" class="input-field col s6" style="display: none">
                        <input placeholder="Nouveau fichier" id="file" type="text" class="validate">
                        <label for="loc">Nouveau fichier</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {

            $.getJSON( "api/promos", function( data ) {
                $.each( data, function( key, val ) {
                    console.log(key);
                    console.log(val);
                    cycle=val['cycle'];
                    if(val['loc']!="N/A") {
                        loc = "_" + val['loc'];
                    } else {
                        loc = "";
                    }
                    annee="_"+val['annee'];


                    $("#select_promo").append("<option value="+val['id']+">"+cycle + loc +  annee +"</option>");
                    $("#edit_select_promo").append("<option value="+val['id']+">"+val['cycle']+" " + val['loc'] + " " + val['annee'] +"</option>");
                });
                $(document).ready(function() {
                    $('select').material_select();
                });
            });

            var fd = new FormData(document.querySelector("form"));
            fd.append("CustomField", "This is some extra data");
            $.ajax({
                url: "stash.php",
                type: "POST",
                data: fd,
                processData: false,  // tell jQuery not to process the data
                contentType: false   // tell jQuery not to set contentType
            });



            $('select').material_select();
            $('.modal').modal();

            var table = $('#documents').DataTable({
                oLanguage: {
                    sUrl: "/js/French.json",
                },
                processing: true,
                ajax: {
                    url: '/api/documents',
                    dataSrc: ''
                },
                columns: [{
                    data: "id",
                    title: "Identifiant"
                }, {
                    data: "rang",
                    title: "Rang"
                }, {
                    data: "promo",
                    title: "Promo"
                }, {
                    data: "fichier",
                    title: "Fichier"
                },],
                paging: false,
                info: false,
                order: [
                    [0, "asc"]
                ],
            });

            //Buttons available/unavailable
            $('#documents tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                    $('#delete').addClass('disabled');
                    $('#edit').addClass('disabled');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    $('#delete').removeClass('disabled');
                    $('#edit').removeClass('disabled');
                }
            } );
            $('#add').click( function () {
                table.row('.selected');
            } );
        });
    </script>
<?php
include 'footer.php';
?>