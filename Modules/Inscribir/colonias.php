

<!DOCTYPE html>
<html lang="en">

<!-- Este archivo solo es una prueba de la API Zippopotam para mostrar colonias mediante el código postal. -->

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Prueba</title>
</head>

<body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="">Ingrese código postal</label>
                <input type="number" placeholder="Código Postal" id="codpostal" name="codpostal" onchange="codigoPos()">
                <select id="colonias">
                        <option value="otro">Colonia</option>
                </select>
                <!--     <input type="submit"> -->
        </form>

        <script>
                function codigoPos() {
                        const codigo = document.getElementById('codpostal').value;
                        if (codigo != null) {
                                console.log("Sí se recibe un cp");
                                var client = new XMLHttpRequest();
                                client.open("GET", `http://api.zippopotam.us/mx/${codigo}`, true);
                                client.onreadystatechange = function() {
                                        if (client.readyState == 4) {
                                                const respuesta = JSON.parse(client.responseText);
                                                const colonias = respuesta.places.map(colonia => colonia['place name']);
                                                const coloniasss = document.getElementById('colonias');
                                                coloniasss.innerHTML = '';
                                                const opcion = '';
                                                colonias.forEach(colonia => {
                                                        const option = document.createElement('option');
                                                        
                                                        option.value = colonia;
                                                        option.text = colonia;
                                                       
                                                        coloniasss.appendChild(option);
                                                        
                                                });  
                                                const option2 = document.createElement('option');    
                                                option2.value = 'Otro';
                                                option2.text = 'Otro'; 
                                                coloniasss.appendChild(option2);
                                        }
                                };
                                client.send();
                        } else {
                                console.log("No se encuentra un código postal");
                        }
                }
        </script>

        <script>
                /*           async function codigoP(){
                        const cpInput = document.getElementById('codpostal').value;
                        console.log("Codigo postal ingresado: " , cpInput);
                                if(cpInput.length === 5){
                                        const consulta = `https://api.copomex.com/query/get_colonia_por_cp/${cpInput}?token=5ca44c82-8279-4e9c-acb6-456663c20d13` ;
                                        const respuesta = await fetch(consulta);
                                        console.log("Respuesta de la API: " , respuesta);
                                        const datos = await respuesta.json();
                                        console.log("Datos obtenidos: " , datos);
                                        const opciones = datos.response.colonia.map(colonia => `<option value="${colonia}">${colonia}</option>`);
                                        const sselect = `<select>${opciones.join('')}</select>`;
                                        console.log("HTML generado: " , sselect);
                                        document.getElementById('colonias').innerHTML = sselect;
                                } else {
                                        document.getElementById('colonias').innerHTML = '';
                                }
                }

                document.getElementById('codpostal').addEventListener('input' , codigoP); */
        </script>

        <?php
        /*   if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $codigo = $_POST['codpostal'];
                $consulta = "https://api.copomex.com/query/get_colonia_por_cp/$codigo?token=5ca44c82-8279-4e9c-acb6-456663c20d13";
                $ch = curl_init($consulta);
                curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
                curl_setopt($ch , CURLOPT_TIMEOUT , 1);
                $coloniass = curl_exec($ch);
                $httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
                $error_connection = curl_error($ch);
                curl_close($ch);

                if($httpcode==200){
                        $opciones = json_decode($coloniass, true);
                        $opciones_html = '';
                        foreach($opciones['response']['colonia'] as $colonia){
                                $opciones_html .= '<option value="' . $colonia . '">' . $colonia . '</option>';
                        } 
                } else{
                        echo "Error: " . $error_connection;
                }
        } */
        ?>
        <!-- <select> <?php /* echo $opciones_html;*/ ?></select> -->
</body>

</html>