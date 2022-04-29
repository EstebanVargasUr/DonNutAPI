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

                   <h2 class="fw-bold text-left py-5">Cambiar Contraseña</h2>

                    <form @submit.prevent="cambiarPassword">
                       <div class="mb-4">
                           <label for="password" class="form-label">Nueva Contraseña</label>
                           <input type="password" class="form-control" name="password" v-model="password" 
                            maxlength="16" minlength="6" required>
                       </div>
                        <div class="mb-4">
                           <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                           <input type="password" class="form-control" name="password_confirm" v-model="password_confirmation"
                            maxlength="16" minlength="6" required>
                       </div>
                       <div class="mt-5 d-grid">
                           <button type="submit" class="btn btn-primary">Cambiar</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
    
</template>


<script>
import alerts from '../Alerts.vue';
export default {
    name:"passwordReset",
    data(){
        return {
            password: '',
            password_confirmation: ''
        }
    },
    mounted(){
        console.log(this.$route.query.token)
    },
    methods:{
        async cambiarPassword(){
            alerts.loading()
            await this.axios.post('/api/auth/resetPassword',{
                token: this.$route.params.token,
                password: this.password,
                password_confirmation: this.password_confirmation
            }).then(response=>{
               alerts.success('Buen trabajo!','Su cambio de contraseña ha sido exitoso')
            }).catch(error=>{
                alerts.error('Oops...',error.response.data.error)
                console.log(response.data)
            })
        },
    }
}
</script>