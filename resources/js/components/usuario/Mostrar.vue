<template>
    <div class="container">
        <Header></Header>
        <div  style="margin-top:80px;">
            <div class="row">
                <div class="col mt-2">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="btnradio1" v-on:click="mostrarUsuarios('PREPARADOR')">Preparadores</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2" v-on:click="mostrarUsuarios('REPARTIDOR')">Repartidores</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3" v-on:click="mostrarUsuarios('SUPERADMIN')">Administradores</label>

                    </div> 
                </div>
                <div class="col-1 text-end mt-2">
                    <!-- Button trigger modal -->
                    <button type="button"  v-on:click="cargar()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
            <div class="row gy-4 my-4">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6"  v-for="usuario in usuarios" :key="usuario.idusuario">
                    <div class="card h-100"> 
                        <div class="card-header text-center bg-primary">
                        <h1 class="text-white">{{ usuario.nombre.charAt(0) + usuario.primerApellido.charAt(0) }}</h1>
                        </div>      
                        <div class="card-body">    
                             <div class="row">
                                <div class="col-2"><i class="fas fa-user"></i></div>
                                <div class="col-10"><h6>{{ usuario.nombre + ' ' + usuario.primerApellido + ' ' + usuario.segundoApellido }}</h6> </div>   
                            </div>   
                            <div class="row my-2">
                                <div class="col-2" align="center"><i class="fas fa-envelope"></i></div>
                                <div class="col-10"><h6>{{ usuario.email }}</h6></div>   
                            </div>  
                            <div class="row">
                                <div class="col-2"><i class="fas fa-phone-alt"></i></div>
                                <div class="col-10"><h6>{{ usuario.telefono }}</h6></div>   
                            </div>
                        </div>
                        <div class="card-footer" style="background-color: #fff;">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal" v-on:click="cargar(usuario)">Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Control de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="buscarUsuario" id="formBuscarUsuario">
                        <div class="input-group">
                        <input type="email" class="form-control rounded" placeholder="Correo" aria-label="Search" aria-describedby="search-addon" v-model="correoBuscar" required/>
                            <button type="submit" class="btn btn-outline-primary">Buscar</button>
                        </div>
                    </form>
                    <div class="row mt-4" id="usuarioModal">
                        <div class="row">
                            <div class="col-2"><i class="fas fa-user"></i></div>
                            <div class="col"><h6>{{ usuarioModal.nombre + ' ' + usuarioModal.primerApellido + ' ' + usuarioModal.segundoApellido }}</h6> </div>   
                        </div>   
                        <div class="row my-2">
                            <div class="col-2"><i class="fas fa-envelope"></i></div>
                            <div class="col"><h6>{{ usuarioModal.email }}</h6></div>   
                        </div>  
                        <div class="row">
                            <div class="col-2"><i class="fas fa-phone-alt"></i></div>
                            <div class="col"><h6>{{ usuarioModal.telefono }}</h6></div>   
                        </div>  
                        <div class="row mt-4">
                            <div class="col-2"><i class="fas fa-user-cog"></i></div>
                            <div class="col">
                                <select class="form-select w-auto" v-model="usuarioModal.rol" aria-label="Default select example">
                                    <option value="USUARIO">Usuario</option>
                                    <option value="PREPARADOR">Preparador</option>
                                    <option value="REPARTIDOR">Repartidor</option>
                                    <option value="ADMIN">Admin</option>
                                    <option value="SUPERADMIN">SuperAdmin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" v-on:click="actualizarUsuario()" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from '../Header.vue';
import auth from '../auth/auth.vue';
export default {
    name:"usuarios",
    components:{
        Header
    },
    data(){
        return {
            usuarioModal:{
                idUsuario:'',
                nombre:'',
                primerApellido:'',
                segundoApellido:'',
                email:'',
                rol:''
            },
            usuarios:[],
            rolSeleccionado:'',
            correoBuscar:''
        }
    },
    mounted(){
        this.mostrarUsuarios('PREPARADOR')
    },
    methods:{
        async mostrarUsuarios(rol){
            var token = await auth.refreshToken()
            if(token != ''){
                const config = {
                        headers:{
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer ' + token
                        }
                    }

                await this.axios.get('/api/user/rol/' + rol,config).then(response=>{
                    this.usuarios = response.data.data
                    this.rolSeleccionado = rol
                }).catch(error=>{
                    console.log(error)
                    this.usuarios = []
                })
            }
        },
        async buscarUsuario(){
            var token = await auth.refreshToken()
            if(token != ''){
                const config = {
                    headers:{
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                }

                await this.axios.get('/api/user/email/' + this.correoBuscar,config).then(response=>{
                    this.usuarioModal = response.data.data
                    document.getElementById('usuarioModal').style.display= 'block'
                }).catch(error=>{
                    console.log(error)
                    this.usuarioModal = null
                })
            }
        },
        async actualizarUsuario(){
            var token = await auth.refreshToken()
            if(token != ''){
                const config = {
                    headers:{
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                }

                await this.axios.put('/api/user/' + this.usuarioModal.idUsuario,{rol: this.usuarioModal.rol},config).then(response=>{
                    this.mostrarUsuarios(this.rolSeleccionado)
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        cargar(usuario){
            if(usuario){
                document.getElementById('formBuscarUsuario').style.display= 'none'
                document.getElementById('usuarioModal').style.display= 'block'
                this.usuarioModal = Object.assign({}, usuario)
            }
            else{
                document.getElementById('formBuscarUsuario').style.display='block'
                document.getElementById('usuarioModal').style.display= 'none'
                this.usuarioModal = {
                    idUsuario:'',
                    nombre:'',
                    primerApellido:'',
                    segundoApellido:'',
                    email:'',
                    rol:''
                }
                this.correoBuscar=''
                
            }
        }
    }
}
</script>