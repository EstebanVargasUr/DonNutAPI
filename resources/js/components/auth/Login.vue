<style>
       .bg{
           background-image: url("https://i2.wp.com/turevistadecocina.com/wp-content/uploads/2018/04/IMG_4471.jpg");
           background-position: center center;
            width:75%;
            height:100vh;
           
            background-size: cover;
       }
   </style>
   <template>
       <div class="container-fluid bg-primary">
           <div class="row align-items-stretch">
               <div class="col bg d-none d-lg-block col-lg-8 col-md-6 col-sm-4 col-2" >

               </div>
               <div class="col bg-white p-5" style="width:25%;height:100vh;">
                   <div class="text-end">
                       <img src="https://cdn.discordapp.com/attachments/800098498699591680/906642215110078545/unknown.png"
                       width="80" alt="">
                   </div>

                   <h2 class="fw-bold text-left py-5">Bienvenido a Don-Nut</h2>

                   <form @submit.prevent="login">
                       <div class="mb-4">
                           <label for="email" class="form-label">Correo electrónico</label>
                           <input type="email" class="form-control" v-model="email" name="email"
                            pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" maxlength="50" required>
                       </div>
                       <div class="mb-4">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control" v-model="password" name="password"
                            maxlength="30" required>
                       </div>
                       <div class="mb-4 form-check">
                           <input type="checkbox" name="connected" class="form-check-input" v-model="recordarme">
                           <label for="connected" class="form-check-label">Recordarme</label>
                       </div>
                       <div class="d-grid">
                           <button class="btn btn-primary">Iniciar Sesión</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
    
</template>

<script>
import alerts from '../Alerts.vue';
export default {
    name:"auth",
    data(){
        return {
            email: 'juan@gmail.com',
            password: '12345678',
            recordarme: false
        }
    },
    methods:{
        async login(){
            alerts.loading()
            await this.axios.post('/api/auth/login',{
                email: this.email,
                password: this.password
            }).then(response=>{
               this.me(response.data)
            }).catch(error=>{
                alerts.error('Error de autenticación', error.response.data.error)
                console.log(error.response.data)
            })
        },
        async me(data){
            const config = {
                headers:{
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + data.token
                }
            }
            await this.axios.post('/api/auth/me',{},config).then(response=>{
               if(response.data.rol=='SUPERADMIN'){
                   localStorage.setItem('token', JSON.stringify(data))
                   localStorage.setItem('user', JSON.stringify(response.data))
                   Swal.fire({title:"¡Bienvenido "+response.data.nombre+"!"});
                   this.$router.push('/')   
                }else{
                   alerts.error('Error de privilegios', 'Esta cuenta no posee los privilegios necesarios')
                   console.log('Esta cuenta no posee los privilegios necesarios')
                }
            }).catch(error=>{
                alerts.error('Oops...', error.response.data.error)
                console.log(error.response.data)
            })
        },
    }
}
</script>