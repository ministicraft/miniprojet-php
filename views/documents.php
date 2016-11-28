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
            <div class="modal-content">
                <h4>Add a document</h4>
                <form>
                    <div class="input-field col s12">
                        <select id="select_cycle">
                            <option value="" disabled selected>Choisissez un cycle</option>
                            <option id="other" value="other">Autre</option>
                        </select>
                        <label>Cycle</label>
                    </div>
                    <div id="other_cycle" class="input-field col s6" style="display: none">
                        <input placeholder="Autre cycle" id="cycle" type="text" class="validate">
                        <label for="cycle">Nouveau Cylce</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="select_annee">
                            <option value="" disabled selected>Choisisser une année</option>
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
                        <input placeholder="Nouvelle Ville" id="loc" type="text" class="validate">
                        <label for="loc">Nouvelle Localisation</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
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
                <h4>Add a promo</h4>
                <form>
                    <div class="input-field col s12">
                        <select id="edit_select_cycle">
                            <option value="" disabled selected>Choisisser un Cycle</option>
                            <option id="other" value="other">Autre</option>
                        </select>
                        <label>Cycle</label>
                    </div>
                    <div id="other_cycle" class="input-field col s6" style="display: none">
                        <input placeholder="Autre cycle" id="cycle" type="text" class="validate">
                        <label for="cycle">Nouveau Cylce</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="edit_select_annee">
                            <option value="" disabled selected>Choisisser une année</option>
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
                    <div id="other_loc" class="input-field col s6" style="display: none">
                        <input placeholder="Nouvelle Ville" id="loc" type="text" class="validate">
                        <label for="loc">Nouvelle Localisation</label>
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