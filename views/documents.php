<?php
include 'header.php';
?>
    <main>
        <div class="container">
            <table id="documents" class="striped"></table>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $('#documents').DataTable({
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
        });
    </script>
<?php
include 'footer.php';
?>