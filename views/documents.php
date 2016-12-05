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
                            </select>
                            <label>Promo</label>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>File</span>
                                <input id="fileupload" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <select id="select_rang">
                                <option value="" disabled selected>Rang</option>
                            </select>
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
                <p>Ëtes vous sure de vouloir supprimer cette promo ?</p>

            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Disagree</a>
            </div>
        </div>
        <div id="modal3" class="modal">
            <form>
                <div class="modal-content">
                    <h4>Edit a document</h4>
                    <div class="input-field col s12">
                        <select id="select_promo">
                            <option value="" disabled selected>choisissez une promo</option>
                        </select>
                        <label>Promo</label>
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
                        <select id="select_rang">
                            <option value="" disabled selected>Localisation</option>
                        </select>
                        <label>Rang</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
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
                    $("#edit_select_promo").append("<option value="+val['id']+">"+cycle + loc + annee +"</option>");
                });
                $(document).ready(function() {
                    $('select').material_select();
                });
            });

            $('#addPost').click(function() {
                $('#processing').modal('open');
                var file_data = $('#fileupload').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                alert(form_data);
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
                        alert(php_script_response); // display response from the PHP script, if any
                    }
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