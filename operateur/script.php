<script>
    $(document).ready(function () {
        $("#zaid").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#bennn tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>


<script>

    $(document).ready(function () {
        $("#print-button").click(function () {
            window.print();
        });
    });

    $(document).ready(function () {
        $("#search").on("keyup", function () {
            var searchTerm = $(this).val().toLowerCase();
            var filter = $("#filter").val();
            $("#table-body tr").filter(function () {
                var text = $(this).find("td:eq(" + filterIndex(filter) + ")").text().toLowerCase();
                $(this).toggle(text.indexOf(searchTerm) > -1);
            });
        });

        $("#filter").on("change", function () {
            var searchTerm = $("#search").val().toLowerCase();
            var filter = $(this).val();
            $("#table-body tr").filter(function () {
                var text = $(this).find("td:eq(" + filterIndex(filter) + ")").text().toLowerCase();
                $(this).toggle(text.indexOf(searchTerm) > -1);
            });
        });

        function filterIndex(filter) {
            switch (filter) {
                case "nom":
                    return 0;
                case "matricule":
                    return 1;
                case "responsable":
                    return 2;
                case "ligne":
                    return 3;
                case "poste":
                    return 4;
                default:
                    return 0;
            }
        }
    });
</script>
<style>
    @media print {
        .btn-column {
            display: none
        }

        .sidebar-section {
            display: none
        }
		
        .navbar.navbar-expand-xl.bg-white {
            display: none
        }

        #demo_config {
            display: none
        }
    }
</style>