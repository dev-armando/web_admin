(function () {

    'use strict'

    var formData = new FormData();

    var itemState = document.querySelectorAll('.item-state');
    
    itemState.forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            formData.append('state', Number(e.target.dataset.state));
            formData.append('id', Number(e.target.dataset.id));

            console.log(Number(e.target.dataset.state));

            fetch('/edit/update_state.php', {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                document.getElementById('dropdownMenuButton2').classList.remove('status-0');
                document.getElementById('dropdownMenuButton2').classList.remove('status-1');
                document.getElementById('dropdownMenuButton2').classList.remove('status-2');
                document.getElementById('dropdownMenuButton2').classList.remove('status-3');

                document.getElementById('dropdownMenuButton2').classList.add('status-' + data.status == '3' ?  '2' : data.status );

                if ( data.status == 0 ) {
                    document.getElementById('dropdownMenuButton2').innerHTML = 'En Proceso';
                } else if ( data.status == 1 ) {
                    document.getElementById('dropdownMenuButton2').innerHTML = 'En Pausa';
                } else if ( data.status == 3 ) {
                    document.getElementById('dropdownMenuButton2').innerHTML = 'Inactivo';
                }else {
                    document.getElementById('dropdownMenuButton2').innerHTML = 'Cancelado';
                }

                console.log(data);
            })
            .catch(function (e) {
                console.log('Something went wrong');
            })
        })
    });

})();