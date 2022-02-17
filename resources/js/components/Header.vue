<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <router-link class="navbar-brand" :to='{name:"home"}'>
                <!-- llamamos al logo -->
                <img src="https://cdn.discordapp.com/attachments/800098498699591680/906642215110078545/unknown.png" alt="" width="30" height="24">
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <router-link exact-active-class="active" to="/" class="nav-link active" aria-current="page">Inicio</router-link>
                </li>
                <li class="nav-item">
                    <router-link exact-active-class="active" to="/productos" class="nav-link">productos</router-link>
                </li>         
            </ul>
            <div class="text-end">
                <a v-on:click="cerrarSesion"><i class="fas fa-sign-out-alt"></i></a>
            </div>
            </div>
            
        </div>
    </nav>
</template>
 
<script>
export default {
    methods:{
        async cerrarSesion(){
            const config = {
                headers:{
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('token')).token
                }
            }
            await axios.post('/api/auth/logout','',config).then(response=>{
                localStorage.clear()
                this.$router.push('login')
            }).catch(error=>{
                if(error.response.status===401){
                    localStorage.clear()
                    this.$router.push('login')
                }
                console.log(error.response.data.message)
            })
        }
    }
}
</script>