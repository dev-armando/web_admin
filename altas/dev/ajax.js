(function () {
    'use strinct'

    var tbody = document.getElementById('tbody');
    var fromDate = document.getElementById('from-date');
    var toDate = document.getElementById('to-date');
    var makeQuery = document.getElementById('make-query');
    var user_id = document.getElementById('user_id').value;
    var formData = new FormData();

    fetch(`/dev/get-info.php/?user_id=${user_id}`, {
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(function (data) {
        data.map(function (project) {

            var tr = ` 
                <tr>
                    <td>${ project.nombre }</td>
                    <td><a href="add/?@=${ project.idp }">Cargar horas</a> ||
                    <a href="ver/?@=${ project.idp }">Historial de horas</a></td>
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
        formData.append('qa', e.target.value);
        formData.append('user_id', user_id);
        fetch(`/dev/get-info.php/?user_id=${user_id}`, {
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

                    var tr = `
                        
                            <tr>
                                <td>${project.nombre}</td>
                                <td><a href="add/?@=${project.idp}">Cargar horas</a></td>
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
            formData.append('user_id', user_id);

            fetch(`/dev/get-info.php/?user_id=${user_id}`, {
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

                        var tr = `
                            <tbody>
                                <tr>
                                    <td>${project.nombre}</td>
                                    <td><a href="add/?@=${project.idp}">Cargar horas</a></td>
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