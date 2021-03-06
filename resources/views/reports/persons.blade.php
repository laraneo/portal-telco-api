<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 40px;

                /** Extra personal styles **/
                border: 1px solid black;
                border-top: 0px;
                border-left: 0px;
                border-right: 0px;
                border-bottom: 1px solid black;
                text-align: left;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 30px; 

                text-align: center;
                line-height: 35px;
            }
            .page-number:before {
                content: "Pagina " counter(page);
            }
            thead th{
                font-size: 8px;
                border-bottom: 1px black solid;
                padding-bottom: 5px;
                text-align: left;
            }
            tbody td{
                font-size: 8px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
        }

        </style>
    </head>
    <body>
            <header>Reporte General</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>Parentesco</th>
                        <th>Nombre</th>
                        <th>Rif/CI</th>
                        <th>Pasaporte</th>
                        <th>Carnet</th>
                        <th>Telf</th>
                        <th>Cel</th>
                        <th>Correo</th>
                        <th>Sexo</th>
                        <th>Status</th>
                   </tr>
               <thead>
                <tbody>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ $element->shareList }}</td> 
                        <td> {{ $element->relation }} </td> 
                        <td>{{ $element->name }} {{ $element->last_name }}</td> 
                        <td>{{ $element->rif_ci }}</td> 
                        <td>{{ $element->passport }}</td> 
                        <td>{{ $element->card_number }}</td> 
                        <td>{{ $element->telephone1 }}</td> 
                        <td>{{ $element->phone_mobile1 }}</td> 
                        <td>{{ $element->primary_email }}</td> 
                        <td>{{ $element->gender()->first()->description }}</td> 
                        <td>{{ $element->statusPerson()->first()->description }}</td> 
                    </tr> 
                @endforeach
                 <tbody>
            </table>
    </body>
</html>