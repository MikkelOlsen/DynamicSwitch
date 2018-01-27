document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type=radio]').forEach( (elm) => {
        elm.addEventListener('click', (e) => {
            // console.log(e.target.id)
            if(e.target.id == 'newDB') {
                document.getElementById('db_name_group').classList.remove('hidden')
            } else if(e.target.id == 'currentDB') {
                document.getElementById('db_name_group').classList.add('hidden')
            }
        })
    })
    console.log('test')
})