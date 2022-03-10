const Home = () => import('./components/Home.vue')
const Login = () => import('./components/auth/Login.vue')
const NotFound = () => import('./components/NotFound.vue')

//importamos los componentes para el Producto
const MostrarProducto = () => import('./components/producto/Mostrar.vue')
const Crear = () => import('./components/producto/Crear.vue')
const Editar = () => import('./components/producto/Editar.vue')

//Componentes de Usuario
const MostrarUsuario = () => import('./components/usuario/Mostrar.vue')

export const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'home',
        path: '/',
        component: Home,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'mostrarProductos',
        path: '/productos',
        component: MostrarProducto,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'crearProducto',
        path: '/crear',
        component: Crear,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'editarProducto',
        path: '/editar/:id',
        component: Editar,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'mostrarUsuarios',
        path: '/usuarios',
        component: MostrarUsuario,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    { 
        name: 'NotFound',
        path: '/:pathMatch(.*)*',  
        component: NotFound 
    }
]