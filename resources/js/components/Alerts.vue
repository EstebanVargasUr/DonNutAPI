<script>
export default {
    loading(){
        Swal.fire({
            title: 'Cargando...',
            html: 'Por favor espere...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });   
    },
    error(title,text){
        Swal.fire({
        icon: 'error',
        title: title,
        text: text
        })
    },
    success(title,text){
        wal.fire({
            icon: 'success',
            title: title,
            text: text
        })
    }
}
</script>