<template>
<div class="container">
    <Header></Header>
    <form class="row g-3 mt-5" @submit.prevent="actualizar">
        <div class="col">
            <label>Nombre del producto</label>
            <input type="text" class="form-control" v-model="producto.nombre">
            <label>El nombre del producto no puede exceder los 50 carácteres</label>
    
            <div class="row">
                <div class="col">
                    <label>Categoría</label>
                    <select class="form-select" v-model="producto.tipo" v-on:change="ocultarBanner" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="Saladas">Saladas</option>
                        <option value="Dulces">Dulces</option>
                        <option value="Banner">Banner</option>
                    </select>
                </div>
                <div class="col">
                    <label>Estado</label>
                    <select class="form-select" v-model="producto.estado" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="REVISION">Revisión</option>
                        <option value="ACTIVO">Activo</option>
                        <option value="INACTIVO">Inactivo</option>
                    </select>
                    
                </div>
            </div>
    
            <label>Descripción</label>
            <div class="form-floating">
                <textarea class="form-control" id="floatingTextarea2" v-model="producto.descripcion" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Contenido</label>
            </div>
            <label>La Descripción no pude exceder los 200 carácteres.</label>
                             
        </div>
        <div class="col">
            <label>Imágenes del Producto</label>
            <div class="row">
                <div class="form-group">
                    <input name="image" type="file" accept="image/jpeg,image/gif,image/png" id="file-field" v-on:change="updatePreviewPrincipal" style="display:none;">
                </div>
                <div class="form-group">
                    <input name="image2" type="file" accept="image/jpeg,image/gif,image/png" id="file-field2" v-on:change="updatePreviewBanner" style="display:none;">
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="height:15rem;width:15rem; object-fit: cover; ">
                    <div class="hovereffect">
                        <img class="card-img-top" v-bind:src="producto.imgProducto" alt="" style="height:15rem;width:15rem; object-fit: cover;">
                        <div class="overlay" v-on:click="openUpload('file-field')">
                            <h2>Seleccionar Imagen</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="banner" style="width:15rem; object-fit: cover;">
                    <div class="hovereffect">
                        <img class="card-img-top" v-bind:src="producto.imgBanner" alt="" style="max-height:15rem;width:15rem; object-fit: cover;">
                        <div class="overlay" v-on:click="openUpload('file-field2')">
                            <h2>Seleccionar Imagen</h2>
                        </div>
                    </div>
                </div>
                <label>Se recomienda usar el formato 1:1 para la imagen principal y un tamaño aproximado a 
                        los 300 pixeles. Para la imagen del banner se puede hacer uso de formato panoramico.
                </label>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
</div>
</template>

<script>
import Header from '../Header.vue';
import auth from '../auth/auth.vue';
export default {
    name:"editar-producto",
    components:{
        Header
    },
    data(){
        return {
            producto:[{
                idProducto:"",
                nombre:"",
                tipo:"",
                precio:"",
                imgBanner:"",
                imgProducto:"",
                descripcion:"",
                fechaRegistro:"",
                estado:"",
            }],
            imgPreviewPrincipal:null,
            imgPreviewBanner:null
        }
    },
    mounted(){
        this.mostrarproducto()
        
    },
    methods:{
        async mostrarproducto(){
            await this.axios.get(`/api/productos/${this.$route.params.id}`).then(response=>{
                this.producto = response.data.data
                this.ocultarBanner()
            }).catch(error=>{
                console.log(error)
                this.producto = []
            })
        },
        ocultarBanner(){
            if(this.producto.tipo === 'Banner'){
                console.log('cambio')
                document.getElementById('banner').style.display = 'block';
            }else{
                console.log(this.producto.imgBanner)
                document.getElementById('banner').style.display = 'none';
            }
            
        },
        openUpload (element) {
        document.getElementById(element).click()
        },
        updatePreviewPrincipal (e) {
            this.imgPreviewPrincipal = e.target.files[0]
            console.log('e', e)
            var reader, files = e.target.files
            if (files.length === 0) {
            console.log('Empty')
            }else{
            reader = new FileReader();
            reader.onload = (e) => {
            this.producto.imgProducto = e.target.result
            }
            reader.readAsDataURL(files[0])}
        },
        updatePreviewBanner (e) {
            this.imgPreviewBanner = e.target.files[0]
            console.log('e', e)
            var reader, files = e.target.files
            if (files.length === 0) {
            console.log('Empty')
            }else{
            reader = new FileReader();
            reader.onload = (e) => {
            this.producto.imgBanner = e.target.result
            }
            reader.readAsDataURL(files[0])}
        },
        async actualizar(){
            var token = await auth.refreshToken()
            if(token != ''){
                const config = {
                    headers:{
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + token
                    }
                }
                const fd = new FormData()
                fd.append('nombre',this.producto.nombre)
                fd.append('tipo',this.producto.tipo)
                fd.append('precio',this.producto.precio)
                if(this.imgPreviewBanner != null && this.producto.tipo==='Banner') fd.append('imgBanner',this.imgPreviewBanner)
                if(this.imgPreviewPrincipal != null) fd.append('imgProducto',this.imgPreviewPrincipal)
                fd.append('descripcion',this.producto.descripcion)
                fd.append('estado',this.producto.estado)
                fd.append('_method','put')

                await this.axios.post(`/api/productos/${this.$route.params.id}`,fd,config).then(response=>{
                    this.$router.push({name:"mostrarProductos"})
                }).catch(error=>{
                    console.log(error)
                    console.log(response.data)
                })
            }
        }
    }
}
</script>


<style>
  .hovereffect {
width:100%;
float:left;
overflow:hidden;
position:relative;
text-align:center;
cursor:default;
}

.hovereffect .overlay {
width:100%;
height:100%;
cursor: pointer;
position:absolute;
overflow:hidden;
top:0;
left:0;
opacity:0;
background-color:rgba(0,0,0,0.5);
-webkit-transition:all .4s ease-in-out;
transition:all .4s ease-in-out
}

.hovereffect img {
display:block;
position:relative;
-webkit-transition:all .4s linear;
transition:all .4s linear;
}

.hovereffect h2 {
text-transform:uppercase;
color:#fff;
text-align:center;
position:relative;
font-size:17px;
background:rgba(0,0,0,0.6);
-webkit-transform:translatey(-100px);
-ms-transform:translatey(-100px);
transform:translatey(-100px);
-webkit-transition:all .2s ease-in-out;
transition:all .2s ease-in-out;
padding:10px;
}

.hovereffect a.info {
text-decoration:none;
display:inline-block;
text-transform:uppercase;
color:#fff;
border:1px solid #fff;
background-color:transparent;
opacity:0;
filter:alpha(opacity=0);
-webkit-transition:all .2s ease-in-out;
transition:all .2s ease-in-out;
margin:50px 0 0;
padding:7px 14px;
}

.hovereffect a.info:hover {
box-shadow:0 0 5px #fff;
}

.hovereffect:hover img {
-ms-transform:scale(1.2);
-webkit-transform:scale(1.2);
transform:scale(1.2);
}

.hovereffect:hover .overlay {
opacity:1;
filter:alpha(opacity=100);
}

.hovereffect:hover h2,.hovereffect:hover a.info {
opacity:1;
filter:alpha(opacity=100);
-ms-transform:translatey(0);
-webkit-transform:translatey(0);
transform:translatey(0);
}

.hovereffect:hover a.info {
-webkit-transition-delay:.2s;
transition-delay:.2s;
}
</style>