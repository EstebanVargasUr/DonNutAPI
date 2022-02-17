<script>
export default {
    async refreshToken(){
        var currentDate = Date.now() / 1000
        var expires_in = JSON.parse(localStorage.getItem('token')).expires_in
        const config = {
            headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('token')).token
            }
        }

        if(expires_in < currentDate){
            await axios.post('/api/auth/refresh','',config).then(response=>{
                localStorage.setItem('token',  JSON.stringify(response.data))
                return response.data.token
            }).catch(error=>{
                if(error.response.status===401){
                    localStorage.clear()
                    this.$router.push('login')
                }
                console.log(error.response.data.message)
                return '';
            })
        }
        return JSON.parse(localStorage.getItem('token')).token;
    }
}
</script>