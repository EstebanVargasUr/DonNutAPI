<template>
    <div class="container">
        <Header></Header>
        <div  style="margin-top:80px;">

            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio1" v-on:click="tabs('')">Todo</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2" v-on:click="tabs('Dulces')">Dulces</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio3" v-on:click="tabs('Saladas')">Saladas</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio4" v-on:click="tabs('Banners')">Banners</label>
            </div> 

            <div class="row mt-4">
                <div class="col">
                    <input class="form-control me-2 w-40" v-on:keyup="buscar" v-model="DatoBuscar" type="search" placeholder="Buscar" aria-label="Buscar">
                </div>
                <div class="col text-end">
                    <router-link :to='{name:"crearProducto"}' class="btn btn-primary w-10"><i class="fas fa-plus-circle"></i></router-link>
                </div>
            </div>
            

            <div class="row gy-4 my-4">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6"  v-for="producto in productosMostrar" :key="producto.idProducto">
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
            productos:[],
            productosMostrar:[],
            TempProductosMostrar:[],
            DatoBuscar:''
        }
    },
    mounted(){
        this.mostrarproductos()
    },
    methods:{
        async mostrarproductos(){
            await this.axios.get('/api/productos').then(response=>{
                this.productos = response.data.data
                this.TempProductosMostrar = this.productos
                this.productosMostrar =  this.TempProductosMostrar
            }).catch(error=>{
                console.log(error)
                this.productos = []
            })
        },
        tabs(tipo){
            this.TempProductosMostrar = this.productos.filter(producto => producto.tipo.match(tipo))
            this.productosMostrar =  this.TempProductosMostrar
        },
        buscar(){
            this.productosMostrar = this.TempProductosMostrar.filter(producto => producto.nombre.toUpperCase().match(this.DatoBuscar.toUpperCase()));
        }
    }
}
</script>