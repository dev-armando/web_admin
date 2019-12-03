(function () {
    'use strinct'

    var tbody = document.getElementById('tbody');
    var fromDate = document.getElementById('from-date');
    var toDate = document.getElementById('to-date');
    var makeQuery = document.getElementById('make-query');
    var formData = new FormData();

    fetch('/buscar/get-info.php', {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(function (data) {
        data.map(function (project) {

            switch(project.pestado) {
                case('0'):
                    var state = 'En Proceso';
                    break;
                case('1'):
                    var state = 'En Pausa';
                    break;
                default:
                    var state = 'Cancelado';
            }

            var tr = `
                
                    <tr>
                        <td>${ project.nombre }</td>
                        <td>${ project.pcliente }</td>
                        <td>${ state }</td>
                        <td>${ project.pdesde }</td>
                        <td>${ project.phasta }</td>
                        <td><a href="edit?@=${ project.idp }"><i class="far fa-edit"></i></a></td>
                    </tr>
                
            `

            var pdesde = `
                <option value="${ project.pdesde }">${ project.pdesde }</option>
            `

            var phasta = `
                <option value="${ project.phasta }">${ project.phasta }</option>
            `

            tbody.innerHTML += tr;
            fromDate.innerHTML += pdesde
            toDate.innerHTML += phasta
        })
    });

    document.getElementById('search').addEventListener('keyup', function (e) {
        formData.append('qa', e.target.value)
        fetch('/buscar/get-info.php', {
            method: 'POST',
            body: formData
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            tbody.innerHTML = '';
            if ( !data.length ) {
                tbody.innerHTML = 'No se encontraron resultados';
            } else {
                data.map(function (project) {

                    switch(project.pestado) {
                        case('0'):
                            var state = 'En Proceso';
                            break;
                        case('1'):
                            var state = 'En Pausa';
                            break;
                        default:
                            var state = 'Cancelado';
                    }

                    var tr = `
                        
                            <tr>
                                <td>${project.nombre}</td>
                                <td>${project.pcliente}</td>
                                <td>${ state }</td>
                                <td>${ project.pdesde }</td>
                                <td>${ project.phasta }</td>
                                <td><a href="edit?@=${project.idp}"><i class="far fa-edit"></i></a></td>
                            </tr>
                        
                    `
                    tbody.innerHTML += tr;
                })
            }
        })
        .catch(function (err) {
            console.log(err);
        })
    })

    makeQuery.addEventListener('click', function (e) {
        e.preventDefault();

        if ( fromDate.value == 'Desde' || toDate.value == 'Hasta' ) {
            alert('Selecciona la fecha desde y la fecha hasta')
        } else {

            formData.append('from-date', fromDate.value);
            formData.append('to-date', toDate.value);

            fetch('/buscar/get-info.php', {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                tbody.innerHTML = '';
                if ( !data.length) {
                    tbody.innerHTML = 'No se encontraron resultados';
                } else {
                    data.map(function (project) {

                        switch(project.pestado) {
                            case('0'):
                                var state = 'En Proceso';
                                break;
                            case('1'):
                                var state = 'En Pausa';
                                break;
                            default:
                                var state = 'Cancelado';
                        }

                        var tr = `
                            <tbody>
                                <tr>
                                    <td>${project.nombre}</td>
                                    <td>${project.pcliente}</td>
                                    <td>${ state }</td>
                                    <td>${ project.pdesde }</td>
                                    <td>${ project.phasta }</td>
                                    <td><a href="edit?@=${project.idp}"><i class="far fa-edit"></i></a></td>
                                </tr>
                            </tbody>
                        `
                        tbody.innerHTML += tr;
                    })
                }
            })
            .catch(function (err) {
                console.log(err);
            })

        }

    })

})();