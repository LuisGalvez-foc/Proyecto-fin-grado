<?php
include('header.php');
include('navegador.php');
?>

<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let infoPagina = document.getElementById('infoPagina');
            if (infoPagina) {
                infoPagina.innerHTML = 'Panel de Administracion';
            }

            let infoGeneral = document.getElementById('infoGeneralText');
            if (infoGeneral) {
                infoGeneral.innerHTML = "Pagina de inicio. No hay mensajes";
            }
        });
    </script>
</body>