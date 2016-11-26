<?php
include 'header.php';
?>
    <main>
        <a id="add" class="waves-effect waves-light btn" href="#modal1">Add</a>
        <a id="delete" class="waves-effect waves-light btn"><i class="material-icons left">remove</i>Remove</a>
        <a id="edit" class="waves-effect waves-light btn"><i class="material-icons left">edit</i>Edit</a>
        <div class="container">
            <table id="documents" class="striped"></table>
        </div>
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Add a promo</h4>
                <form>
                    <div class="input-field col s12">
                        <select id="type">
                            <option value="" disabled selected>Choisisser un type</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option id="other" value="3">Autre</option>
                        </select>
                        <label>Type de promo</label>
                    </div>
                    <div id="other_type" class="input-field col s6" style="display: none">
                        <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                        <label for="first_name">First Name</label>
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
            //perso
            $('#type').on('change',function(){
                if( $(this).val()==="3"){
                    $("#other_type").show()
                }
                else{
                    $("#other_type").hide()
                }
            });

            //materialize
            $('select').material_select();
            $('.modal').modal();

            //datatable
             var table = $('#documents').DataTable({
                oLanguage: {
                    sUrl: "/js/French.json",
                },
                processing: true,
                ajax: {
                    url: '/api/promos',
                    dataSrc: ''
                },
                columns: [{
                    data: "type",
                    title: "Type"
                }, {
                    data: "annee",
                    title: "Année"
                }, {
                    data: "localisation",
                    title: "Localisation"
                },
                ],
                paging: false,
                info: false,
                order: [
                    [0, "asc"]
                ],
            });
            $('#documents tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
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