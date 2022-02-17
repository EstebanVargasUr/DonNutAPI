<template>
    <div class="container">
        <Header></Header>
        <div  style="margin-top:80px;">
            <div class="row mt-4">
                <div class="col">
                    <form class="d-flex">
                    <input class="form-control me-2 w-40" type="search" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="col text-end">
                    <router-link :to='{name:"crearProducto"}' class="btn btn-primary w-10"><i class="fas fa-plus-circle"></i></router-link>
                </div>
            </div>
            

            <div class="row gy-4 my-4">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6"  v-for="producto in productos" :key="producto.idProducto">
                    <div  class="card h-100">       
                            <img v-bind:src="producto.imgProducto" class="card-img-top" alt="images">
                            <div class="card-body">
                                <h5 class="card-title">{{ producto.nombre }}</h5>
                            </div>
                            <div class="card-footer" style="background-color: #fff;">
                                <router-link :to='{name:"editarProducto",params:{id:producto.idProducto}}' class="btn btn-primary w-100">Ver más</router-link>
                            </div>
                    </div>
                    
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="card h-100">
                    <img src="https://static.wixstatic.com/media/7d2a1b_a2d6e3f9e8a94937aaf9d6e3e8253a64~mv2.png/v1/fill/w_515,h_414,al_c,q_85/DonutBox_1240x460_edited.webp" class="card-img-top" alt="images">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                    <div class="card-footer" style="background-color: #fff;">
                            <a href="#" class="btn btn-primary w-100">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</template>

<script>
import Header from '../Header.vue';
export default {
    name:"productos",
    components:{
        Header
    },
    data(){
        return {
            productos:[]
        }
    },
    mounted(){
        this.mostrarproductos()
    },
    methods:{
        async mostrarproductos(){
            await this.axios.get('/api/productos').then(response=>{
                this.productos = response.data.data
            }).catch(error=>{
                console.log(error)
                this.productos = []
            })
        }
    }
}
</script>