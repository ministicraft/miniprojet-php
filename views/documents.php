<?php
include 'header.php';
?>
    <main>
        <a id="add" class="waves-effect waves-light btn" href="#modal1">Add</a>
        <a id="delete" class="waves-effect waves-light btn disabled" href="#modal2"><i class="material-icons left">remove</i>Remove</a>
        <a id="edit" class="waves-effect waves-light btn disabled" href="#modal3"><i class="material-icons left">edit</i>Edit</a>
        <div class="card" style="margin: 20px auto; padding:20px; max-width: 80%">
            <table id="documents" class="striped" width="100%"></table>
        </div>
        <div id="modal1" class="modal">
            <form>
                <div class="modal-content row">
                    <h4>Add a document</h4>
                        <div class="input-field col s12">
                            <select id="select_promo">
                                <option value="" disabled selected>choisissez une promo</option>
                            </select>
                            <label>Promo</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>File</span>
                                <input id="fileupload" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <input placeholder="libelle" id="libelle" type="text" class="validate">
                            <label for="libelle">Libelle</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="rang" type="number" name="rang">
                            <label>Rang</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <a id="addPost" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                </div>
            </form>
        </div>
        <div id="modal2" class="modal">
            <div class="modal-content">
                <p>Ëtes vous sure de vouloir supprimer ce Document ?</p>

            </div>
            <div class="modal-footer">
                <a id="del" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                <a class=" modal-action modal-close waves-effect waves-green btn-flat">Disagree</a>
            </div>
        </div>
        <div id="modal3" class="modal">
            <form>
                <div class="modal-content">
                    <h4>Edit a document</h4>
                    <div class="input-field col s12">
                        <select id="edit_select_promo">
                            <option value="" disabled selected>choisissez une promo</option>
                        </select>
                        <label>Promo</label>
                    </div>
                    <div class="input-field col s12">
                        <input placeholder="libelle" id="edit_libelle" type="text" class="validate">
                        <label for="libelle">Libelle</label>
                    </div>
                    <div class="input-field col s2">
                        <input id="edit_rang" type="number" name="rang">
                        <label>Rang</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="post_edit" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                </div>
            </form>
        </div>
        <div id="processing" class="modal">
            <div class="modal-content center">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only" style="height: 100%">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                            <div class="circle"></div>
                        </div><div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div
            </div>

        </div>
    </main>
    <script>
        $(document).ready(function() {

            $.getJSON( "api/promos", function( data ) {
                $.each( data, function( key, val ) {
                    cycle=val['cycle'];
                    if(val['loc']!="N/A") {
                        loc = "_" + val['loc'];
                    } else {
                        loc = "";
                    }
                    annee="_"+val['annee'];


                    $("#select_promo").append("<option value=\""+val['id']+"\">"+cycle + loc +  annee +"</option>");
                    $("#edit_select_promo").append("<option value=\""+val['id']+"\">"+cycle + loc + annee +"</option>");
                });
                $(document).ready(function() {
                    $('select').material_select();
                });
            });

            $('#addPost').click(function() {
                //$('#processing').modal('open');
                var file_data = $('#fileupload').prop('files')[0];
                var libelle = $('#libelle').val();
                var rang =  $('#rang').val();
                var promo = $('#select_promo').val();
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('libelle', libelle);
                form_data.append('rang', rang);
                form_data.append('promo', promo);
                $.ajax({
                    url: 'api/documents', // point to server-side PHP script
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(php_script_response){
                        $('#processing').modal('close');
                        table.ajax.reload();
                    }
                });
            });

            $("#del").click(function () {
                var row = table.row('.selected').data();
                var id = row['id'];
                $.post("api/documents", {id: id, _method: "DELETE"}).done(function (data) {
                    table.ajax.reload();
                });
            });
            $("#post_edit").click(function () {
                var row = table.row('.selected').data();
                var id = row['id'];
                var libelle = $('#edit_libelle').val();
                var rang = $('#edit_rang').val();
                var promo = $('#edit_select_promo').val();
                var form_data = new FormData();
                $.post("api/documents", {
                    id: id,
                    libelle: libelle,
                    rang: rang,
                    promo: promo,
                    _method: "PUT"
                }).done(function (data) {
                    table.ajax.reload();
                });
            });


            $('select').material_select();
            $('.modal').modal();
            $('#processing').modal({
                dismissible: false,
                starting_top: '25%',
                ending_top: '25%'

            });

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
                    data: "promo",
                    title: "Promo"
                }, {
                    data: "rang",
                    title: "Rang"
                }, {
                    data: "libelle",
                    title: "Libelle"
                }, {
                    data: "fichier",
                    title: "Fichier"
                },],
                paging: true,
                lengthChange: false,
                pageLength: 20,
                info: false,
                order: [
                    [0, "asc"]
                ]
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

                    var row = table.row('.selected').data();
                    var promo = row['promo'];
                    var rang = row['rang'];
                    var libelle = row['libelle'];
                    $('#edit_select_promo option[value="' + promo + '"]').prop('selected', true);
                    $('#edit_rang option[value="' + rang + '"]');
                    $('#edit_libelle option[value="' + libelle + '"]');
                    $('select').material_select();
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